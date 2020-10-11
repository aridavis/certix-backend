<?php

use Illuminate\Database\Seeder;

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
            "isWatching" => 0,
            "token" => substr(md5($id), 0, 6),
            "cookie" => cookie('token', ''),
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("ticket_details")->insert($data);
    }
}
