<?php

use Illuminate\Database\Seeder;

class ReferralSeeder extends Seeder
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
        $users = \App\User::all();

        for ($i = 0 ; $i < $concerts->count() ; $i++){
            for ($j = 0; $j < $users->count() ; $j++){
                $data = [
                    "id" => substr(md5(\Webpatser\Uuid\Uuid::generate()->string), 0, 6),
                    "user_id" => $users[$j]->id,
                    "concert_id" => $concerts[$i]->id,
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ];
                \Illuminate\Support\Facades\DB::table("referrals")->insert($data);
            }
        }
    }
}
