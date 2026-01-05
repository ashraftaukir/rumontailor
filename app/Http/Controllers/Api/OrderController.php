<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items']);

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

        // Filter by garment type
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

        $perPage = $request->get('per_page', 15);
        $orders = $query->latest()->paginate($perPage);

        return response()->json($orders);
    }

    /**
     * Search orders
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $orders = Order::with(['customer', 'items'])
            ->where('order_number', 'like', "%{$request->query}%")
            ->orWhereHas('customer', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->query}%");
            })
            ->limit(20)
            ->get();

        return response()->json($orders);
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
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

        $totalAmount = collect($validated['items'])->sum('price');

        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];

        $order = DB::transaction(function () use ($validated, $totalAmount, $measurementFields) {
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'order_number' => $this->generateOrderNumber(),
                'order_date' => $validated['order_date'],
                'status' => $validated['status'],
                'total_amount' => $totalAmount,
                'description' => $validated['description'] ?? null,
                'delivery_date' => $validated['delivery_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'garment_type' => $validated['items'][0]['garment_type'],
            ]);

            foreach ($validated['items'] as $itemData) {
                $itemMeasurements = [];
                foreach ($measurementFields as $field) {
                    $value = $itemData[$field] ?? null;
                    $itemMeasurements[$field] = ($value === '' || $value === null || $value === false) 
                        ? null 
                        : (is_numeric($value) ? (float) $value : null);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'garment_type' => $itemData['garment_type'],
                    'price' => $itemData['price'],
                    'description' => isset($itemData['description']) && trim($itemData['description']) !== '' ? trim($itemData['description']) : null,
                    'notes' => isset($itemData['notes']) && trim($itemData['notes']) !== '' ? trim($itemData['notes']) : null,
                    ...$itemMeasurements
                ]);
                
                // Save measurements to customer_measurements for future use
                $this->saveCustomerMeasurements($validated['customer_id'], $itemData['garment_type'], $itemMeasurements);
            }

            return $order->load(['customer', 'items']);
        });

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ], 201);
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'items']);
        return response()->json($order);
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, Order $order)
    {
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

        $totalAmount = collect($validated['items'])->sum('price');

        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];

        DB::transaction(function () use ($order, $validated, $totalAmount, $measurementFields) {
            $order->update([
                'customer_id' => $validated['customer_id'],
                'order_date' => $validated['order_date'],
                'status' => $validated['status'],
                'total_amount' => $totalAmount,
                'description' => $validated['description'] ?? null,
                'delivery_date' => $validated['delivery_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'garment_type' => $validated['items'][0]['garment_type'],
            ]);

            $existingItemIds = collect($validated['items'])->pluck('id')->filter()->toArray();
            
            if (!empty($existingItemIds)) {
                $order->items()->whereNotIn('id', $existingItemIds)->delete();
            } else {
                $order->items()->delete();
            }

            foreach ($validated['items'] as $itemData) {
                $itemMeasurements = [];
                foreach ($measurementFields as $field) {
                    $value = $itemData[$field] ?? null;
                    $itemMeasurements[$field] = ($value === '' || $value === null || $value === false) 
                        ? null 
                        : (is_numeric($value) ? (float) $value : null);
                }

                $itemDataToSave = [
                    'garment_type' => $itemData['garment_type'],
                    'price' => $itemData['price'],
                    'description' => isset($itemData['description']) && trim($itemData['description']) !== '' ? trim($itemData['description']) : null,
                    'notes' => isset($itemData['notes']) && trim($itemData['notes']) !== '' ? trim($itemData['notes']) : null,
                    ...$itemMeasurements
                ];

                if (isset($itemData['id']) && $itemData['id']) {
                    $existingItem = $order->items()->where('id', $itemData['id'])->first();
                    if ($existingItem) {
                        $existingItem->update($itemDataToSave);
                    }
                } else {
                    $order->items()->create($itemDataToSave);
                }
                
                // Save measurements to customer_measurements for future use
                $this->saveCustomerMeasurements($validated['customer_id'], $itemData['garment_type'], $itemMeasurements);
            }
        });

        $order->load(['customer', 'items']);

        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order,
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order->load(['customer', 'items']),
        ]);
    }

    /**
     * Remove the specified order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
        ]);
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

