<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = array (
            0 => 
            array (
                'name' => 'BANK BRI',
                'code' => '002',
                'path_image' => '/img/bank/bri.png'
            ),
            1 => 
            array (
                'name' => 'BANK BNI',
                'code' => '009',
                'path_image' => '/img/bank/bni.png'
            ),
            2 => 
            array (
                'name' => 'BANK BCA',
                'code' => '014',
                'path_image' => '/img/bank/bca.png'
            ),
        );

        collect($bank)->map(function ($item) {
            Bank::query()
                ->updateOrCreate(
                    [
                        'code' => $item['code']
                    ],
                    [
                        'code' => $item['code'],
                        'name' => $item['name'],
                        'path_image' => $item['path_image']
                    ]
                );
        });
    }
}
