<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = Customer::withCount('orders');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 15);
        $customers = $query->latest()->paginate($perPage);

        return response()->json($customers);
    }

    /**
     * Search customers
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $customers = Customer::where('name', 'like', "%{$request->query}%")
            ->orWhere('email', 'like', "%{$request->query}%")
            ->orWhere('phone', 'like', "%{$request->query}%")
            ->limit(20)
            ->get();

        return response()->json($customers);
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer,
        ], 201);
    }

    /**
     * Display the specified customer
     */
    public function show(Customer $customer)
    {
        $customer->load(['orders', 'measurements']);
        return response()->json($customer);
    }

    /**
     * Get customer measurements by garment type
     */
    public function getMeasurements(Request $request, Customer $customer)
    {
        $garmentType = $request->get('garment_type');
        
        if ($garmentType) {
            $measurement = $customer->getMeasurementByType($garmentType);
            return response()->json([
                'measurement' => $measurement,
            ]);
        }
        
        $measurements = $customer->measurements;
        return response()->json([
            'measurements' => $measurements,
        ]);
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => $customer,
        ]);
    }

    /**
     * Remove the specified customer
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully',
        ]);
    }
}

