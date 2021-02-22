<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
     public function __construct()
    {
    }

    public function login(Request $request)
    {
      try {
          $rules = [
              'email' => 'required',
              'password' => 'required',
          ];
          $this->validate($request, $rules);
          $user = User::where('email', $request->email)
              ->first();
          if (is_null($user)) {
              throw new \Exception("User not found", 401);
          }
          if (!app('hash')->check($request->password, $user->password)) {
              throw new \Exception("Email and password not match", 401);
          }
          $token = auth()->login($user);
          return $this->responseSuccess([
              'access_token' => $token,
              'type' => 'bearer',
              'expires_in' => auth()->factory()->getTTL() * 60
          ]);
      } catch (\Exception $e) {
          return $this->responseException($e);
      }
    }

    public function register(Request $request)
    {
        try {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'password' => 'required',
        ];
        $this->validate($request, $rules);
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->password = app('hash')->make($request->password);

        $user->save();
        return $this->responseSuccess($user);

        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function me()
    {
        try {
            $user = auth()->user();
            return $this->responseSuccess($user);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
