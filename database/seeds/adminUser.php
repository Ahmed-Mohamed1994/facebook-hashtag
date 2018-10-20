<?php

use Illuminate\Database\Seeder;

class adminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'address' => 'address',
            'phone' => '0123456789',
            'password' => bcrypt('admin'),
            'type' => 'ADMIN',
            'image' => 'admin/image.png'
        ]);
    }
}
