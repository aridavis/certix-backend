<?php

namespace App\Http\Controllers;

use App\Review;
use App\ReviewDetail;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class ReviewController extends Controller
{
    public function store(Request $request){
        $data = new Review();
        $data->ticket_detail_id = $request->ticket_detail_id;
        $data->star = $request->star;
        $data->id = Uuid::generate()->string;

        $data->save();

        foreach ($request->details as $d){
            $x = new ReviewDetail();
            $x->review_type_id = $d;
            $x->id = Uuid::generate()->string;
            $x->review_id = $data->id;
            $x->save();
        }

        return $data;

    }

}
