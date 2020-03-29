<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Laravue\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'office@alphasoftmedia.com',
            'password' => Hash::make('ERipt88s6bJ1'),
        ]);

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $admin->syncRoles($adminRole);

        $volunteer = User::create([
            'name' => 'Volunteer',
            'email' => 'volunteer@gmail.com',
            'password' => Hash::make('aatuin'),
        ]);

        $volunteerRole = Role::findByName(\App\Laravue\Acl::ROLE_VOLUNTAR);
        $volunteer->syncRoles($volunteerRole);

        factory(App\Solicitation::class, 50)->create();
    }
}
