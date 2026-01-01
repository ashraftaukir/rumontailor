<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('customer')
            ->latest()
            ->paginate(15);
        
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
        // Ensure all measurement fields are present (set to null if missing or empty)
        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];
        
        $data = $request->all();
        foreach ($measurementFields as $field) {
            // If field is not in request or is empty string, set to null
            if (!isset($data[$field]) || $data[$field] === '') {
                $data[$field] = null;
            }
        }
        $request->merge($data);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,delivered,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'garment_type' => 'required|in:shirt,pant,suit',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            // Measurements
            'jacket_length' => 'nullable|numeric|min:0',
            'chest' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'shoulder_width' => 'nullable|numeric|min:0',
            'sleeve_length' => 'nullable|numeric|min:0',
            'shirt_length' => 'nullable|numeric|min:0',
            'neck' => 'nullable|numeric|min:0',
            'armhole' => 'nullable|numeric|min:0',
            'bicep' => 'nullable|numeric|min:0',
            'wrist' => 'nullable|numeric|min:0',
            'hip' => 'nullable|numeric|min:0',
            'inseam' => 'nullable|numeric|min:0',
            'outseam' => 'nullable|numeric|min:0',
            'thigh' => 'nullable|numeric|min:0',
            'knee' => 'nullable|numeric|min:0',
            'ankle' => 'nullable|numeric|min:0',
            'pant_length' => 'nullable|numeric|min:0',
        ]);

        // Ensure all measurement fields are in validated array (even if null)
        foreach ($measurementFields as $field) {
            if (!isset($validated[$field])) {
                $validated[$field] = null;
            }
        }

        // Generate unique order number
        $validated['order_number'] = $this->generateOrderNumber();

        Order::create($validated);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order created successfully.');
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
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Ensure all measurement fields are present (set to null if missing or empty)
        $measurementFields = [
            'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
            'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
            'thigh', 'knee', 'ankle', 'pant_length'
        ];
        
        $data = $request->all();
        foreach ($measurementFields as $field) {
            // If field is not in request or is empty string, set to null
            if (!isset($data[$field]) || $data[$field] === '') {
                $data[$field] = null;
            }
        }
        $request->merge($data);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,delivered,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'garment_type' => 'required|in:shirt,pant,suit',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            // Measurements
            'jacket_length' => 'nullable|numeric|min:0',
            'chest' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'shoulder_width' => 'nullable|numeric|min:0',
            'sleeve_length' => 'nullable|numeric|min:0',
            'shirt_length' => 'nullable|numeric|min:0',
            'neck' => 'nullable|numeric|min:0',
            'armhole' => 'nullable|numeric|min:0',
            'bicep' => 'nullable|numeric|min:0',
            'wrist' => 'nullable|numeric|min:0',
            'hip' => 'nullable|numeric|min:0',
            'inseam' => 'nullable|numeric|min:0',
            'outseam' => 'nullable|numeric|min:0',
            'thigh' => 'nullable|numeric|min:0',
            'knee' => 'nullable|numeric|min:0',
            'ankle' => 'nullable|numeric|min:0',
            'pant_length' => 'nullable|numeric|min:0',
        ]);

        // Ensure all measurement fields are in validated array (even if null)
        foreach ($measurementFields as $field) {
            if (!isset($validated[$field])) {
                $validated[$field] = null;
            }
        }

        $order->update($validated);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
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
