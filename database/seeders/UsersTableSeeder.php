<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'id' => 1,
            'name' => 'test1',
            'email' => 'test1@example.com',
        ]);
        User::factory()->create([
            'id' => 2,
            'name' => 'test2',
            'email' => 'test2@example.com',
        ]);
    }
}
