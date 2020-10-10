<?php

namespace App\Http\Controllers;

use App\Concert;
use App\CustomResponse;
use App\Genre;
use App\Seller;
use App\Status;
use Carbon\Carbon;
use Cassandra\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;
use Webpatser\Uuid\UuidServiceProvider;

class ConcertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Concert::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "start_time" => 'required|date|after:'.Carbon::now()->addWeek(1)->startOfDay(),
            "name" => "required",
            "price" => "required|numeric|min:10000",
            "genre" => "required|exists:genres,name",
        ]);

        if($validator->fails()){
            return CustomResponse::ErrorResponse($validator->errors());
        }

        $seller = Seller::findSellerByRequest($request);
        if($seller == null){
            return CustomResponse::ErrorResponse(["seller_id", ["user is not a seller"]]);
        }

        $data = new Concert();
        $data->id = Uuid::generate()->string;
        $data->seller_id = Seller::findSellerByRequest($request)->id;
        $data->start_time = $request->start_time;
        $data->name = $request->name;
        $data->price = $request->price;
        $data->genre_id = Genre::findGenreByName($request->genre)->id;
        $data->status_id = Status::findStatusByName("scheduled")->id;
        $data->save();

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Concert  $concert
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Concert::find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Concert  $concert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "start_time" => 'required|date|after:'.Carbon::now()->addWeek(1)->startOfDay(),
            "status" => 'required|exists:statuses,name'
        ]);

        if($validator->fails()){
            return CustomResponse::ErrorResponse($validator->errors());
        }

        $data = Concert::find($id);
        $data->start_time = $request->start_time;
        $data->status_id = Status::findStatusByName($request->status)->id;
        $data->save();

        return $data;
    }

}
