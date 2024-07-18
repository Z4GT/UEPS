<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'crear', 'leer', 'actualizar', 'eliminar', 'reportar',
            'ver auditorias', 'ver proyectos', 'crear proyectos',
            'editar proyectos', 'eliminar proyectos', 'reportar proyectos'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign created permissions
        $roleAdmin = Role::create(['name' => 'administrador']);
        $roleAdmin->givePermissionTo(['crear', 'leer', 'actualizar', 'eliminar', 'reportar', 'ver proyectos', 'reportar proyectos']);

        $roleAuditor = Role::create(['name' => 'auditor']);
        $roleAuditor->givePermissionTo(['leer', 'reportar', 'ver auditorias']);

        $roleCoordinador = Role::create(['name' => 'coordinador']);
        $roleCoordinador->givePermissionTo(['leer', 'reportar', 'ver proyectos', 'reportar proyectos']);

        $roleRector = Role::create(['name' => 'rector']);
        $roleRector->givePermissionTo(['leer', 'reportar', 'crear proyectos', 'editar proyectos', 'eliminar proyectos', 'reportar proyectos']);

        $roleManager = Role::create(['name' => 'jefe de proyecto']);
        $roleManager->givePermissionTo(['leer', 'reportar', 'crear proyectos', 'editar proyectos', 'eliminar proyectos', 'reportar proyectos']);
    }
}
