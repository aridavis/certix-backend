<?php

use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
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

    public function initiateData()
    {
        $users = \App\User::all();

        $data = [
            "id" => \Webpatser\Uuid\Uuid::generate()->string,
            "user_id" => \App\User::all()->first()->id,
            "name" => "Sheila on 10",
            "ic_number" => "3173010123431231",
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table('sellers')->insert($data);

        for($i = 2; $i < 30 ; $i++){
            $x = rand(0,1);
            $data = [
                "id" => \Webpatser\Uuid\Uuid::generate()->string,
                "user_id" => $users[$i]->id,
                "name" => "Sheila on ".$i,
                "ic_number" => "3173010123431231".$i,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ];
            if($x == 0 && $i != 10)  \Illuminate\Support\Facades\DB::table('sellers')->insert($data);
        }
    }
}
