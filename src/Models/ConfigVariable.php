<?php

namespace Motor\Backend\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Motor\Backend\Models\ConfigVariable
 *
 * @property int $id
 * @property string $package
 * @property string $group
 * @property string $name
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 * @method static Builder|ConfigVariable filteredBy(Filter $filter, $column)
 * @method static Builder|ConfigVariable filteredByMultiple(Filter $filter)
 * @method static Builder|ConfigVariable newModelQuery()
 * @method static Builder|ConfigVariable newQuery()
 * @method static Builder|ConfigVariable query()
 * @method static Builder|ConfigVariable search($q, $full_text = false)
 * @method static Builder|ConfigVariable whereCreatedAt($value)
 * @method static Builder|ConfigVariable whereCreatedBy($value)
 * @method static Builder|ConfigVariable whereDeletedBy($value)
 * @method static Builder|ConfigVariable whereGroup($value)
 * @method static Builder|ConfigVariable whereId($value)
 * @method static Builder|ConfigVariable whereName($value)
 * @method static Builder|ConfigVariable wherePackage($value)
 * @method static Builder|ConfigVariable whereUpdatedAt($value)
 * @method static Builder|ConfigVariable whereUpdatedBy($value)
 * @method static Builder|ConfigVariable whereValue($value)
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
    protected $blameable = ['created', 'updated', 'deleted'];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'package',
        'group',
        'name',
        'value',
        'is_invisible',
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
        'value',
    ];
}
