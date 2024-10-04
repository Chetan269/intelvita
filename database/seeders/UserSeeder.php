<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['full_name' => 'Jacob'],
            ['full_name' => 'Boss'],
            ['full_name' => 'Charlie'],
            ['full_name' => 'James'],
            ['full_name' => 'Denver'],
            ['full_name' => 'Lio'],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'full_name' => $userData['full_name'],
            ]);
        }
    }
}
