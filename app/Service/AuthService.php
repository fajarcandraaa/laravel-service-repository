<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Presentation\Presentation;
use App\Repositories\UserRepository;

class AuthService {
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public static function signIn($payload) {
        $token = Auth::attempt($payload);
        if (!$token) {
            $res = Presentation::serviceResponse(401, 'Unauthorized');
            return $res;
        }

        $user = Auth::user();
        $authorization = array(
            'token' => $token,
            'type' => 'Bearer '
        );
        $res = Presentation::serviceResponse(200, 'Success', $user, $authorization);
        return $res;
    }

    public function signUp($payload) {
        $user = $this->userRepository->insertUser($payload);
        $token = Auth::login($user);
        $authorization = array(
            'token' => $token,
            'type' => 'Bearer '
        );
        $res = Presentation::serviceResponse(200, 'User created successfully', $user, $authorization);
        return $res;
    }
}