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
 * Motor\Backend\Models\EmailTemplate
 *
 * @property int                                      $id
 * @property int                                      $client_id
 * @property int|null                                 $language_id
 * @property string                                   $name
 * @property string                                   $subject
 * @property string                                   $body_text
 * @property string                                   $body_html
 * @property string                                   $default_sender_name
 * @property string                                   $default_sender_email
 * @property string                                   $default_recipient_name
 * @property string                                   $default_recipient_email
 * @property string                                   $default_cc_email
 * @property string                                   $default_bcc_email
 * @property int                                      $created_by
 * @property int                                      $updated_by
 * @property int|null                                 $deleted_by
 * @property \Illuminate\Support\Carbon|null          $created_at
 * @property \Illuminate\Support\Carbon|null          $updated_at
 * @property-read \Motor\Backend\Models\Client        $client
 * @property-read \Motor\Backend\Models\User          $creator
 * @property-read \Motor\Backend\Models\User|null     $eraser
 * @property-read \Motor\Backend\Models\Language|null $language
 * @property-read \Motor\Backend\Models\User          $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereBodyHtml( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereBodyText( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereClientId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereDefaultBccEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereDefaultCcEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereDefaultRecipientEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereDefaultRecipientName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereDefaultSenderEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereDefaultSenderName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereDeletedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereLanguageId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereSubject( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\EmailTemplate whereUpdatedBy( $value )
 * @mixin \Eloquent
 */
class EmailTemplate extends Model
{
    use Searchable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use Filterable;

    protected $blameable = [ 'created', 'updated', 'deleted' ];

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
