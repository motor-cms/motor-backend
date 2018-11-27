<?php

namespace Motor\Backend\Models;

use Motor\Backend\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Motor\Core\Traits\Searchable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Motor\Core\Traits\Filterable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class User extends Authenticatable implements HasMedia, JWTSubject
{

    use Searchable;
    use HasRoles;
    use Filterable;
    use Notifiable;
    use HasMediaTrait;

    protected $guard_name = 'web';

    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, $this));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['haha' => 'lol'];
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->setManipulations([ 'w' => 400, 'h' => 400 ]);
        $this->addMediaConversion('preview')->setManipulations([ 'w' => 400, 'h' => 400 ]);
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
