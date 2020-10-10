<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
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
        $data = ["Alternative", "Anime", "Blues", "Children", "Classical", "Country", "Jazz", "Dance", "Rock", "Pop"];

        foreach ($data as $d){
            $genre = new \App\Genre();
            $genre->name = $d;
            $genre->save();
        }
    }
}
