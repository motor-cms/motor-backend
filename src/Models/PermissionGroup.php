<?php

namespace Motor\Backend\Models;

use Motor\Core\Traits\Filterable;
use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{

    use Eloquence;
    use Filterable;

//    use Blameable, CreatedBy, UpdatedBy, DeletedBy;

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
//    protected $blameable = array('created', 'updated', 'deleted');

    /**
     * Searchable columns for the Eloquence trait
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
}
