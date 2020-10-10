<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
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
        $data = ["Requested", "Accepted", "Rejected"];
        foreach ($data as $d){
            $status = new \App\Status();
            $status->name = $d;
            $status->save();
        }
    }
}
