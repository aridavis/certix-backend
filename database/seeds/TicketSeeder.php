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
        $concerts = \App\Concert::all();

        for($i = 0; $i < $concerts->count() ; $i++){
            for($j = 0; $j < 10 ; $j++){
                $user_id = \App\User::all()->random()->id;
                $referral = \App\Referral::where("concert_id" , $concerts[$i]->id)->where("user_id", "!=", $user_id)->get()->random();
                $count_referral = \App\Ticket::where("referral_id",$referral->id)->count();
                $x = rand(1,3);

                $data = [
                    "id" => \Webpatser\Uuid\Uuid::generate()->string,
                    "user_id" => $user_id,
                    "concert_id" => $concerts[$i]->id,
                    "referral_id" => $referral->id,
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ];
//                \Illuminate\Support\Facades\DB::table("tickets")->insert($data);
                if($count_referral < $x) \Illuminate\Support\Facades\DB::table("tickets")->insert($data);
            }
        }
    }
}
