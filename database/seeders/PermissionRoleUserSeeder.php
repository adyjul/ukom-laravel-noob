<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionRoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        $user = \App\Models\User::factory()->create([
            'name' => 'SuperAdmin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($role3);

        $permisionProdiProposal = CreatePermission::create('Prodi_Menu_Proposal');
        $permisionProdiDudi = CreatePermission::create('Prodi_Menu_Dudi');

        $permisionProdi = array_merge($permisionProdiProposal, $permisionProdiDudi);
        CreateRole::createRole('web', 'Prodi', $permisionProdi);
        // $role3 = Role::create(['name' => 'PIC Prodi']);
        // create permissions

        // create roles and assign existing permissions
        // $role1 = Role::create(['name' => 'admin']);
        // $role1->givePermissionTo('create users');
        // $role1->givePermissionTo('update users');
        // $role1->givePermissionTo('delete users');
        // $role1->givePermissionTo('view users');
        // $role1->givePermissionTo('restore users');

        // CreatePermission::create('permissions');

        // In login method check the loged-in user Role
    }
}
