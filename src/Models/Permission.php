<?php

namespace Motor\Backend\Models;

use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

class Permission extends \Spatie\Permission\Models\Permission
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
        'permission_group_id',
        'name',
        'guard_name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(config('motor-backend.models.permission_group'), 'permission_group_id');
    }
}
