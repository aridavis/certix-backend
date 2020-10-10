<?php

namespace App\Http\Controllers;

use App\CustomResponse;
use App\Seller;
use App\SellerApplication;
use App\Status;
use Cassandra\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\FeatureSet;
use Webpatser\Uuid\Uuid;

class SellerApplicationController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|unique:seller_applications,name|unique:sellers,name',
            "ic_number" => 'required',
            "description" => 'required'
        ]);

        if($validator->fails()){
            return CustomResponse::ErrorResponse($validator->errors());
        }

        $seller = Seller::findSellerByUserId($request->user()->id);
        $prevApplications = SellerApplication::where('user_id', '=', $request->user()->id)->where('status_id', '!=', Status::findStatusByName('rejected')->id)->first();


        if($seller != null || $prevApplications != null){
            return CustomResponse::ErrorResponse([
                "user_id" => "user is still on pending activation or user has been registered as seller"
            ]);
        }


        $data = new SellerApplication();
        $data->id = Uuid::generate()->string;
        $data->user_id = $request->user()->id;
        $data->name = $request->name;
        $data->ic_number = $request->ic_number;
        $data->description = $request->description;
        $data->status_id = Status::findStatusByName('requested')->id;
        $data->save();
        return  $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SellerApplication  $sellerApplication
     * @return \Illuminate\Http\Response
     */
    public function show(SellerApplication $sellerApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SellerApplication  $sellerApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(SellerApplication $sellerApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SellerApplication  $sellerApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellerApplication $sellerApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SellerApplication  $sellerApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellerApplication $sellerApplication)
    {
        //
    }
}
