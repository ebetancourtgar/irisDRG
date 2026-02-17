<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Aqui Creamos los roles
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $gteAlmacenRole = Role::firstOrCreate(['name' => 'Gte. Almacen']);
        $operationsSupervisorRole = Role::firstOrCreate(['name' => 'Supervisor de Operaciones']);
        $roleCallCenter = Role::create(['name' => 'Call Center']);
        $roleTecnico = Role::create(['name' => 'Tecnico']);

        //Aqui almacenamos los permisos en la variable $permissions
        $permissions = [
            'manage users',
            'view user', 'create user', 'edit user',
            'view branch', 'create branch', 'edit branch',
            'view schedule', 'create schedule', 'edit schedule', 'delete schedule',
        ];

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $adminRole->givePermissionTo($perm);
        }

        //Asignamos los permisos al rol admin, el metodo syncPermissions se encarga de sincronizar los permisos
        // del rol con los permisos que le estamos asignando, es decir, si el rol ya tiene permisos 
        // asignados y le asignamos nuevos permisos, el metodo syncPermissions se encargara de eliminar 
        // los permisos que ya tenia el rol y asignarle los nuevos permisos, en 
        // este caso le estamos asignando todos los permisos que tenemos en la variable $permissions, 
        // por lo que el rol admin tendra todos los permisos disponibles en la aplicacion.
        $adminRole->syncPermissions($permissions); 

        //Asignamos permisos a los roles
        $roleCallCenter->givePermissionTo([
            'view schedule', 'create schedule',
            'view branch'
        ]);
        $roleTecnico->givePermissionTo(['view schedule']);

        
        $admin = User::create(
        [
            'email' => 'admin@drg.mx',
            'name' => 'Admin DRG',
            'password' => bcrypt('password'),
            'branch_id' => '1',
            
        ]);
        $gteAlmacen = User::create(
            [
                'email' => 'gtealmacen@drg.mx',
                'name' => 'Karla Burciaga',
                'password' => bcrypt('kc1BcI8u'),
                'branch_id' => '1',
            ]
        );
        $operationsSupervisor = User::create(
            [
                'email' => 'asanchez@drg.mx',
                'name' => 'Ajelet Sanchez',
                'password' => bcrypt('Ajelet#26'),
                'branch_id' => '1',
            ]
        );
        $callCenterUser = User::create([
            'name' => 'Marlene Carrillo',
            'email' => 'mcarrillo@drg.mx',
            'password' => Hash::make('password'),
            'branch_id' => '1',
        ]);
        $tecnicoUser = User::create([
            'name' => 'Luis Fernando',
            'email' => 'lfernando@drg.mx',
            'password' => Hash::make('password'),
            'branch_id' => '1',
        ]);


        

        $admin->assignRole($adminRole);
        $gteAlmacen->assignRole($gteAlmacenRole);
        $operationsSupervisor->assignRole($operationsSupervisorRole);
        $callCenterUser->assignRole($roleCallCenter);
        $tecnicoUser->assignRole($roleTecnico);

        


    }
}
