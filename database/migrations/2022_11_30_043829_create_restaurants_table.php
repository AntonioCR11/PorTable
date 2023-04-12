<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id("id");
            $table->string("full_name");
            $table->string("address");
            $table->string("phone");
            $table->integer("user_id");
            $table->integer("col");
            $table->integer("row");
            $table->float("average_rating");
            $table->integer("start_time");
            $table->integer("shifts");
            $table->integer("price");
            $table->string("description");
            $table->dateTime("verified_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
