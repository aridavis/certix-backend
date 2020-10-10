<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_applications', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->string('name');
            $table->string('ic_number');
            $table->string('description');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->on('statuses')->references('id')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_applications');
    }
}
