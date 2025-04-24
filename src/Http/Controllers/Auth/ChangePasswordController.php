<?php

namespace Motor\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Traits\ChangesPasswords;

/**
 * Class ChangePasswordController
 */
class ChangePasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ChangesPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/backend';

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangeForm(Request $request)
    {
        return view('motor-backend::auth.passwords.change')->with([
            'email' => Auth::guard()
                ->user()->email,
        ]);
    }

    public function saveNewPassword(Request $request)
    {
        // Fixme: do something here
    }
}
