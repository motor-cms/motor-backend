<?php

namespace Motor\Backend\Models;

use Motor\Core\Traits\Filterable;
use Sofa\Eloquence\Eloquence;

class Permission extends \Spatie\Permission\Models\Permission
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
        'permission_group_id',
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(config('motor-backend.models.permission_group'), 'permission_group_id');
    }
}
