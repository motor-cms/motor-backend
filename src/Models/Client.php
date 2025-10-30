<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;
use Motor\Backend\Database\Factories\ClientFactory;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Motor\Backend\Models\Client
 *
 * @property int $id
 * @property string $slug
 * @property int $is_active
 * @property string $name
 * @property string $address
 * @property string $zip
 * @property string $city
 * @property string $country_iso_3166_1
 * @property string $website
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $description
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 *
 * @method static Builder|Client filteredBy(Filter $filter, $column)
 * @method static Builder|Client filteredByMultiple(Filter $filter)
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 * @method static Builder|Client search($q, $full_text = false)
 * @method static Builder|Client whereAddress($value)
 * @method static Builder|Client whereCity($value)
 * @method static Builder|Client whereContactEmail($value)
 * @method static Builder|Client whereContactName($value)
 * @method static Builder|Client whereContactPhone($value)
 * @method static Builder|Client whereCountryIso31661($value)
 * @method static Builder|Client whereCreatedAt($value)
 * @method static Builder|Client whereCreatedBy($value)
 * @method static Builder|Client whereDeletedBy($value)
 * @method static Builder|Client whereDescription($value)
 * @method static Builder|Client whereId($value)
 * @method static Builder|Client whereIsActive($value)
 * @method static Builder|Client whereName($value)
 * @method static Builder|Client whereSlug($value)
 * @method static Builder|Client whereUpdatedAt($value)
 * @method static Builder|Client whereUpdatedBy($value)
 * @method static Builder|Client whereWebsite($value)
 * @method static Builder|Client whereZip($value)
 * @mixin \Eloquent
 */
class Client extends Model
{
    use Searchable;
    use BlameableTrait;
    use Filterable;
    use HasFactory;
    use HasShortflakePrimary;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'is_active',
        'name',
        'address',
        'zip',
        'city',
        'country_iso_3166_1',
        'website',
        'contact_name',
        'contact_phone',
        'contact_email',
        'description',
    ];

    protected static function newFactory()
    {
        return ClientFactory::new();
    }
}
