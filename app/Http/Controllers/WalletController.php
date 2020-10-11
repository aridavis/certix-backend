<?php

namespace App\Http\Controllers;

use App\Wallet;
use App\WalletSnapshot;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $history = Wallet::where('user_id', '=', $request->user()->id)->orderBy('created_at', 'desc')->get();
        $balance = Wallet::where('user_id', '=', $request->user()->id)->sum('value');
        return ['history' => $history, 'balance' => $balance];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Wallet();
        $data->id = Uuid::generate()->string;
        $data->user_id = $request->user()->id;
        $data->value = $request->value;
        $data->save();

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
