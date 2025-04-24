<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Auth;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\ProfileEditForm;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\ProfileEditRequest;
use Motor\Backend\Services\ProfileEditService;

/**
 * Class ProfileEditController
 */
class ProfileEditController extends Controller
{
    use FormBuilderTrait;

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $form = $this->form(ProfileEditForm::class, [
            'method' => 'PATCH',
            'url' => route('backend.profile.update', [$user->id]),
            'enctype' => 'multipart/form-data',
            'model' => $user,
        ]);

        return view('motor-backend::backend.profile.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProfileEditRequest $request)
    {
        $form = $this->form(ProfileEditForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        ProfileEditService::updateWithForm(Auth::user(), $request, $form);

        flash()->success(trans('motor-backend::backend/users.profile.updated'));

        return redirect('backend/dashboard');
    }
}
