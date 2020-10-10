<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomResponse extends Model
{
    public static function UnauthorizedResponse(){
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
    public static function ErrorResponse($errors){
        return response()->json([
            'message' => $errors
        ], 403);
    }
}
