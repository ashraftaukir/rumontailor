<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];

        foreach ($validated['items'] as $itemData) {
            $itemMeasurements = [];
            foreach ($measurementFields as $field) {
                $itemMeasurements[$field] = $itemData[$field] ?? null;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'garment_type' => $itemData['garment_type'],
                'price' => $itemData['price'],
                'description' => $itemData['description'] ?? null,
                'notes' => $itemData['notes'] ?? null,
                ...$itemMeasurements
            ]);
        }

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
        // Validate order basic info
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,delivered,cancelled',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:order_items,id',
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
        $existingItemIds = collect($validated['items'])->pluck('id')->filter()->toArray();
        
        // Delete items that are no longer in the request
        $order->items()->whereNotIn('id', $existingItemIds)->delete();

        // Create or update order items
        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];

        foreach ($validated['items'] as $itemData) {
            $itemMeasurements = [];
            foreach ($measurementFields as $field) {
                $itemMeasurements[$field] = $itemData[$field] ?? null;
            }

            $itemDataToSave = [
                'garment_type' => $itemData['garment_type'],
                'price' => $itemData['price'],
                'description' => $itemData['description'] ?? null,
                'notes' => $itemData['notes'] ?? null,
                ...$itemMeasurements
            ];

            if (isset($itemData['id']) && $itemData['id']) {
                // Update existing item
                $order->items()->where('id', $itemData['id'])->update($itemDataToSave);
            } else {
                // Create new item
                $order->items()->create($itemDataToSave);
            }
        }

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
