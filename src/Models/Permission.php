<?php

namespace Motor\Backend\Models;

use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Motor\Backend\Models\Permission
 *
 * @property int                                                                                  $id
 * @property int|null                                                                             $permission_group_id
 * @property string                                                                               $name
 * @property string                                                                               $guard_name
 * @property \Illuminate\Support\Carbon|null                                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                                      $updated_at
 * @property-read \Motor\Backend\Models\PermissionGroup|null                                      $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[]       $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\Backend\Models\User[]           $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission permission( $permissions )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission role( $roles, $guard = null )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission whereGuardName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission wherePermissionGroupId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Permission whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    use Searchable;
    use Filterable;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'name',
        'guard_name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_group_id',
        'name',
        'guard_name'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(config('motor-backend.models.permission_group'), 'permission_group_id');
    }
}
