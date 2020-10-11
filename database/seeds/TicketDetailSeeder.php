<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->initiateData();
    }


    private function initiateData(){
        $id = \Webpatser\Uuid\Uuid::generate()->string;
        $data = [
            "id" => $id,
            "ticket_id" => \App\Ticket::all()->first()->id,
            "is_watching" => 0,
            "token" => strtoupper(Str::random(6)),
            "cookie" => cookie('token', ''),
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("ticket_details")->insert($data);
    }
}
