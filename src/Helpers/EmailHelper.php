<?php

namespace Motor\Backend\Helpers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Motor\Backend\Models\EmailTemplate;

class EmailHelper
{
    public static function sendEmail($templateName, $headers = [], $data = [])
    {
        // Try to get email template
        $template = EmailTemplate::where('name', $templateName)
                                 ->first();
        if (is_null($template)) {
            Log::error('No template found for '.$templateName);

            return false;
        }

        $body = Blade::render(nl2br($template->body_text), $data);

        try {
            Mail::html($body, function ($message) use ($headers, $template, $body, $data) {
                $message->setBody($body, 'text/html');
                $message->from($template->default_sender_email, $template->default_sender_name);

                if (isset($headers['to_email'])) {
                    $message->to($headers['to_email'], $headers['to_name']);
                } else {
                    $message->to($template->default_recipient_email, $template->default_recipient_name);
                }

                if (isset($headers['cc_email'])) {
                    $message->cc($headers['cc_email'], $headers['cc_name']);
                }

                if (isset($headers['bcc_email'])) {
                    $message->bcc($headers['bcc_email'], $headers['bcc_name']);
                }

                $message->subject(html_entity_decode(Blade::render($template->subject, $data)));
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }

        return true;
    }
}
