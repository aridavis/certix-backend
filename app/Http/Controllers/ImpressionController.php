<?php

namespace App\Http\Controllers;

use App\Impression;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class ImpressionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $imp = Impression::where('ip_address', '=', $request->getClientIp())->where('concert_id', '=', $request->concert_id)->orderByDesc('created_at')->first();
        $interval = CarbonInterval::make('30seconds');

        if($imp != null){
            $treshold = Carbon::make($imp->created_at)->addSeconds($interval->totalSeconds);
            if(Carbon::now() > $treshold){
                $new_imp = new Impression();
                $new_imp->id = Uuid::generate()->string;
                $new_imp->ip_address = $request->getClientIp();
                $new_imp->concert_id = $request->concert_id;
                $new_imp->created_at = Carbon::now();
                $new_imp->updated_at = Carbon::now();
                $new_imp->save();
            }
        }
        else{
            $new_imp = new Impression();
            $new_imp->id = Uuid::generate()->string;
            $new_imp->ip_address = $request->getClientIp();
            $new_imp->concert_id = $request->concert_id;
            $new_imp->created_at = Carbon::now();
            $new_imp->updated_at = Carbon::now();
            $new_imp->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
