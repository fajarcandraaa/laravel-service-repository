<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserRepository {
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function insertUser($payload) {
        $user = User::create([
            'id' => Str::uuid()->toString(),
            'name' => $payload['name'],
            'username' => $payload['username'],
            'password' => Hash::make($payload['password']),
        ]);

        return $user;
    }
}