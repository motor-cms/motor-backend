<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\EmailTemplateRequest;
use Motor\Backend\Http\Resources\EmailTemplateCollection;
use Motor\Backend\Http\Resources\EmailTemplateResource;
use Motor\Backend\Models\EmailTemplate;
use Motor\Backend\Services\EmailTemplateService;

/**
 * Class EmailTemplatesController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class EmailTemplatesController extends ApiController
{
    protected string $modelResource = 'email_template';

    /**
     * Display a listing of the resource.
     *
     * @return \Motor\Backend\Http\Resources\EmailTemplateCollection
     */
    public function index()
    {
        $paginator = EmailTemplateService::collection()
                                         ->getPaginator();

        return (new EmailTemplateCollection($paginator))->additional(['message' => 'Email template collection read']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Motor\Backend\Http\Requests\Backend\EmailTemplateRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(EmailTemplateRequest $request)
    {
        $result = EmailTemplateService::create($request)
                                      ->getResult();

        return (new EmailTemplateResource($result))->additional(['message' => 'Email template created'])
                                                   ->response()
                                                   ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Motor\Backend\Models\EmailTemplate $record
     * @return \Motor\Backend\Http\Resources\EmailTemplateResource
     */
    public function show(EmailTemplate $record)
    {
        $result = EmailTemplateService::show($record)
                                      ->getResult();

        return (new EmailTemplateResource($result))->additional(['message' => 'Email template read']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Motor\Backend\Http\Requests\Backend\EmailTemplateRequest $request
     * @param \Motor\Backend\Models\EmailTemplate $record
     * @return \Motor\Backend\Http\Resources\EmailTemplateResource
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $record)
    {
        $result = EmailTemplateService::update($record, $request)
                                      ->getResult();

        return (new EmailTemplateResource($result))->additional(['message' => 'Email template updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Motor\Backend\Models\EmailTemplate $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EmailTemplate $record)
    {
        $result = EmailTemplateService::delete($record)
                                      ->getResult();

        if ($result) {
            return response()->json(['message' => 'Email template deleted']);
        }

        return response()->json(['message' => 'Problem deleting email template'], 400);
    }
}
