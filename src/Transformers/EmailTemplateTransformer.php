<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\EmailTemplate;

/**
 * Class EmailTemplateTransformer
 * @package Motor\Backend\Transformers
 */
class EmailTemplateTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'client',
        'language'
    ];


    /**
     * @param EmailTemplate $record
     * @return array
     */
    public function transform(EmailTemplate $record)
    {
        return [
            'id'                      => (int) $record->id,
            'client_id'               => (int) $record->client_id,
            'language_id'             => (int) $record->language_id,
            'name'                    => $record->name,
            'subject'                 => $record->subject,
            'body_text'               => $record->body_text,
            'body_html'               => $record->body_html,
            'default_sender_name'     => $record->default_sender_name,
            'default_sender_email'    => $record->default_sender_email,
            'default_recipient_name'  => $record->default_recipient_name,
            'default_recipient_email' => $record->default_recipient_email,
            'default_cc_email'        => $record->default_cc_email,
            'default_bcc_email'       => $record->default_bcc_email
        ];
    }


    /**
     * Include client
     *
     * @param EmailTemplate $record
     * @return Fractal\Resource\Item
     */
    public function includeClient(EmailTemplate $record)
    {
        if (! is_null($record->client)) {
            return $this->item($record->client, new ClientTransformer());
        }
    }


    /**
     * Include language
     *
     * @param EmailTemplate $record
     * @return Fractal\Resource\Item
     */
    public function includeLanguage(EmailTemplate $record)
    {
        if (! is_null($record->language)) {
            return $this->item($record->language, new LanguageTransformer());
        }
    }
}
