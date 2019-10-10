<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

/**
 * Motor\Backend\Models\Category
 *
 * @property int                                                                $id
 * @property string                                                             $name
 * @property string                                                             $scope
 * @property int                                                                $_lft
 * @property int                                                                $_rgt
 * @property int|null                                                           $parent_id
 * @property int                                                                $created_by
 * @property int                                                                $updated_by
 * @property int|null                                                           $deleted_by
 * @property \Illuminate\Support\Carbon|null                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                    $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\Motor\Backend\Models\Category[] $children
 * @property-read \Motor\Backend\Models\User                                    $creator
 * @property-read \Motor\Backend\Models\User|null                               $eraser
 * @property-read \Motor\Backend\Models\Category|null                           $parent
 * @property-read \Motor\Backend\Models\User                                    $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category d()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Kalnoy\Nestedset\QueryBuilder|\Motor\Backend\Models\Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\Motor\Backend\Models\Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\Motor\Backend\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereDeletedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereLft( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereParentId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereRgt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereScope( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Category whereUpdatedBy( $value )
 * @mixin \Eloquent
 */
class Category extends Model
{
    use Filterable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use NodeTrait;

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
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'scope'
    ];


    /**
     * Get searchable columns defined on the model.
     *
     * @return array
     */
    public function getSearchableColumns()
    {
        return (property_exists($this, 'searchableColumns')) ? $this->searchableColumns : [];
    }


    /**
     * @return array
     */
    /**
     * @return array
     */
    protected function getScopeAttributes()
    {
        return [ 'scope' ];
    }
}
