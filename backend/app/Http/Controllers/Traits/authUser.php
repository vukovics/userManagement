<?php
namespace App\Http\Controllers\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;

trait AuthUser{
    public function getUser()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }

        return response()->json($user);
    }
}