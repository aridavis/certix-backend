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
            "sold_ticket" => $this->ticketSold($request),
            "total_income" => $this->totalIncome($request),
            "popular_genres" => $this->popularGenre($request),
            "profit_genre" => $this->profitGenre($request),
            "upcoming_sold_ticket" => $this->upcomingSoldTicket($request)
        ];
    }


    public function upcomingSoldTicketQuery(Request $request, $month, $monthInt){
        return "SELECT '$month' , sum(price) as cnt FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '1dd03d20-0b5f-11eb-8a20-1d09e7ab301b' and year(t.created_at) = year(now()) and month(t.created_at) = 1"
    }

    public function upcomingSoldTicket(Request $request){

        $query = "SELECT c.name, count(*) as cnt FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '".Seller::findSellerByRequest($request)->id."' and start_time > now() group by c.name";
        return DB::select($query);
    }


    public function profitGenre(Request $request){
        $query = "SELECT g.name, sum(price) as cnt FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '".Seller::findSellerByRequest($request)->id."'
group by g.name";
        return DB::select($query);

    }

    public function popularGenre(Request $request){
        $query = "SELECT g.name, COUNT(*) as cnt FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '".Seller::findSellerByRequest($request)->id."'
group by g.name";
        return DB::select($query);

    }

    public function totalIncome(Request $request){
        $query = "SELECT sum(c.price) as price FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id WHERE c.seller_id = '".Seller::findSellerByRequest($request)->id."'";
        return DB::select($query)[0]->price;
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
