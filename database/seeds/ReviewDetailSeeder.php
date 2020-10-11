<?php

use Illuminate\Database\Seeder;

class ReviewDetailSeeder extends Seeder
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
            "review_id" => \App\Review::all()->first()->id,
            "review_type_id" => \App\ReviewType::all()->first()->id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table("review_details")->insert($data);
    }

}
