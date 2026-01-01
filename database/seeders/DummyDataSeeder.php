<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bangladeshi names for customers
        $customerNames = [
            'Abdul Rahman', 'Fatima Begum', 'Mohammad Ali', 'Ayesha Khatun', 'Hasan Ahmed',
            'Rashida Akter', 'Karim Uddin', 'Nusrat Jahan', 'Shahid Hossain', 'Rokeya Begum',
            'Iqbal Hossain', 'Sharmin Akter', 'Rafiqul Islam', 'Nasima Begum', 'Tariqul Islam',
            'Jahanara Begum', 'Salam Miah', 'Rashida Khatun', 'Mizanur Rahman', 'Shahana Begum',
            'Kamrul Hasan', 'Shirin Akter', 'Mofiz Uddin', 'Nargis Begum', 'Rashid Ahmed',
            'Farida Begum', 'Shahidul Islam', 'Rokeya Khatun', 'Mamun Hossain', 'Shabnam Akter'
        ];

        $customerEmails = [
            'abdul.rahman@email.com', 'fatima.begum@email.com', 'mohammad.ali@email.com',
            'ayesha.khatun@email.com', 'hasan.ahmed@email.com', 'rashida.akter@email.com',
            'karim.uddin@email.com', 'nusrat.jahan@email.com', 'shahid.hossain@email.com',
            'rokeya.begum@email.com', 'iqbal.hossain@email.com', 'sharmin.akter@email.com',
            'rafiqul.islam@email.com', 'nasima.begum@email.com', 'tariqul.islam@email.com',
            'jahanara.begum@email.com', 'salam.miah@email.com', 'rashida.khatun@email.com',
            'mizanur.rahman@email.com', 'shahana.begum@email.com', 'kamrul.hasan@email.com',
            'shirin.akter@email.com', 'mofiz.uddin@email.com', 'nargis.begum@email.com',
            'rashid.ahmed@email.com', 'farida.begum@email.com', 'shahidul.islam@email.com',
            'rokeya.khatun@email.com', 'mamun.hossain@email.com', 'shabnam.akter@email.com'
        ];

        $phoneNumbers = [
            '01712345678', '01823456789', '01934567890', '01545678901', '01656789012',
            '01767890123', '01878901234', '01989012345', '01590123456', '01601234567',
            '01712345098', '01823450987', '01934560986', '01545670985', '01656780984',
            '01767890983', '01878900982', '01989010981', '01590120980', '01601230979',
            '01712345908', '01823456897', '01934567786', '01545678675', '01656789564',
            '01767890453', '01878901342', '01989012231', '01590123120', '01601234019'
        ];

        $addresses = [
            'Dhanmondi, Dhaka', 'Gulshan, Dhaka', 'Banani, Dhaka', 'Uttara, Dhaka',
            'Mirpur, Dhaka', 'Wari, Dhaka', 'Old Dhaka', 'Mohakhali, Dhaka',
            'Tejgaon, Dhaka', 'Ramna, Dhaka', 'Lalbagh, Dhaka', 'Sutrapur, Dhaka',
            'Motijheel, Dhaka', 'Farmgate, Dhaka', 'Shahbagh, Dhaka'
        ];

        $statuses = ['pending', 'in_progress', 'completed', 'delivered', 'cancelled'];
        $garmentTypes = ['shirt', 'pant', 'suit'];
        
        // Create 30 customers
        $customers = [];
        for ($i = 0; $i < 30; $i++) {
            $customers[] = Customer::create([
                'name' => $customerNames[$i],
                'email' => $customerEmails[$i],
                'phone' => $phoneNumbers[$i],
                'address' => $addresses[array_rand($addresses)],
            ]);
        }

        // Create orders spread over the last 12 months
        $ordersCreated = 0;
        $totalOrders = 80; // Create 80 orders

        for ($month = 11; $month >= 0; $month--) {
            $ordersThisMonth = rand(5, 10); // 5-10 orders per month
            
            for ($j = 0; $j < $ordersThisMonth && $ordersCreated < $totalOrders; $j++) {
                $customer = $customers[array_rand($customers)];
                $status = $statuses[array_rand($statuses)];
                $garmentType = $garmentTypes[array_rand($garmentTypes)];
                
                // Random date within the month
                $orderDate = Carbon::now()->subMonths($month)->subDays(rand(0, 28));
                $deliveryDate = $orderDate->copy()->addDays(rand(7, 30));
                
                // Random amount between 300 and 2000
                $totalAmount = rand(30000, 200000) / 100; // Convert to decimal
                
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'order_date' => $orderDate,
                    'status' => $status,
                    'total_amount' => $totalAmount,
                    'description' => 'Custom tailored ' . $garmentType . ' order',
                    'garment_type' => $garmentType,
                    'delivery_date' => $deliveryDate,
                    'notes' => rand(0, 1) ? 'Special instructions provided' : null,
                ]);

                // Add measurements based on garment type
                if ($garmentType === 'shirt') {
                    $order->update([
                        'chest' => rand(3600, 4200) / 100, // 36-42 inches
                        'waist' => rand(3000, 3800) / 100, // 30-38 inches
                        'shoulder_width' => rand(1600, 1900) / 100, // 16-19 inches
                        'sleeve_length' => rand(2300, 2600) / 100, // 23-26 inches
                        'shirt_length' => rand(2700, 3000) / 100, // 27-30 inches
                        'neck' => rand(1400, 1600) / 100, // 14-16 inches
                        'armhole' => rand(1700, 2000) / 100, // 17-20 inches
                        'bicep' => rand(1100, 1400) / 100, // 11-14 inches
                        'wrist' => rand(600, 900) / 100, // 6-9 inches
                    ]);
                } elseif ($garmentType === 'pant') {
                    $order->update([
                        'waist' => rand(3000, 3800) / 100, // 30-38 inches
                        'hip' => rand(3600, 4200) / 100, // 36-42 inches
                        'inseam' => rand(2800, 3200) / 100, // 28-32 inches
                        'outseam' => rand(3800, 4200) / 100, // 38-42 inches
                        'thigh' => rand(2200, 2800) / 100, // 22-28 inches
                        'knee' => rand(1600, 2000) / 100, // 16-20 inches
                        'ankle' => rand(1200, 1600) / 100, // 12-16 inches
                        'pant_length' => rand(3800, 4200) / 100, // 38-42 inches
                    ]);
                } elseif ($garmentType === 'suit') {
                    $order->update([
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
                    ]);
                }

                $ordersCreated++;
            }
        }

        $this->command->info("Created {$ordersCreated} orders for " . count($customers) . " customers!");
    }
}
