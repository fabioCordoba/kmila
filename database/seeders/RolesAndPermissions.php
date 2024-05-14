<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'read roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'read product']);
        Permission::create(['name' => 'update product']);
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'sell product']);



        $role = Role::create(['name' => 'ADMINISTRADOR']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'USER']);
        $role->givePermissionTo('read product');
        $role->givePermissionTo('sell product');
    }
}
