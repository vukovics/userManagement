<?php

namespace App\Http\Controllers\V1;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {

            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $userData = User::where('email', $credentials['email'])->get();

        // all good so return the token
        return response()->json(compact('token', 'userData'));
    }


    public function register(Request $request){

        try{

            $input = $request->all();

            //Hash password
            $input['password'] =  Hash::make($input['password']);

            $input['code'] = str_random(50);

            $input['displayName'] = $input['firstname'].' '.$input['lastname'];

            User::create($input);

        }catch (QueryException $exception){

            return $this->response->error('User already exist.', 409);
        }

        return $this->response->created();

    }

}
