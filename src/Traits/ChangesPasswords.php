<?php

namespace Motor\Backend\Traits;

use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

trait ChangesPasswords
{

    use RedirectsUsers;


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function change(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $this->resetPassword(Auth::guard()->user(), $request->get('password'));

        flash()->success(trans('motor-backend::backend/login.password_successfully_changed'));

        return $this->sendResetResponse('Success');
    }


    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => 'required|confirmed|min:6',
        ];
    }


    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }


    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('password', 'password_confirmation');
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string                                      $password
     *
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->password_last_changed_at = date('Y-m-d H:i:s');

        $user->setRememberToken(Str::random(60));

        $user->save();

        //event(new PasswordReset($user));

        $this->guard()->login($user);
    }


    /**
     * Get the response for a successful password reset.
     *
     * @param  string $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())->with('status', trans($response));
    }


    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()->withInput($request->only('email'))->withErrors([ 'email' => trans($response) ]);
    }


    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }


    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
