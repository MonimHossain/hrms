<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the permission table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('roles')->truncate();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();


        $roles = [
            'Super Admin',
            'Admin',
            'User',
         ];


         foreach ($roles as $role) {
            Role::create(
                [
                'name' => $role,
                ]
            );
         }

        // super admin Role
        $superAdmin = \App\User::find(1);
        $superAdmin->syncRoles('Super Admin');
    }
}
