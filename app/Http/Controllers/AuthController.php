<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
     public function __construct()
    {
    }

    public function loginC(Request $request)
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
          if($user->role != 'customer'){
            throw new \Exception("Anda tidak diperkenankan login", 401);
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

    public function registerC(Request $request)
    {
        try {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|min:10',
            'password' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->password = app('hash')->make($request->password);

        $user->save();
        return $this->responseSuccess($user);

        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
    public function registerA(Request $request)
    {
        try {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|min:10',
            'password' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->role = 2;
        $user->password = app('hash')->make($request->password);

        $user->save();
        return $this->responseSuccess($user);

        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
    public function loginA(Request $request)
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
          if($user->role != 'admin'){
            throw new \Exception("Anda tidak diperkenankan login", 401);
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
