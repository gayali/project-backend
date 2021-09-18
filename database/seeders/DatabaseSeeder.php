<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role as RoleName;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $this->createPermissions();
        $this->createRoles();
        $this->assignAdminRoleToUser();
    }


    public function createPermissions()
    {
        $resources = ['User', 'Project', 'Task', 'TaskComment'];
        $functions = ['create', 'update', 'read', 'delete'];

            foreach ($resources as $resource) {
                foreach ($functions as $function) {
                    Permission::create(['name' => $function . $resource]);
                }
            }
        
    }

    public function createRoles()
    {
        Role::create(['name' => RoleName::ADMIN])->givePermissionTo(Permission::all());
        Role::create(['name' => RoleName::USER])->givePermissionTo($this->getUserPermissions());
    }


    public function assignAdminRoleToUser()
    {
        $admin=User::create([
            'name'=>'Gaurav Gayali',
            'email'=>'cg.36.central@gmail.com',
            'password'=>'Welcome@54321'
        ]);
        $admin->assignRole(RoleName::ADMIN);
        
    }

    private function getUserPermissions()
    {
        return [
            'readProject',
            'readTask',
            'updateTask',
            'createTaskComment',
            'readTaskComment',
            'updateTaskComment',
        ];
    }
}
