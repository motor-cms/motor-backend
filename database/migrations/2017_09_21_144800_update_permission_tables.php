<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class UpdatePermissionTables
 */
class UpdatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $foreignKeys = config('permission.foreign_keys');

        Schema::table('roles', function (Blueprint $table) {
            $table->string('guard_name')->after('name');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('guard_name')->after('name');
        });

        Schema::create(
            $tableNames['model_has_permissions'],
            function (Blueprint $table) use ($tableNames) {
                $table->integer('permission_id')->unsigned();
                $table->morphs('model');

                $table->foreign('permission_id')->references('id')->on($tableNames['permissions'])->onDelete('cascade');

                $table->primary(['permission_id', 'model_id', 'model_type']);
            }
        );

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
            $table->integer('role_id')->unsigned();
            $table->morphs('model');

            $table->foreign('role_id')->references('id')->on($tableNames['roles'])->onDelete('cascade');

            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        // Add guard to permission and role tables
        DB::table('roles')->update(['guard_name' => 'web']);
        DB::table('permissions')->update(['guard_name' => 'web']);

        // Convert data from user_has_permissions and user_has_roles
        foreach (DB::table('user_has_roles')->get() as $ur) {
            $u = \Motor\Backend\Models\User::find($ur->user_id);
            $r = \Motor\Backend\Models\Role::find($ur->role_id);
            $u->assignRole($r->name);
        }

        foreach (DB::table('user_has_permissions')->get() as $up) {
            $u = \Motor\Backend\Models\User::find($up->user_id);
            $p = \Motor\Backend\Models\Permission::find($up->permission_id);
            $u->givePermissionTo($p->name);
        }
        Schema::drop('user_has_roles');
        Schema::drop('user_has_permissions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('user_has_permissions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);
        });

        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('guard_name');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('guard_name');
        });
    }
}
