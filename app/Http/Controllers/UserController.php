<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getProfile()
    {
        $id = auth()->user()->id;
        try {
            $hasil = User::where('id', $id)
                ->get();
            return $this->responseSuccess($hasil);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
    public function editProfile(Request $request)
    {
        try {
            $rules = [
                'name' => 'sometimes|required',
                'email' => 'sometimes|required',
                'gender' => 'sometimes|required',
                'phone' => 'sometimes|required',
                'birthday' => 'sometimes|required'
            ];
            $this->validate($request, $rules);

            $id = auth()->user()->id;
            $user = User::find($id);
            $user->email = $request->email;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->birthday = $request->birthday;
            $user->save();
            return $this->responseSuccess($user);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
    
}
