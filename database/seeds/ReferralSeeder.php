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
        $data = [
            "id" => substr(md5(\Webpatser\Uuid\Uuid::generate()->string), 0, 6),
            "user_id" => \App\User::all()->first()->id,
            "concert_id" => \App\Concert::all()->first()->id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("referrals")->insert($data);
    }
}
