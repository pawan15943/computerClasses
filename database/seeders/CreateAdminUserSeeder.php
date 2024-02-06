<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();

        if ($user) {
            // Find or create the 'admin' role
            $adminRole = Role::firstOrCreate(['name' => 'admin']);

            // Assign the 'admin' role to the user
            $user->assignRole($adminRole);

            
        }

      
    }
}
