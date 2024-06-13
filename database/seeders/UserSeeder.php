<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'super-admin',
                'email' => 'admin@admin.com',
                'password'=>bcrypt('admin'),
                'status'  => 1,
                'module_id'  => 1,
                'email_verified_at'  => Carbon::now()->toDateTimeString(),
            ]
        ];
        foreach ($users as $user) {
            $user = User::create($user);

            // Assign specific roles to the user
            $rolesToAssign = ['super-admin', 'manager']; // Replace these with your desired role names

            foreach ($rolesToAssign as $roleName) {
                $role = Role::where('name', $roleName)->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }
        }

        // foreach ($users as $user){
        //     $user = User::create($user);
        //     $user->assignRole(Role::all());
        // }
    }
}
