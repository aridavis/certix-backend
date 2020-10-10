<?php

namespace App\Http\Controllers;

use App\CustomResponse;
use App\Seller;
use App\SellerApplication;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "application_id" => ['required', Rule::exists('seller_applications','id')->where('status_id', 2)],
        ]);

        if ($validator->fails()) {
            return CustomResponse::ErrorResponse($validator->errors());
        }

        $application = SellerApplication::find($request->application_id);

        $seller = Seller::findSellerByUserId($application->user_id);

        if ($seller != null) {
            return CustomResponse::ErrorResponse(["user_id", ["user has been added as seller"]]);
        }

        $data = new Seller();
        $data->id = Uuid::generate()->string;
        $data->user_id = $application->user_id;
        $data->ic_number = $application->ic_number;
        $data->name = $application->name;
        $data->save();
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        //
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
