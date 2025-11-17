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
        // 1️⃣ Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator'], ['guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user'], ['guard_name' => 'web']);

        // 2️⃣ Create Admin Account
        $admin = User::factory()->withPhone()->create([
            'name' => 'Admin',
            'email' => 'admin@repairhousebreda.nl',
            'phone_number' => '0612345678',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // 3️⃣ Create Additional Staff
        $moderator = User::factory()->withPhone()->create([
            'name' => 'Moderator',
            'email' => 'moderator@repairhousebreda.nl',
            'phone_number' => '0687654321',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $moderator->assignRole($moderatorRole);

        // 4️⃣ Create Regular Users (some with accounts, some without)
        $regularUsers = User::factory(15)->create();
        foreach ($regularUsers as $user) {
            $user->assignRole($userRole);
        }

        // 5️⃣ Create Repair Types (realistic phone brands and repairs)
        RepairType::factory(25)->create();

        // 6️⃣ Create Appointments with different statuses
        // Pending appointments
        Appointment::factory(8)->pending()->create();
        
        // In progress appointments (with sub-statuses)
        Appointment::factory(5)->inProgress()->create();
        
        // Completed appointments
        Appointment::factory(12)->completed()->create();
        
        // Cancelled appointments
        Appointment::factory(3)->cancelled()->create();
        
        // Admin-created appointments (without user_id)
        Appointment::factory(4)->withoutUser()->create();

        // 7️⃣ Create Offers
        // Active offers
        Offer::factory(5)->active()->create([
            'created_by' => $admin->id,
        ]);
        
        // Expired offers
        Offer::factory(3)->expired()->create([
            'created_by' => $admin->id,
        ]);
        
        // Upcoming offers
        Offer::factory(2)->upcoming()->create([
            'created_by' => $moderator->id,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@repairhousebreda.nl / password');
        $this->command->info('Moderator: moderator@repairhousebreda.nl / password');
    }
}
