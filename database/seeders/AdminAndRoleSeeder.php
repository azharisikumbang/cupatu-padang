<?php

namespace Database\Seeders;

use App\Contract\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create roles
        $avalableRoles = Roles::cases();
        foreach ($avalableRoles as $role) {
            Role::create(['name' => $role->value]);
        }

        // administrator
        $user = User::factory()->create([
            'name' => 'administrator',
            'email'=> 'admin@web.local',
            'password'=> Hash::make('12345678'),
        ]);

        $administratorRole = Role::where('name', Roles::ADMINISTRATOR->value)->first();

        $user->assignRole($administratorRole);
    }
}
