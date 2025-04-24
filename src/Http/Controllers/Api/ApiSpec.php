<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *   title="Motor Backend API",
 *   version="1.1.0",
 *   x={
 *     "logo": {
 *       "url": "http://motor-cms.com/motor.png",
 *       "altText": "Logo"
 *     }
 *   },
 *
 *   @OA\Contact(
 *     email="me@dfox.info"
 *   )
 * )
 *
 * @OA\Tag(name="UsersController", description="Endpoints for the users resource")
 *
 * @OA\Parameter(
 *
 *    @OA\Schema(type="string"),
 *    in="query",
 *    allowReserved=true,
 *    name="api_token",
 *    parameter="api_token",
 *    description="Personal api_token of the user"
 * )
 */

/**
 * @OA\Schema(
 *   schema="AccessDenied",
 *   type="json",
 *   example={"error": "Unauthenticated"},
 *   description="The user is not authorized to make this request"
 * )
 */

/**
 * @OA\Schema(
 *   schema="NotFound",
 *   type="json",
 *   example={"message": "Record not found"},
 *   description="The record was not found in the database"
 * )
 */

/**
 * @OA\Schema(
 *   schema="PaginationLinks",
 *
 *   @OA\Property(
 *     property="first",
 *     type="string",
 *     example="http://localhost/api/endpoint?page=1"
 *   ),
 *   @OA\Property(
 *     property="last",
 *     type="string",
 *     example="http://localhost/api/endpoint?page=3"
 *   ),
 *   @OA\Property(
 *     property="prev",
 *     type="'null',string",
 *     example="null"
 *   ),
 *   @OA\Property(
 *     property="next",
 *     type="'null',string",
 *     example="http://localhost/api/endpoint?page=2"
 *   ),
 * )
 */

/**
 * @OA\Schema(
 *   schema="PaginationMeta",
 *
 *   @OA\Property(
 *     property="current_page",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="last_page",
 *     type="integer",
 *     example="2"
 *   ),
 *   @OA\Property(
 *     property="from",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="to",
 *     type="integer",
 *     example="25"
 *   ),
 *   @OA\Property(
 *     property="total",
 *     type="integer",
 *     example="28"
 *   ),
 *   @OA\Property(
 *     property="per_page",
 *     type="integer",
 *     example="25"
 *   ),
 *   @OA\Property(
 *     property="path",
 *     type="string",
 *     example="http://localhost/api/endpoint"
 *   ),
 *   @OA\Property(
 *     property="links",
 *     type="array",
 *
 *     @OA\Items(
 *
 *       @OA\Property(
 *         property="url",
 *         type="'null',string",
 *         example="http://localhost/api/endpoint?page=1"
 *       ),
 *       @OA\Property(
 *         property="label",
 *         type="string",
 *         example="Previous"
 *       ),
 *       @OA\Property(
 *         property="active",
 *         type="boolean",
 *         example="false"
 *       )
 *     )
 *   )
 * )
 */
