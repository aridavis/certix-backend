<?php

namespace App\Http\Controllers;

use App\Concert;
use App\CustomResponse;
use App\Genre;
use App\Seller;
use App\Status;
use App\Ticket;
use App\TicketDetail;
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

    public function getUserHistory(Request $request){
        $ticket = Ticket::where('user_id', '=', $request->user()->id)->get();
        $concert = Concert::whereIn('id', $ticket->pluck('concert_id'))->get();

        foreach ($concert as $c){
            $c->ticket = $ticket->where('concert_id', '=', $c->id)->values();
            $c->genre = Genre::find($c->genre_id)->name;
            $c->status = Status::find($c->status_id)->name;
            foreach ($c->ticket as $t){
                $tokens = TicketDetail::where('ticket_id', '=', $t->id)->get();
                $t->tokens = $tokens->pluck('token');
            }
        }

        $upcomingConcert = $concert->where('start_time', '>', Carbon::now())->values();
        $pastConcert = $concert->where('start_time', '<=', Carbon::now())->values();

        return ['upcoming' => $upcomingConcert, 'past' => $pastConcert];

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
            "genre" => "required|exists:genres,id",
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
        $data->genre_id = $request->genre;
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
