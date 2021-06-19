<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'donatur'
        ];

        collect($roles)->map(function ($name) {
            Role::query()
                ->updateOrCreate(compact('name'), compact('name'));
        });
    }
}
