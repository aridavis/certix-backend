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
        $sellers = \App\Seller::all();
        $id = \Webpatser\Uuid\Uuid::generate()->string;

        for($i = 0 ; $i < $sellers->count() ; $i++){
            for($j = 0 ; $j < 5 ; $j++){
                $data = [
                    "id" => $id,
                    "seller_id" => $sellers[$i]->id,
                    "start_time" => \Carbon\Carbon::create('2020', '10','20','13', '20', '0'),
                    "name" => "Berbahagia Selalu dengan ".$sellers[$i]->name . " part ". $j+1,
                    "price" => 100000,
                    "genre_id" => \App\Genre::all()->random()->id,
                    "stream_key" => substr(md5($id), 0, 6),
                    "status_id" => \App\Status::all()->random()->id,
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ];
                \Illuminate\Support\Facades\DB::table('concerts')->insert($data);

            }
        }


    }
}
