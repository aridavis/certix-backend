<?php

namespace App\Http\Controllers;

use App\Concert;
use App\Review;
use App\Seller;
use App\Ticket;
use App\TicketDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        return [
            "average_ratings" => $this->averageRating($request),
            "incoming_concert" => $this->incomingConcert($request),
            "sold_ticket" => $this->ticketSold($request)
        ];
    }

    public function totalIncome(Request $request){

    }

    public function incomingConcert(Request $request){
        return Concert::where('start_time', ">", Carbon::now())->where('seller_id', Seller::findSellerByRequest($request)->id)->count();
    }

    public function ticketSold(Request $request){
        $concert = Concert::where('seller_id', '=', Seller::findSellerByRequest($request)->id)->get();
        $tickets = Ticket::whereIn('concert_id', $concert->pluck('id'))->get();
        $ticketDetails = TicketDetail::whereIn('ticket_id', $tickets->pluck('id'))->count();
        return $ticketDetails;
    }

    private function averageRating(Request $request){
        $concert = Concert::where('seller_id', '=', Seller::findSellerByRequest($request)->id)->get();
        $tickets = Ticket::whereIn('concert_id', $concert->pluck('id'))->get();
        $ticketDetails = TicketDetail::whereIn('ticket_id', $tickets->pluck('id'))->get();
        $reviews = Review::whereIn('ticket_detail_id', $ticketDetails->pluck('id'))->average('star');
        return round($reviews,1);
    }
}
