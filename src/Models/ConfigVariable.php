<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

/**
 * Motor\Backend\Models\ConfigVariable
 *
 * @property int                                  $id
 * @property string                               $package
 * @property string                               $group
 * @property string                               $name
 * @property string                               $value
 * @property \Illuminate\Support\Carbon|null      $created_at
 * @property \Illuminate\Support\Carbon|null      $updated_at
 * @property int                                  $created_by
 * @property int                                  $updated_by
 * @property int|null                             $deleted_by
 * @property-read \Motor\Backend\Models\User      $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User      $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereDeletedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereGroup( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable wherePackage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereUpdatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\ConfigVariable whereValue( $value )
 * @mixin \Eloquent
 */
class ConfigVariable extends Model
{
    use Searchable;
    use Filterable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'package',
        'group',
        'name',
        'value'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package',
        'group',
        'name',
        'value'
    ];
}
