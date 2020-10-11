<?php

use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
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

        $user_id = \App\User::all()->first()->id;
        $concert_id = \App\Concert::all()->random()->id;
        $data = [
            "id" => \Webpatser\Uuid\Uuid::generate()->string,
            "user_id" => $user_id,
            "concert_id" => $concert_id,
            "referral_id" => \App\Referral::where("concert_id" , $concert_id)->where("user_id", "!=", $user_id)->get()->first()->id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("tickets")->insert($data);
    }
}
