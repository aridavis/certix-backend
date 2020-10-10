<?php

use Illuminate\Database\Seeder;

class ConcertSeeder extends Seeder
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
        $id = \Webpatser\Uuid\Uuid::generate()->string;
        $data = [
            "id" => $id,
            "seller_id" => \App\Seller::all()->first()->id,
            "start_time" => \Carbon\Carbon::create('2020', '10','20','13', '20', '0'),
            "name" => "Berbahagia Selalu",
            "price" => 100000,
            "genre_id" => 1,
            "stream_key" => $id,
            "status_id" => 4,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table('concerts')->insert($data);
    }
}
