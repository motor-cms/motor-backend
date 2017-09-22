<?php

namespace Motor\Backend\Models;
use Motor\Core\Traits\Searchable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Motor\Core\Traits\Filterable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMediaConversions
{

    use Searchable;
    use HasMediaTrait;
    use HasRoles;
    use Filterable;

    protected $guard_name = 'web';

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->setManipulations([ 'w' => 400, 'h' => 400 ]);
    }

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [ 'name', 'email' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'name',
        'email',
        'password',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(config('motor-backend.models.client'));
    }
}
