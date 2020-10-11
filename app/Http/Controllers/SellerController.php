<?php

namespace App\Http\Controllers;

use App\Concert;
use App\CustomResponse;
use App\Seller;
use App\SellerApplication;
use App\Status;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Webpatser\Uuid\Uuid;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Seller::all();
    }

    public function getSelling(Request $request){
        $concert = Concert::where('seller_id', '=', Seller::findSellerByRequest($request)->id)->get();
        foreach ($concert as $c){
            $c->income = $c->price * Ticket::where('concert_id','=', $c->id)->join('ticket_details','ticket_details.ticket_id','=', 'tickets.id')->count();
            $c->status = Status::find($c->status_id)->name;
        }
        return $concert;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($application)
    {
        $data = new Seller();
        $data->id = Uuid::generate()->string;
        $data->user_id = $application->user_id;
        $data->ic_number = $application->ic_number;
        $data->name = $application->name;
        $data->save();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Seller::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seller = Seller::find($id);
        $seller->information = $request->has('information') ? $request->information : "";
        $seller->save();
        return $seller;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        //
    }
}
