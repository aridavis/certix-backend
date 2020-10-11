<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(ReviewTypeSeeder::class);
        $this->call(SellerSeeder::class);
        $this->call(SellerApplicationSeeder::class);
        $this->call(WalletSnapshotSeeder::class);
        $this->call(ConcertSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(TicketDetailSeeder::class);
        $this->call(ReferralSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(ReviewTypeSeeder::class);
        $this->call(ReviewDetailSeeder::class);
    }
}
