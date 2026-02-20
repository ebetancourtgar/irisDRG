<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Crear Roles (Usamos firstOrCreate para evitar errores si ya existen)
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $directorrole = Role::firstOrCreate(['name' => 'Direccion']);
        $gteAlmacenRole = Role::firstOrCreate(['name' => 'Gte. Almacen']);
        $operationsSupervisorRole = Role::firstOrCreate(['name' => 'Supervisor de Operaciones']);
        $roleCallCenter = Role::firstOrCreate(['name' => 'Call Center']); // Cambiado de create a firstOrCreate
        $roleTecnico = Role::firstOrCreate(['name' => 'Tecnico']); // Cambiado de create a firstOrCreate
        

        // 2. Definir y Crear Permisos
        $permissions = [
            'manage users',
            'manage products',
            'manage services',
            'view user', 'create user', 'edit user',
            'view branch', 'create branch', 'edit branch',
            'manage schedules', 'view schedule', 'create schedule', 'edit schedule', 'delete schedule',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        
        // Admin: Todos los permisos
        $adminRole->syncPermissions($permissions);
        $directorrole->syncPermissions($permissions);

        // Call Center
        $roleCallCenter->syncPermissions([
            'view schedule', 'create schedule',
            'view branch'
        ]);

        // Tecnico
        $roleTecnico->syncPermissions(['view schedule']);

        $operationsSupervisorRole->syncPermissions([
            'manage schedules', 'view schedule', 'create schedule', 'edit schedule', 'delete schedule',
            'view branch'
        ]);

        $gteAlmacenRole->syncPermissions([
            'manage products', 
            'view branch',
            'view schedule'
        ]);

        //Usuarios
        $admin = User::firstOrCreate(
            ['email' => 'admin@drg.mx'], // Busca por email
            [
                'name' => 'Admin DRG',
                'password' => bcrypt('password'),
                'branch_id' => '1',
            ]
        );

        $direccion = User::firstOrCreate(
            ['email' => 'jreyes@drg.mx'],
            [
                'name' => 'Javier Reyes',
                'password' => bcrypt('password'),
                'branch_id' => '1',
            ]
        );

        $gteAlmacen = User::firstOrCreate(
            ['email' => 'gtealmacen@drg.mx'],
            [
                'name' => 'Karla Burciaga',
                'password' => bcrypt('kc1BcI8u'),
                'branch_id' => '1',
            ]
        );

        $operationsSupervisor = User::firstOrCreate(
            ['email' => 'asanchez@drg.mx'],
            [
                'name' => 'Ajelet Sanchez',
                'password' => bcrypt('Ajelet#26'),
                'branch_id' => '1',
            ]
        );

        $callCenterUser = User::firstOrCreate(
            ['email' => 'mcarrillo@drg.mx'],
            [
                'name' => 'Marlene Carrillo',
                'password' => Hash::make('password'),
                'branch_id' => '1',
            ]
        );

        $tecnicoUser = User::firstOrCreate(
            ['email' => 'lfernando@drg.mx'],
            [
                'name' => 'Luis Fernando',
                'password' => Hash::make('password'),
                'branch_id' => '1',
            ]
        );

        $admin->assignRole($adminRole);
        $direccion->assignRole($directorrole);
        $gteAlmacen->assignRole($gteAlmacenRole);
        $operationsSupervisor->assignRole($operationsSupervisorRole);
        $callCenterUser->assignRole($roleCallCenter);
        $tecnicoUser->assignRole($roleTecnico);
    }
}