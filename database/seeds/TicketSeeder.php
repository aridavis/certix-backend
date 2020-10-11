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
        $data = [
            "id" => \Webpatser\Uuid\Uuid::generate()->string,
            "user_id" => \App\User::all()->first()->id,
            "concert_id" => \App\Concert::all()->first()->id,
            "transaction_date" => \Carbon\Carbon::now()->toDateTime(),
            "referral_id" => \App\Referral::all()->first()->id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("tickets")->insert($data);
    }
}
