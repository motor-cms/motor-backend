<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Forms\Backend\ProfileEditForm;
use Motor\Backend\Http\Requests\Backend\ProfileEditRequest;
use Motor\Backend\Http\Controllers\Controller;
use Auth;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class ProfileEditController extends Controller
{

    use FormBuilderTrait;


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $form = $this->form(ProfileEditForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.profile.update', [ $user->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $user
        ]);

        return view('backend.profile.edit', compact('form'));
    }


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
        $form = $this->form(ProfileEditForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $this->handleInputValues($form, $request->all());

        if ($data['password'] == '') {
            unset( $data['password'] );
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user = Auth::user();

        $user->update($data);

        $this->handleFileupload($request, $user, 'avatar', 'avatar');

        flash()->success(trans('backend/users.profile.updated'));

        return redirect('backend/dashboard');
    }
}
