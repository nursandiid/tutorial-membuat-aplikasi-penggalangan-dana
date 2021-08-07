<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'email' => 'support@w2charity.com',
            'phone' => '081232323221',
            'owner_name' => 'Administrator',
            'company_name' => 'W2 Charity',
            'short_description' => '-',
            'keyword' => '-',
            'about' => '-',
            'address' => '-',
            'postal_code' => 12345,
            'city' => '-',
            'province' => '-'
        ]);
    }
}
