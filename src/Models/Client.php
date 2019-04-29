<?php

namespace Motor\Backend\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereCountryIso31661($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Client whereZip($value)
 * @mixin \Eloquent
 */
class Client extends Model
{
    use Searchable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use Filterable;

    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [ 'name' ];

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
        'description'
    ];
}
