<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Motor\Backend\Models\PasswordReset
 */
class PasswordReset extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

}
