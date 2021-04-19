<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
 *     type="text",
 *     example="The complete email body as text"
 *   ),
 *   @OA\Property(
 *     property="body_html",
 *     type="text",
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
class EmailTemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
