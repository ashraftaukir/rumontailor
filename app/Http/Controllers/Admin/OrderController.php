<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\CustomerMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('customer');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('phone', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by garment type (check both order and order_items)
        if ($request->filled('garment_type')) {
            $query->where(function($q) use ($request) {
                $q->where('garment_type', $request->garment_type)
                  ->orWhereHas('items', function($itemQuery) use ($request) {
                      $itemQuery->where('garment_type', $request->garment_type);
                  });
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('order_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('order_date', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('admin.orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log raw request data
        \Log::info('Order Store - Raw request data:', ['request' => $request->all()]);
        
        // Validate order basic info
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,delivered,cancelled',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.garment_type' => 'required|in:shirt,pant,suit',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.description' => 'nullable|string',
            'items.*.notes' => 'nullable|string',
            // Measurements for items
            'items.*.chest' => 'nullable|numeric|min:0',
            'items.*.waist' => 'nullable|numeric|min:0',
            'items.*.shoulder_width' => 'nullable|numeric|min:0',
            'items.*.sleeve_length' => 'nullable|numeric|min:0',
            'items.*.shirt_length' => 'nullable|numeric|min:0',
            'items.*.jacket_length' => 'nullable|numeric|min:0',
            'items.*.neck' => 'nullable|numeric|min:0',
            'items.*.armhole' => 'nullable|numeric|min:0',
            'items.*.bicep' => 'nullable|numeric|min:0',
            'items.*.wrist' => 'nullable|numeric|min:0',
            'items.*.hip' => 'nullable|numeric|min:0',
            'items.*.inseam' => 'nullable|numeric|min:0',
            'items.*.outseam' => 'nullable|numeric|min:0',
            'items.*.thigh' => 'nullable|numeric|min:0',
            'items.*.knee' => 'nullable|numeric|min:0',
            'items.*.ankle' => 'nullable|numeric|min:0',
            'items.*.pant_length' => 'nullable|numeric|min:0',
        ]);

        // Calculate total amount from items
        $totalAmount = collect($validated['items'])->sum('price');

        // Define all measurement fields
        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];

        // Debug: Log what we received from validation
        \Log::info('Order Store - Validated items data:', ['items' => $validated['items']]);

        // Normalize items data - ensure all measurement fields are present
        $normalizedItems = [];
        foreach ($validated['items'] as $index => $itemData) {
            $normalizedItem = $itemData;
            // Ensure all measurement fields are present in the array
            foreach ($measurementFields as $field) {
                if (!isset($normalizedItem[$field])) {
                    $normalizedItem[$field] = null;
                }
            }
            \Log::info("Order Store - Normalized item {$index}:", ['item' => $normalizedItem]);
            $normalizedItems[] = $normalizedItem;
        }

        // Use database transaction to ensure data consistency
        $order = DB::transaction(function () use ($normalizedItems, $validated, $totalAmount, $measurementFields) {
            // Create order
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'order_number' => $this->generateOrderNumber(),
                'order_date' => $validated['order_date'],
                'status' => $validated['status'],
                'total_amount' => $totalAmount,
                'description' => $validated['description'] ?? null,
                'delivery_date' => $validated['delivery_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                // Keep garment_type for backward compatibility (use first item's type)
                'garment_type' => $validated['items'][0]['garment_type'],
            ]);

            // Create order items
            foreach ($normalizedItems as $itemIndex => $itemData) {
                $itemMeasurements = [];
                foreach ($measurementFields as $field) {
                    // Get the value from validated data, defaulting to null if not present
                    $value = $itemData[$field] ?? null;
                    
                    // Convert empty strings, null, or falsy values to null
                    // Also ensure numeric values are properly cast
                    if ($value === '' || $value === null || $value === false) {
                        $itemMeasurements[$field] = null;
                    } else {
                        // Cast to float to ensure proper decimal handling
                        $itemMeasurements[$field] = is_numeric($value) ? (float) $value : null;
                    }
                }
                
                \Log::info("Order Store - Item {$itemIndex} measurements to save:", ['measurements' => $itemMeasurements]);

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'garment_type' => $itemData['garment_type'],
                    'price' => $itemData['price'],
                    'description' => isset($itemData['description']) && trim($itemData['description']) !== '' ? trim($itemData['description']) : null,
                    'notes' => isset($itemData['notes']) && trim($itemData['notes']) !== '' ? trim($itemData['notes']) : null,
                    ...$itemMeasurements
                ]);
                
                \Log::info("Order Store - Created order item ID {$orderItem->id}:", ['item' => $orderItem->toArray()]);
                
                // Save measurements to customer_measurements for future use
                $this->saveCustomerMeasurements($validated['customer_id'], $itemData['garment_type'], $itemMeasurements);
            }

            return $order;
        });

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order created successfully with ' . count($validated['items']) . ' item(s).');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('customer');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = Customer::orderBy('name')->get();
        $order->load('items');
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Debug: Log raw request data
        \Log::info('Order Update - Raw request data:', ['request' => $request->all()]);
        
        // Validate order basic info
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,delivered,cancelled',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => [
                'nullable',
                function ($attribute, $value, $fail) use ($order) {
                    if ($value && !$order->items()->where('id', $value)->exists()) {
                        $fail('The selected item does not belong to this order.');
                    }
                },
            ],
            'items.*.garment_type' => 'required|in:shirt,pant,suit',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.description' => 'nullable|string',
            'items.*.notes' => 'nullable|string',
            // Measurements for items
            'items.*.chest' => 'nullable|numeric|min:0',
            'items.*.waist' => 'nullable|numeric|min:0',
            'items.*.shoulder_width' => 'nullable|numeric|min:0',
            'items.*.sleeve_length' => 'nullable|numeric|min:0',
            'items.*.shirt_length' => 'nullable|numeric|min:0',
            'items.*.jacket_length' => 'nullable|numeric|min:0',
            'items.*.neck' => 'nullable|numeric|min:0',
            'items.*.armhole' => 'nullable|numeric|min:0',
            'items.*.bicep' => 'nullable|numeric|min:0',
            'items.*.wrist' => 'nullable|numeric|min:0',
            'items.*.hip' => 'nullable|numeric|min:0',
            'items.*.inseam' => 'nullable|numeric|min:0',
            'items.*.outseam' => 'nullable|numeric|min:0',
            'items.*.thigh' => 'nullable|numeric|min:0',
            'items.*.knee' => 'nullable|numeric|min:0',
            'items.*.ankle' => 'nullable|numeric|min:0',
            'items.*.pant_length' => 'nullable|numeric|min:0',
        ]);

        // Calculate total amount from items
        $totalAmount = collect($validated['items'])->sum('price');

        // Define all measurement fields
        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];

        // Debug: Log validated items data
        \Log::info('Order Update - Validated items data:', ['items' => $validated['items']]);
        
        // Normalize items data - ensure all measurement fields are present
        $normalizedItems = [];
        foreach ($validated['items'] as $index => $itemData) {
            $normalizedItem = $itemData;
            // Ensure all measurement fields are present in the array
            foreach ($measurementFields as $field) {
                if (!isset($normalizedItem[$field])) {
                    $normalizedItem[$field] = null;
                }
            }
            \Log::info("Order Update - Normalized item {$index}:", ['item' => $normalizedItem]);
            $normalizedItems[] = $normalizedItem;
        }

        // Use database transaction to ensure data consistency
        DB::transaction(function () use ($order, $normalizedItems, $validated, $totalAmount, $measurementFields) {
            // Update order
            $order->update([
                'customer_id' => $validated['customer_id'],
                'order_date' => $validated['order_date'],
                'status' => $validated['status'],
                'total_amount' => $totalAmount,
                'description' => $validated['description'] ?? null,
                'delivery_date' => $validated['delivery_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'garment_type' => $validated['items'][0]['garment_type'], // For backward compatibility
            ]);

            // Get existing item IDs
            $existingItemIds = collect($normalizedItems)->pluck('id')->filter()->toArray();
            
            // Delete items that are no longer in the request
            // Only delete if we have existing items to preserve, otherwise delete all existing items
            if (!empty($existingItemIds)) {
                $order->items()->whereNotIn('id', $existingItemIds)->delete();
            } else {
                // If no existing item IDs are provided, delete all existing items (all items are new)
                $order->items()->delete();
            }

            // Create or update order items
            foreach ($normalizedItems as $itemData) {
            $itemMeasurements = [];
            foreach ($measurementFields as $field) {
                // Get the value from validated data, defaulting to null if not present
                $value = $itemData[$field] ?? null;
                
                // Convert empty strings, null, or falsy values to null
                // Also ensure numeric values are properly cast
                if ($value === '' || $value === null || $value === false) {
                    $itemMeasurements[$field] = null;
                } else {
                    // Cast to float to ensure proper decimal handling
                    $itemMeasurements[$field] = is_numeric($value) ? (float) $value : null;
                }
            }

            $itemDataToSave = [
                'garment_type' => $itemData['garment_type'],
                'price' => $itemData['price'],
                'description' => isset($itemData['description']) && trim($itemData['description']) !== '' ? trim($itemData['description']) : null,
                'notes' => isset($itemData['notes']) && trim($itemData['notes']) !== '' ? trim($itemData['notes']) : null,
                ...$itemMeasurements
            ];

            if (isset($itemData['id']) && $itemData['id']) {
                // Update existing item - use model instance to ensure all fields are updated
                $existingItem = $order->items()->where('id', $itemData['id'])->first();
                if ($existingItem) {
                    \Log::info("Order Update - Updating item ID {$itemData['id']}:", [
                        'before' => $existingItem->toArray(),
                        'data_to_save' => $itemDataToSave
                    ]);
                    
                    // Use fill() and save() to ensure all fields are properly updated
                    $existingItem->fill($itemDataToSave);
                    $existingItem->save();
                    
                    // Refresh and verify the update
                    $existingItem->refresh();
                    \Log::info("Order Update - Item ID {$itemData['id']} after update:", ['item' => $existingItem->toArray()]);
                } else {
                    \Log::warning("Order Update - Item ID {$itemData['id']} not found for order {$order->id}");
                }
            } else {
                // Create new item
                \Log::info("Order Update - Creating new item:", ['data' => $itemDataToSave]);
                $order->items()->create($itemDataToSave);
            }
        }
        });

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order updated successfully with ' . count($validated['items']) . ' item(s).');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Save customer measurements for future use
     */
    private function saveCustomerMeasurements(int $customerId, string $garmentType, array $measurements): void
    {
        // Only save if there are actual measurement values
        $hasMeasurements = false;
        foreach ($measurements as $value) {
            if ($value !== null && $value !== '') {
                $hasMeasurements = true;
                break;
            }
        }

        if (!$hasMeasurements) {
            return;
        }

        // Update or create customer measurement
        CustomerMeasurement::updateOrCreate(
            [
                'customer_id' => $customerId,
                'garment_type' => $garmentType,
            ],
            array_merge($measurements, [
                'customer_id' => $customerId,
                'garment_type' => $garmentType,
            ])
        );
    }

    /**
     * Generate a unique order number
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
