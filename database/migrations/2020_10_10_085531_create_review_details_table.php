<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_details', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('review_id');
            $table->unsignedBigInteger('review_type_id');
            $table->foreign('review_type_id')->on('review_types')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('review_id')->on('reviews')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('review_details');
    }
}
