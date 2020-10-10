<?php

use Illuminate\Database\Seeder;

class ReviewTypeSeeder extends Seeder
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

    public function initiateData(){
        $data = ["ABC", "DEF", "EGH", "IJK"];
        foreach ($data as $d){
            $type = new \App\ReviewType();
            $type->name = $d;
            $type->save();
        }
    }
}
