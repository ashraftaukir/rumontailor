<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Extended list of Bangladeshi male names
        $customerNames = [
            'Abdul Rahman', 'Mohammad Ali', 'Hasan Ahmed', 'Karim Uddin', 'Shahid Hossain',
            'Iqbal Hossain', 'Rafiqul Islam', 'Tariqul Islam', 'Salam Miah', 'Mizanur Rahman',
            'Kamrul Hasan', 'Mofiz Uddin', 'Rashid Ahmed', 'Shahidul Islam', 'Mamun Hossain',
            'Anwar Hossain', 'Rashidul Haque', 'Sirajul Islam', 'Mahbub Alam', 'Rafiq Ahmed',
            'Jahangir Alam', 'Shamsul Haque', 'Kamal Hossain', 'Rashidul Islam', 'Mizanur Rahman',
            'Abdul Karim', 'Mohammad Hasan', 'Shahidul Islam', 'Rafiqul Haque', 'Kamrul Islam',
            'Tariqul Haque', 'Iqbal Ahmed', 'Mamunur Rahman', 'Shahid Hossain', 'Rashidul Alam',
            'Anwarul Islam', 'Mahbubur Rahman', 'Jahangir Hossain', 'Shamsul Islam', 'Kamal Uddin',
            'Abdul Aziz', 'Mohammad Rafiq', 'Hasan Ali', 'Karim Hossain', 'Shahid Ahmed',
            'Iqbal Hossain', 'Rafiqul Karim', 'Tariqul Alam', 'Salam Hossain', 'Mizanur Haque',
            'Kamrul Ahmed', 'Mofizul Islam', 'Rashid Rahman', 'Shahidul Haque', 'Mamun Islam'
        ];

        $addresses = [
            'Dhanmondi, Dhaka', 'Gulshan, Dhaka', 'Banani, Dhaka', 'Uttara, Dhaka',
            'Mirpur, Dhaka', 'Wari, Dhaka', 'Old Dhaka', 'Mohakhali, Dhaka',
            'Tejgaon, Dhaka', 'Ramna, Dhaka', 'Lalbagh, Dhaka', 'Sutrapur, Dhaka',
            'Motijheel, Dhaka', 'Farmgate, Dhaka', 'Shahbagh, Dhaka', 'Malibagh, Dhaka',
            'Rampura, Dhaka', 'Badda, Dhaka', 'Khilgaon, Dhaka', 'Shyamoli, Dhaka',
            'Agrabad, Chittagong', 'Pahartali, Chittagong', 'Halishahar, Chittagong',
            'Gulshan-2, Dhaka', 'Dhanmondi 27, Dhaka', 'Banani 11, Dhaka'
        ];

        $phonePrefixes = ['017', '018', '019', '015', '016', '013', '014'];

        // Create 50 customers
        for ($i = 0; $i < 50; $i++) {
            $name = $customerNames[$i] ?? 'Customer ' . ($i + 1);
            $email = strtolower(str_replace(' ', '.', $name)) . '.' . ($i + 1) . '@email.com';
            $phone = $phonePrefixes[array_rand($phonePrefixes)] . rand(10000000, 99999999);
            $address = $addresses[array_rand($addresses)];

            // Ensure unique email
            $email = str_replace([' ', '..'], ['.', '.'], $email);
            $baseEmail = explode('@', $email)[0];
            $counter = 1;
            while (Customer::where('email', $email)->exists()) {
                $email = $baseEmail . $counter . '@email.com';
                $counter++;
            }

            Customer::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
            ]);
        }

        $this->command->info('Successfully created 50 customers!');
    }
}

