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

    public function getAllReferralProgression(){
        $referrals = Referral::with('concert')->where('user_id', '=', Auth::id());

        foreach ($referrals as $ref){
            $ref->count = Referral::getProgress($ref->id);
        }
        return $referrals;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $referral = Referral::where('concert_id', '=', $request->concert_id)->where('user_id', '=', Auth::id())->first();
        if($referral == null){
            $referral = new Referral();
            $referral->id = substr(md5(Uuid::generate()->string), 0, 6);
            $referral->user_id = $request->user_id;
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
