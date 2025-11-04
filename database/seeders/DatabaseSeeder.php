<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\RepairType;
use App\Models\Appointment;
use App\Models\Offer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'moderator'], ['guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user'], ['guard_name' => 'web']);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('admin');

        $moderator = User::factory()->create([
            'name' => 'Moderator User',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password')
        ]);
        $moderator->assignRole('moderator');

        $user = User::factory()->create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('user');

        // 3️⃣ RepairTypes
        RepairType::factory()->count(5)->create();

        // 4️⃣ Appointments
        Appointment::factory()->count(10)->create();

        // 5️⃣ Offers
        Offer::factory()->count(5)->create();
    }
}
