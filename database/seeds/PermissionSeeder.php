<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $permissions = [
                ['name' => 'user.management', 'description' => 'manage system users'],
                ['name' => 'employee.create', 'description' => 'create employee records'],
                ['name' => 'employee.view', 'description' => 'view employee records'],
                ['name' => 'employee.edit', 'description' => 'edit employee records'],
                ['name' => 'sysvar.management', 'description' => 'system variable management'],
            ];
            $current_permissions = \HCES\Permission::all();
            foreach ($permissions as $permission) {
                if ($current_permissions->where('name', $permission['name'])->first() != null) {
                    continue;
                }
                $permission = new \HCES\Permission($permission);
                $permission->save();
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
