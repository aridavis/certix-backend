<?php

namespace App\Http\Controllers;

use App\Concert;
use App\Impression;
use App\Review;
use App\Seller;
use App\Ticket;
use App\TicketDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return [
            "average_ratings" => $this->averageRating($request),
            "incoming_concert" => $this->incomingConcert($request),
            "sold_ticket" => $this->ticketSold($request),
            "total_income" => $this->totalIncome($request),
            "total_engagement" => $this->getImpression($request),
            "popular_genres" => $this->popularGenre($request),
            "profit_genre" => $this->profitGenre($request),
            "upcoming_sold_ticket" => $this->upcomingSoldTicket($request),
            "this_year_profit" => $this->thisYearProfit($request)
        ];
    }

    public function homePage()
    {
        return ["top_sellers" => $this->topSeller(), "top_concerts" => $this->topConcert(), "sellers" => Seller::all(), "concerts" => Concert::with('seller')->where('start_time', '>', Carbon::now())->get()];
    }

    public function getImpression(Request $request)
    {
        $concert = Concert::where('seller_id', '=', Seller::findSellerByRequest($request)->id)->get();
        $tot = 0;
        foreach ($concert as $c) {
            $impression = Impression::where('concert_id', '=', $c->id)->count();
            $tot += $impression;
        }
        return $tot;
    }

    public function thisYearProfitQuery(Request $request, $month, $monthInt)
    {
        return "SELECT '$month' as month, ifnull(cast(sum(price) as int), 0) as Income FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '" . Seller::findSellerByRequest($request)->id . "' and year(t.created_at) = year(now()) and month(t.created_at) = $monthInt";
    }


    public function thisYearProfit(Request $request)
    {
        $months = ["", "January", "February", "March", "April", "May", "June", "July",
            "August", "September", "October", "November", "December"];
        $query = "";
        for ($i = 1; $i <= 12; $i++) {
            $query = $query . $this->thisYearProfitQuery($request, $months[$i], $i);

            if ($i != 12) {
                $query = $query . " union ";
            }
        }
        return DB::select($query);
    }

    public function topSeller()
    {
        $sellers = Seller::all();
        foreach ($sellers as $s) {
            $concert = Concert::where('seller_id', '=', $s->id)->get();
            $tickets = Ticket::whereIn('concert_id', $concert->pluck('id'))->get();
            $s->count_sold_ticket = TicketDetail::whereIn('ticket_id', $tickets->pluck('id'))->count();
            $s->count_total_concert = $concert->count();
        }
        return $sellers->sortByDesc('count_sold')->take(5)->values();
    }

    public function topConcert()
    {
        $concert = Concert::where('start_time', '>', Carbon::now())->with('seller')->get();
        foreach ($concert as $c) {

            $tickets = Ticket::where('concert_id', '=', $c->id)->get();
            $c->count_sold = TicketDetail::whereIn('ticket_id', $tickets->pluck('id'))->count();
        }

        return $concert->sortByDesc('count_sold')->take(5)->values();
    }

    public function upcomingSoldTicket(Request $request)
    {
        $query = "SELECT c.name, cast(count(*) as int) as value FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '" . Seller::findSellerByRequest($request)->id . "' and start_time > now() group by c.name";
        return DB::select($query);
    }

    public function profitGenre(Request $request)
    {
        $query = "SELECT g.name, cast(sum(price) as int) as value FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '" . Seller::findSellerByRequest($request)->id . "'
group by g.name";
        return DB::select($query);

    }

    public function popularGenre(Request $request)
    {
        $query = "SELECT g.name, cast(COUNT(*) as int) as value FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id join genres g on g.id = c.genre_id WHERE c.seller_id = '" . Seller::findSellerByRequest($request)->id . "'
group by g.name";
        return DB::select($query);

    }

    public function totalIncome(Request $request)
    {
        $query = "SELECT sum(c.price) as price FROM concerts c join tickets t on t.concert_id = c.id join ticket_details td on td.ticket_id = t.id WHERE c.seller_id = '" . Seller::findSellerByRequest($request)->id . "'";
        return DB::select($query)[0]->price;
    }

    public function incomingConcert(Request $request)
    {
        return Concert::where('start_time', ">", Carbon::now())->where('seller_id', Seller::findSellerByRequest($request)->id)->count();
    }

    public function ticketSold(Request $request)
    {
        $concert = Concert::where('seller_id', '=', Seller::findSellerByRequest($request)->id)->get();
        $tickets = Ticket::whereIn('concert_id', $concert->pluck('id'))->get();
        $ticketDetails = TicketDetail::whereIn('ticket_id', $tickets->pluck('id'))->count();
        return $ticketDetails;
    }

    private function averageRating(Request $request)
    {
        $concert = Concert::where('seller_id', '=', Seller::findSellerByRequest($request)->id)->get();
        $tickets = Ticket::whereIn('concert_id', $concert->pluck('id'))->get();
        $ticketDetails = TicketDetail::whereIn('ticket_id', $tickets->pluck('id'))->get();
        $reviews = Review::whereIn('ticket_detail_id', $ticketDetails->pluck('id'))->average('star');
        return round($reviews, 1);
    }
}
