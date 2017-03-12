<?php

namespace Motor\Backend\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

class EmailTemplate extends Model
{

    use Searchable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use Filterable;

    protected $blameable = array('created', 'updated', 'deleted');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'language_id',
        'name',
        'subject',
        'body_text',
        'body_html',
        'default_sender_name',
        'default_sender_email',
        'default_recipient_name',
        'default_recipient_email',
        'default_cc_email',
        'default_bcc_email'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(config('motor-backend.models.client'));
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(config('motor-backend.models.language'));
    }

}
