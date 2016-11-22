<?php

namespace Motor\Backend\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Filterable;
use Sofa\Eloquence\Eloquence;

class Client extends Model
{

    use Eloquence;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use Filterable;

    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the Eloquence trait
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
