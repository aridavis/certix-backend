<?php

namespace App\Http\Controllers;

use App\Concert;
use App\CustomResponse;
use App\Referral;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class ReferralController extends Controller
{

    public function getAllReferralProgression(Request $request){
        $referrals = Referral::with('concert.genre')->where('user_id', '=', $request->user()->id)->get();

        foreach ($referrals as $ref){
            $ref->count = Referral::getProgress($ref->id);
        }
        return $referrals->values();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $referral = Referral::where('id', '=', $request->referral_id)->first();
        if($referral == null){
            return CustomResponse::ErrorResponse(["not found", ["referral code not found"]]);
        }else if($referral->concert_id != $request->concert_id){
            return CustomResponse::ErrorResponse(["concert", ["wrong concert"]]);
        }else if($referral->user_id == $request->user()->id){
            return CustomResponse::ErrorResponse(["error", ["cannot use own referral code"]]);
        }else{
            if(Referral::getProgress($referral->id) >= 5){
                return CustomResponse::ErrorResponse(["limit", ["limit exceeded"]]);
            }
            return $referral;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $referral = Referral::where('concert_id', '=', $request->concert_id)->where('user_id', '=', $request->user()->id)->first();
        if($referral == null){
            $referral = new Referral();
            $referral->id = substr(md5(Uuid::generate()->string), 0, 6);
            $referral->user_id = $request->user()->id;
            $referral->concert_id = $request->concert_id;
            $referral->save();
        }

        return ['referral_id' => $referral->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Concert::findConcertById(Referral::getConcertId($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function edit(Referral $referral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referral $referral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referral $referral)
    {
        //
    }
}
