<?php

use Illuminate\Database\Seeder;

class SellerApplicationSeeder extends Seeder
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
            "name" => "Sheila on 10",
            "ic_number" => "3173010123431231",
            "description" => "Good Band",
            "status_id" => \App\Status::all()->first()->id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("seller_applications")->insert($data);
    }
}
