<?php

namespace App\Http\Controllers;

use App\ReviewType;
use Illuminate\Http\Request;

class ReviewTypeControlller extends Controller
{
    public function index(Request $request){
        return ReviewType::all();
    }
}
