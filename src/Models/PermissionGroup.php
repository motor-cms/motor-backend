<?php

namespace Motor\Backend\Models;

use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

/**
 * Motor\Backend\Models\PermissionGroup
 *
 * @property int                             $id
 * @property string                          $name
 * @property int|null                        $sort_position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup whereSortPosition( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\PermissionGroup whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class PermissionGroup extends Model
{
    use Searchable;
    use Filterable;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sort_position'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(config('motor-backend.models.permission'), 'permission_group_id');
    }
}
