<?php

namespace App\Http\Controllers;

use App\Concert;
use App\CustomResponse;
use App\TicketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function validateSession(Request $request){
        $ticketDetail = TicketDetail::where('token', '=', $request->token)->where('cookie','=', $request->cookie)->first();
        return $ticketDetail == null ? 0 : 1;
    }

    public function updateToken(Request $request){
        $detail = TicketDetail::where('token', '=', $request->token)->first();

        if($detail == null){
            return CustomResponse::ErrorResponse(["Message" => ["Token is invalid!"]]);
        }

        $detail->cookie = Str::random(32);
        $detail->save();

        return $detail->cookie;
    }


}
