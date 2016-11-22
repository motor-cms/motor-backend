<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Requests\Backend\ProfileEditRequest;
use Motor\Backend\Http\Controllers\Controller;
use Auth;
use Motor\Backend\Services\ProfileEditService;

class ProfileEditController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileEditRequest $request)
    {
        $result = ProfileEditService::update(Auth::user(), $request)->getResult();

        return response()->json([ 'data' => $result ]);
    }


    public function me()
    {
        $result = ProfileEditService::show(Auth::user())->getResult();

        return response()->json([ 'data' => $result ]);

    }
}
