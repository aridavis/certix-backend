<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Ticket::where('user_id', '=', $request->user()->id)->with('ticketDetail')->get();
    }

    public function show($id)
    {
        return Ticket::find($id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Ticket();
        $data->id = Uuid::generate()->string;
        $data->user_id = $request->user()->id;
        $data->concert_id = $request->concert_id;
        $data->save();

        $details = [];

        for($i = 0; $i < intval($request->quantity); $i++){
            $detail = new TicketDetail();
            $detail->id = Uuid::generate()->string;
            $detail->ticket_id = $data->id;
            $detail->token = strtoupper(Str::random(6));
            $detail->cookie = "";
            $detail->is_watching = false;
            $detail->save();

            array_push($details, $detail);
        }

        return ["ticket" => $data, "details"=> $details];
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update($tokenId)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
