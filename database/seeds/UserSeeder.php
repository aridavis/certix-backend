<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
            "name" => 'Ari Davis',
            "password" => bcrypt("aridavis"),
            "email" => "aa@aa.com",
            "dob" => "2000-08-08",
            "phone_number" => "082296516272",
            "gender" => "M",
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table('users')->insert($data);

        $data = [
            "id" => \Webpatser\Uuid\Uuid::generate()->string,
            "name" => 'Kevin',
            "password" => bcrypt("kevin"),
            "email" => "kv@kv.com",
            "dob" => "2000-10-10",
            "phone_number" => "082296516272",
            "gender" => "M",
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ];

        \Illuminate\Support\Facades\DB::table('users')->insert($data);

    }
}
