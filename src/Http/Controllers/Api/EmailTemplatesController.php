<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\EmailTemplateRequest;
use Motor\Backend\Models\EmailTemplate;
use Motor\Backend\Services\EmailTemplateService;
use Motor\Backend\Transformers\EmailTemplateTransformer;

/**
 * Class EmailTemplatesController
 * @package Motor\Backend\Http\Controllers\Api
 */
class EmailTemplatesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $paginator = EmailTemplateService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, EmailTemplateTransformer::class, 'client,language');

        return $this->respondWithJson('Email template collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param EmailTemplateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EmailTemplateRequest $request)
    {
        $result   = EmailTemplateService::create($request)->getResult();
        $resource = $this->transformItem($result, EmailTemplateTransformer::class, 'client,language');

        return $this->respondWithJson('Email template created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param EmailTemplate $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EmailTemplate $record)
    {
        $result   = EmailTemplateService::show($record)->getResult();
        $resource = $this->transformItem($result, EmailTemplateTransformer::class, 'client,language');

        return $this->respondWithJson('Email template read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EmailTemplateRequest $request
     * @param EmailTemplate        $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $record)
    {
        $result   = EmailTemplateService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, EmailTemplateTransformer::class, 'client,language');

        return $this->respondWithJson('Email template updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param EmailTemplate $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EmailTemplate $record)
    {
        $result = EmailTemplateService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Email template deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Email template NOT deleted', [ 'success' => false ]);
    }
}
