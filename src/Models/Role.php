<?php

namespace Motor\Backend\Models;

use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

//use Culpa\Traits\Blameable;
//use Culpa\Traits\CreatedBy;
//use Culpa\Traits\DeletedBy;
//use Culpa\Traits\UpdatedBy;

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
}
