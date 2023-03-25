<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Kalnoy\Nestedset\QueryBuilder;
use Kra8\Snowflake\HasShortFlakePrimary;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Motor\Backend\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $scope
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\Motor\Backend\Models\Category[] $children
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\Category|null $parent
 * @property-read \Motor\Backend\Models\User $updater
 *
 * @method static Builder|Category d()
 * @method static Builder|Category filteredBy(Filter $filter, $column)
 * @method static Builder|Category filteredByMultiple(Filter $filter)
 * @method static QueryBuilder|Category newModelQuery()
 * @method static QueryBuilder|Category newQuery()
 * @method static QueryBuilder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereCreatedBy($value)
 * @method static Builder|Category whereDeletedBy($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereLft($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereRgt($value)
 * @method static Builder|Category whereScope($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use Filterable;
    use BlameableTrait;
    use NodeTrait;
    use HasShortFlakePrimary;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'scope',
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
        return ['scope'];
    }
}
