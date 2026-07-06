<?php

namespace Database\Seeders;

use App\Models\UserAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        UserAccount::firstOrCreate(
            ['username' => 'admin'],
            ['password' => Hash::make('admin'), 'role' => 'admin']
        );

        UserAccount::firstOrCreate(
            ['username' => 'verifikator1'],
            ['password' => Hash::make('verifikator1'), 'role' => 'verifikator']
        );
    }
}
