<?php

namespace Motor\Backend\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Traits\ApiResponder;

class AuthController extends Controller
{
    use ApiResponder;

    public function login(Request $request): JsonResponse
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()
                ->user()
                ->createToken('API Token')->plainTextToken,
        ]);
    }

    public function logout()
    {
        auth()
            ->user()
            ->tokens()
            ->delete();

        return [
            'message' => 'Tokens Revoked',
        ];
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        if ($this->guard()
            ->user() == null) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($this->guard()
            ->user());
    }
}
