<?php

namespace Motor\Backend\Http\Resources;

/**
 * @OA\Schema(
 *   schema="EmailTemplateResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="client",
 *     type="object",
 *     ref="#/components/schemas/ClientResource"
 *   ),
 *   @OA\Property(
 *     property="language",
 *     type="object",
 *     ref="#/components/schemas/LanguageResource"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My email template"
 *   ),
 *   @OA\Property(
 *     property="subject",
 *     type="string",
 *     example="My email subject"
 *   ),
 *   @OA\Property(
 *     property="body_text",
 *     type="string",
 *     example="The complete email body as text"
 *   ),
 *   @OA\Property(
 *     property="body_html",
 *     type="string",
 *     example="The complete email body with html tags"
 *   ),
 *   @OA\Property(
 *     property="default_sender_name",
 *     type="string",
 *     example="Motor Administrator"
 *   ),
 *   @OA\Property(
 *     property="default_sender_email",
 *     type="string",
 *     example="sender@motor-cms.com"
 *   ),
 *   @OA\Property(
 *     property="default_recipient_name",
 *     type="string",
 *     example="Motor User"
 *   ),
 *   @OA\Property(
 *     property="default_recipient_email",
 *     type="string",
 *     example="recipient@motor-cms.com"
 *   ),
 *   @OA\Property(
 *     property="default_cc_email",
 *     type="string",
 *     description="Comma separated list of email addresses",
 *     example="cc1@motor-cms.com,cc2.motor-cms.com"
 *   ),
 *   @OA\Property(
 *     property="default_bcc_email",
 *     type="string",
 *     description="Comma separated list of email addresses",
 *     example="bcc1@motor-cms.com,bcc2.motor-cms.com"
 *   )
 * )
 */
class EmailTemplateResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                      => (int) $this->id,
            'client'                  => new ClientResource($this->client),
            'client_id'               => (int) $this->client_id,
            'language'                => new LanguageResource($this->language),
            'language_id'             => (int) $this->language_id,
            'name'                    => $this->name,
            'subject'                 => $this->subject,
            'body_text'               => $this->body_text,
            'body_html'               => $this->body_html,
            'default_sender_name'     => $this->default_sender_name,
            'default_sender_email'    => $this->default_sender_email,
            'default_recipient_name'  => $this->default_recipient_name,
            'default_recipient_email' => $this->default_recipient_email,
            'default_cc_email'        => $this->default_cc_email,
            'default_bcc_email'       => $this->default_bcc_email,
        ];
    }
}
