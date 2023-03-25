<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Motor\Backend\Models\EmailTemplate
 *
 * @property int $id
 * @property int $client_id
 * @property int|null $language_id
 * @property string $name
 * @property string $subject
 * @property string $body_text
 * @property string $body_html
 * @property string $default_sender_name
 * @property string $default_sender_email
 * @property string $default_recipient_name
 * @property string $default_recipient_email
 * @property string $default_cc_email
 * @property string $default_bcc_email
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Motor\Backend\Models\Client $client
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\Language|null $language
 * @property-read \Motor\Backend\Models\User $updater
 *
 * @method static Builder|EmailTemplate filteredBy(Filter $filter, $column)
 * @method static Builder|EmailTemplate filteredByMultiple(Filter $filter)
 * @method static Builder|EmailTemplate newModelQuery()
 * @method static Builder|EmailTemplate newQuery()
 * @method static Builder|EmailTemplate query()
 * @method static Builder|EmailTemplate search($q, $full_text = false)
 * @method static Builder|EmailTemplate whereBodyHtml($value)
 * @method static Builder|EmailTemplate whereBodyText($value)
 * @method static Builder|EmailTemplate whereClientId($value)
 * @method static Builder|EmailTemplate whereCreatedAt($value)
 * @method static Builder|EmailTemplate whereCreatedBy($value)
 * @method static Builder|EmailTemplate whereDefaultBccEmail($value)
 * @method static Builder|EmailTemplate whereDefaultCcEmail($value)
 * @method static Builder|EmailTemplate whereDefaultRecipientEmail($value)
 * @method static Builder|EmailTemplate whereDefaultRecipientName($value)
 * @method static Builder|EmailTemplate whereDefaultSenderEmail($value)
 * @method static Builder|EmailTemplate whereDefaultSenderName($value)
 * @method static Builder|EmailTemplate whereDeletedBy($value)
 * @method static Builder|EmailTemplate whereId($value)
 * @method static Builder|EmailTemplate whereLanguageId($value)
 * @method static Builder|EmailTemplate whereName($value)
 * @method static Builder|EmailTemplate whereSubject($value)
 * @method static Builder|EmailTemplate whereUpdatedAt($value)
 * @method static Builder|EmailTemplate whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class EmailTemplate extends Model
{
    use Searchable;
    use BlameableTrait;
    use Filterable;
    use HasSnowflakePrimary;

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
        'default_bcc_email',
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
