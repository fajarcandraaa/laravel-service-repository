<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Presentation\Presentation;
use App\Service\AuthService;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $payload = $request->only('username', 'password');
        $validator = Validator::make($payload, [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $val = $validator->errors();
            return Presentation::presentResponse(422, 'Unprocessable Content', $val); // if no body request or request with wrong type
        }

        $login = AuthService::signIn($payload);
        switch ($login['code']) {
            case 200:
                return Presentation::presentResponse(200, 'OK', $login['secondary_data']);
            default:
                return Presentation::presentResponse($login['code'], $login['message']);
        }
    }

    public function register(Request $request){
        $payload = $request->only([
            'name',
            'username',
            'password'
        ]);


        $validator = Validator::make($payload, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $val = $validator->errors();
            return Presentation::presentResponse(422, 'Unprocessable Content', $val); // if no body request or request with wrong type
        }

        try {
            $register = $this->authService->signUp($payload);
            return Presentation::presentResponse(200, 'OK', $register['secondary_data']);
        } catch (\Exception $e) {
            return Presentation::presentResponse(500, $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return Presentation::presentResponse(200, 'Successfully logged out');
    }

    public function refresh()
    {
        $authorization = array(
            'token'     => Auth::refresh(),
            'type'      => 'bearer',
        );
        return Presentation::presentResponse(200, 'success', $authorization);
    }

}
