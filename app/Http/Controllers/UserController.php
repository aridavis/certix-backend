<?php

namespace App\Http\Controllers;

use App\CustomResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => 'required|min:2',
            "email" => 'required|unique:users,email',
            "dob" => 'date|required',
            "phone_number" => 'required|unique:users,phone_number',
            'gender' => 'required|in:M,F',
            'password' => 'required|min:8',
            'confirmation_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            return CustomResponse::ErrorResponse($validator->errors());
        }

        $user = new User();
        $user->id = Uuid::generate();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->save();
        return $user;

    }
}
