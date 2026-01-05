<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        if ($customers->isEmpty()) {
            $this->command->error('No customers found. Please seed customers first.');
            return;
        }

        $statuses = ['pending', 'in_progress', 'completed', 'delivered', 'cancelled'];
        $garmentTypes = ['shirt', 'pant', 'suit'];
        
        $orderNumberCounter = 1;

        // Create 100 orders
        for ($i = 0; $i < 100; $i++) {
            // Random customer
            $customer = $customers->random();
            
            // Random order date within last 6 months
            $orderDate = Carbon::now()->subMonths(rand(0, 6))->subDays(rand(0, 30));
            $deliveryDate = $orderDate->copy()->addDays(rand(7, 30));
            
            // Random status
            $status = $statuses[array_rand($statuses)];
            
            // Determine number of items: 60% single item, 30% two items, 10% three or more items
            $rand = rand(1, 100);
            if ($rand <= 60) {
                $itemCount = 1;
            } elseif ($rand <= 90) {
                $itemCount = 2;
            } else {
                $itemCount = rand(3, 4);
            }
            
            // Generate order number
            $orderNumber = 'ORD-' . str_pad($orderNumberCounter++, 6, '0', STR_PAD_LEFT);
            
            // Target average order value: 700 Tk
            // Calculate target total with some variation (500-900 Tk range, centered around 700)
            $targetTotal = rand(50000, 90000) / 100; // 500.00 to 900.00 Tk
            
            // Create order items first to calculate total
            $items = [];
            $totalAmount = 0;
            
            // Distribute the target total across items
            $remainingTotal = $targetTotal;
            
            for ($j = 0; $j < $itemCount; $j++) {
                $garmentType = $garmentTypes[array_rand($garmentTypes)];
                
                // For the last item, use remaining amount
                if ($j === $itemCount - 1) {
                    $price = round($remainingTotal, 2);
                } else {
                    // Distribute price across items with variation
                    if ($itemCount === 1) {
                        $price = $targetTotal;
                    } else {
                        // Each item gets a portion, with some variation
                        $basePrice = $targetTotal / $itemCount;
                        $variation = $basePrice * 0.3; // 30% variation
                        $price = $basePrice + rand(-$variation * 100, $variation * 100) / 100;
                        // Ensure minimum price of 150 Tk per item
                        $price = max(150, $price);
                        $price = round($price, 2);
                    }
                }
                
                $totalAmount += $price;
                $remainingTotal -= $price;
                
                // Generate measurements based on garment type
                $measurements = $this->generateMeasurements($garmentType);
                
                $items[] = [
                    'garment_type' => $garmentType,
                    'price' => $price,
                    'description' => 'Custom tailored ' . $garmentType,
                    'notes' => rand(0, 1) ? 'Special instructions provided' : null,
                    ...$measurements
                ];
            }
            
            // Create order
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => $orderNumber,
                'order_date' => $orderDate,
                'status' => $status,
                'total_amount' => $totalAmount,
                'description' => "Order with {$itemCount} item(s)",
                'garment_type' => $items[0]['garment_type'], // Primary garment type for backward compatibility
                'delivery_date' => $deliveryDate,
                'notes' => rand(0, 1) ? 'Customer requested special attention' : null,
            ]);
            
            // Create order items
            foreach ($items as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'garment_type' => $itemData['garment_type'],
                    'price' => $itemData['price'],
                    'description' => $itemData['description'],
                    'notes' => $itemData['notes'],
                    'chest' => $itemData['chest'] ?? null,
                    'waist' => $itemData['waist'] ?? null,
                    'shoulder_width' => $itemData['shoulder_width'] ?? null,
                    'sleeve_length' => $itemData['sleeve_length'] ?? null,
                    'shirt_length' => $itemData['shirt_length'] ?? null,
                    'jacket_length' => $itemData['jacket_length'] ?? null,
                    'neck' => $itemData['neck'] ?? null,
                    'armhole' => $itemData['armhole'] ?? null,
                    'bicep' => $itemData['bicep'] ?? null,
                    'wrist' => $itemData['wrist'] ?? null,
                    'hip' => $itemData['hip'] ?? null,
                    'inseam' => $itemData['inseam'] ?? null,
                    'outseam' => $itemData['outseam'] ?? null,
                    'thigh' => $itemData['thigh'] ?? null,
                    'knee' => $itemData['knee'] ?? null,
                    'ankle' => $itemData['ankle'] ?? null,
                    'pant_length' => $itemData['pant_length'] ?? null,
                ]);
            }
        }
        
        $this->command->info('Successfully created 100 orders with single and multiple products!');
        
        // Display statistics
        $singleItemOrders = Order::has('items', '=', 1)->count();
        $multipleItemOrders = Order::has('items', '>', 1)->count();
        $totalItems = OrderItem::count();
        $averageOrderValue = Order::avg('total_amount');
        
        $this->command->info("Orders with single item: {$singleItemOrders}");
        $this->command->info("Orders with multiple items: {$multipleItemOrders}");
        $this->command->info("Total order items created: {$totalItems}");
        $this->command->info("Average order value: " . number_format($averageOrderValue, 2) . " Tk");
    }
    
    /**
     * Generate measurements based on garment type
     */
    private function generateMeasurements(string $garmentType): array
    {
        $measurements = [];
        
        if ($garmentType === 'shirt') {
            $measurements = [
                'chest' => rand(3600, 4200) / 100, // 36-42 inches
                'waist' => rand(3000, 3800) / 100, // 30-38 inches
                'shoulder_width' => rand(1600, 1900) / 100, // 16-19 inches
                'sleeve_length' => rand(2300, 2600) / 100, // 23-26 inches
                'shirt_length' => rand(2700, 3000) / 100, // 27-30 inches
                'neck' => rand(1400, 1600) / 100, // 14-16 inches
                'armhole' => rand(1700, 2000) / 100, // 17-20 inches
                'bicep' => rand(1100, 1400) / 100, // 11-14 inches
                'wrist' => rand(600, 900) / 100, // 6-9 inches
            ];
        } elseif ($garmentType === 'pant') {
            $measurements = [
                'waist' => rand(3000, 3800) / 100, // 30-38 inches
                'hip' => rand(3600, 4200) / 100, // 36-42 inches
                'inseam' => rand(2800, 3200) / 100, // 28-32 inches
                'outseam' => rand(3800, 4200) / 100, // 38-42 inches
                'thigh' => rand(2200, 2800) / 100, // 22-28 inches
                'knee' => rand(1600, 2000) / 100, // 16-20 inches
                'ankle' => rand(1200, 1600) / 100, // 12-16 inches
                'pant_length' => rand(3800, 4200) / 100, // 38-42 inches
            ];
        } elseif ($garmentType === 'suit') {
            $measurements = [
                'chest' => rand(3600, 4200) / 100, // 36-42 inches
                'waist' => rand(3000, 3800) / 100, // 30-38 inches
                'shoulder_width' => rand(1600, 1900) / 100, // 16-19 inches
                'sleeve_length' => rand(2300, 2600) / 100, // 23-26 inches
                'jacket_length' => rand(2800, 3200) / 100, // 28-32 inches
                'hip' => rand(3600, 4200) / 100, // 36-42 inches
                'inseam' => rand(2800, 3200) / 100, // 28-32 inches
                'outseam' => rand(3800, 4200) / 100, // 38-42 inches
                'thigh' => rand(2200, 2800) / 100, // 22-28 inches
                'knee' => rand(1600, 2000) / 100, // 16-20 inches
                'ankle' => rand(1200, 1600) / 100, // 12-16 inches
                'pant_length' => rand(3800, 4200) / 100, // 38-42 inches
            ];
        }
        
        return $measurements;
    }
}

