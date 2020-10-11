<?php

namespace App\Http\Controllers;

use App\Concert;
use App\CustomResponse;
use App\Referral;
use App\Seller;
use App\Ticket;
use App\TicketDetail;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
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

        $concert = Concert::find($request->concert_id);
        $wallet = Wallet::where('user_id', '=', $request->user()->id)->sum('value');
        $price = $concert->price * $request->quantity;
        if($request->has('referral_id') && $request->referral_id != null){
            if(Referral::getProgress($request->referral_id) >= 5){
                return CustomResponse::ErrorResponse(['error' => ['Limit referral exceeded']]);
            }
            $price = $concert->price * $request->quantity * 0.2 > 50000 ? $concert->price * $request->quantity - 50000 : $concert->price * $request->quantity * 0.8;
        }
        if($price > $wallet){
            return CustomResponse::ErrorResponse(['error' => ['Insufficient balance.']]);
        }

        $data = new Ticket();
        $data->id = Uuid::generate()->string;
        $data->user_id = $request->user()->id;
        $data->concert_id = $request->concert_id;
        if($request->has('referral_id') && $request->referral_id != null){
            if(Ticket::where('user_id', '=', $request->user()->id)->where('referral_id', '=', $request->referral_id)->first() != null){
                return CustomResponse::ErrorResponse(['error' => ['Referral code is already used']]);
            }
            $data->referral_id = $request->referral_id;
        }
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

        $minusWallet = new Wallet();
        $minusWallet->id = Uuid::generate()->string;
        $minusWallet->value = $price * -1;
        $minusWallet->user_id = $request->user()->id;
        $minusWallet->save();

        $addWallet = new Wallet();
        $addWallet->id = Uuid::generate()->string;
        $addWallet->value = $price;
        $addWallet->user_id = Seller::find($concert->seller_id)->user_id;
        $addWallet->save();

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
