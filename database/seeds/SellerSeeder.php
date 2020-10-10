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
        $data = [
            "id" => \Webpatser\Uuid\Uuid::generate()->string,
            "user_id" => \App\User::all()->first()->id,
            "name" => "Sheila on 10",
            "ic_number" => "3173010123431231",
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table('sellers')->insert($data);

    }
}
