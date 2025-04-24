<?php

namespace Motor\Backend\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Motor\Backend\Models\Permission;
use Motor\Backend\Models\PermissionGroup;

/**
 * Class MotorCreatePermissionsCommand
 */
class MotorCreatePermissionsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'motor:create:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create permissions according to the configuration and write them into the databases permissions table';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $permissions = config('motor-backend-permissions');
        foreach ($permissions as $name => $group) {

            // Check if the group exists
            $permissionGroup = PermissionGroup::where('name', $name)
                ->first();
            if (is_null($permissionGroup)) {
                $permissionGroup = new PermissionGroup;
                $this->info('Creating permission group for '.$name);
            } else {
                $this->info('Updating permission group for '.$name);
            }

            $permissionGroup->name = $name;
            $permissionGroup->sort_position = Arr::get($group, 'sort_position');
            $permissionGroup->save();

            foreach ($group['values'] as $value) {

                // Check if the permission exists
                $permission = Permission::where('name', $name.'.'.$value)
                    ->first();
                if (is_null($permission)) {
                    $this->info('Creating permission for '.$name.' > '.$value);
                    $permission = new Permission;
                    $permission->name = $name.'.'.$value;
                    $permission->guard_name = 'web';
                    $permission->permission_group_id = $permissionGroup->id;
                    $permission->save();
                }
            }
        }
    }
}
