<?php

namespace Motor\Backend\Models;

use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

//use Culpa\Traits\Blameable;
//use Culpa\Traits\CreatedBy;
//use Culpa\Traits\DeletedBy;
//use Culpa\Traits\UpdatedBy;

/**
 * Motor\Backend\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\Backend\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends \Spatie\Permission\Models\Role
{

    use Searchable;
    use Filterable;

//    use Blameable, CreatedBy, UpdatedBy, DeletedBy;

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
//    protected $blameable = array('created', 'updated', 'deleted');

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
        'name',
        'guard_name'
    ];
    //
    //public function permissions()
    //{
    //    return $this->hasMany(Permission::class);
    //}
}
