<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role as RoleName;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $addUser = Permission::findOrCreate('addUser');
        $editUser = Permission::findOrCreate ('editUser');
        $deleteUser = Permission::findOrCreate ('deleteUser');

        $addProject = Permission::findOrCreate ('addProject');
        $editProject = Permission::findOrCreate ('editProject');
        $deleteProject = Permission::findOrCreate ('deleteProject');

        $addTask = Permission::findOrCreate ('addTask');
        $editTask = Permission::findOrCreate ('editTask');
        $deleteTask = Permission::findOrCreate ('deleteTask');

        $addTaskComment = Permission::findOrCreate ('addTaskComment');
        $editTaskComment = Permission::findOrCreate ('editTaskComment');
        $deleteTaskComment = Permission::findOrCreate ('deleteTaskComment');

        $adminRole = Role::findOrCreate (RoleName::ADMIN);
       // $adminRole->roles()->detach();
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::findOrCreate(RoleName::USER);
       // $userRole->roles()->detach();
        $userRole->givePermissionTo($editProject);
        $userRole->givePermissionTo($editTask);
        $userRole->givePermissionTo($addTaskComment);
        $userRole->givePermissionTo($editTaskComment);


        $admin=User::firstOrCreate([
            'name'=>'Gaurav Gayali',
            'email'=>'cg.36.central@gmail.com',
            'password'=>Hash::make('Welcome@54321'),
        ]);
       // $userRole->roles()->detach();
        $admin->assignRole($adminRole);
    }
}
