<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

/**
 * Class AdminNavigationsController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class AdminNavigationsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items = config('motor-backend-navigation.items');
        ksort($items);

        return response()->json(['data' => $items]);
    }
}
