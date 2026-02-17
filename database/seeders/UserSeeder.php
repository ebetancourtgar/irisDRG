<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Aqui Creamos los roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $gteAlmacenRole = Role::firstOrCreate(['name' => 'Gte. Almacen']);
        $operationsSupervisorRole = Role::firstOrCreate(['name' => 'Operations Supervisor']);

        //Aqui almacenamos los permisos en la variable $permissions
        $permissions = [
            'manage users',
        ];

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $adminRole->givePermissionTo($perm);
        }

        $adminRole->syncPermissions($permissions); 
        
        $admin = User::create(
        [
            'email' => 'admin@drg.mx',
            'name' => 'Admin DRG',
            'password' => bcrypt('password'),
            
        ]);
        $gteAlmacen = User::create(
            [
                'email' => 'gtealmacen@drg.mx',
                'name' => 'Karla Burciaga',
                'password' => bcrypt('kc1BcI8u'),
            ]
        );
        $operationsSupervisor = User::create(
            [
                'email' => 'asanchez@drg.mx',
                'name' => 'Operations Supervisor',
                'password' => bcrypt('Ajelet#26'),
            ]
        );

        $admin->assignRole($adminRole);
        $gteAlmacen->assignRole($gteAlmacenRole);
        $operationsSupervisor->assignRole($operationsSupervisorRole);


    }
}
