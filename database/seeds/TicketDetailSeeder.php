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
        $data = [
            "id" => \Webpatser\Uuid\Uuid::generate()->string,
            "ticket_id" => \App\Ticket::all()->first()->id,
            "isWatching" => 0,
            "token" => NULL,
            "cookie" => NULL,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("ticket_details")->insert($data);
    }
}
