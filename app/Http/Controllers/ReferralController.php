<?php

namespace App\Http\Controllers;

use App\Concert;
use App\Referral;
use App\Ticket;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class ReferralController extends Controller
{
    public function getProgress($id){
        $ticket_referred = Ticket::where("referral_id", '=', $id)->get();
        return ['count' => $ticket_referred->count()];
    }

    public function getAllReferralProgression($user_id){
//        get referralnya apa aja, get concertnya apa aja, get progresssnya apa aja
        $referrals = Referral::where("user_id", '=', $user_id)->get();

        foreach ($referrals as $ref){
            $ref->concert = Concert::where("id", '=', $ref->concert_id);
            $ref->count = $this->getProgress($ref->id);
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
        $referral = new Referral();
        $referral->id = substr(md5(Uuid::generate()->string), 0, 6);
        $referral->user_id = $request->user_id;
        $referral->concert_id = $request->concert_id;
        $referral->save();

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
