<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Motor\Backend\Database\Factories\LanguageFactory;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Motor\Backend\Models\Language
 *
 * @property int $id
 * @property string $iso_639_1
 * @property string $english_name
 * @property string $native_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static Builder|Language filteredBy(Filter $filter, $column)
 * @method static Builder|Language filteredByMultiple(Filter $filter)
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language search($q, $full_text = false)
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereEnglishName($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereIso6391($value)
 * @method static Builder|Language whereNativeName($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    use Searchable;
    use Filterable;
    use HasFactory;
    use HasUuids;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = ['iso_639_1', 'native_name', 'english_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso_639_1',
        'english_name',
        'native_name',
    ];

    protected static function newFactory()
    {
        return LanguageFactory::new();
    }
}
