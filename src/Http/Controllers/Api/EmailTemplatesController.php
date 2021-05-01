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
    protected string $model = 'Motor\Backend\Models\EmailTemplate';

    protected string $modelResource = 'email_template';

    /**
     * @OA\Get (
     *   tags={"EmailTemplatesController"},
     *   path="/api/email_templates",
     *   summary="Get email template collection",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/EmailTemplateResource")
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         ref="#/components/schemas/PaginationMeta"
     *       ),
     *       @OA\Property(
     *         property="links",
     *         ref="#/components/schemas/PaginationLinks"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Collection read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   )
     * )
     *
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
     * @OA\Post (
     *   tags={"EmailTemplatesController"},
     *   path="/api/email_templates",
     *   summary="Create new email template",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EmailTemplateRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EmailTemplateResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Email template created"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Get (
     *   tags={"EmailTemplatesController"},
     *   path="/api/email_templates/{email_template}",
     *   summary="Get single email template",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="email_template",
     *     parameter="email_template",
     *     description="Email template id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EmailTemplateResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Email template read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Put (
     *   tags={"EmailTemplatesController"},
     *   path="/api/email_templates/{email_template}",
     *   summary="Update an existing email template",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EmailTemplateRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="email_template",
     *     parameter="email_template",
     *     description="Email template id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EmailTemplateResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Email template updated"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Delete (
     *   tags={"EmailTemplatesController"},
     *   path="/api/email_templates/{email_template}",
     *   summary="Delete an email template",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="email_template",
     *     parameter="email_template",
     *     description="Email template id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Email template deleted"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Problem deleting email template"
     *       )
     *     )
     *   )
     * )
     *
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
