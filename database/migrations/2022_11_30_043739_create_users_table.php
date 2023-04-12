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
        Schema::create('users', function (Blueprint $table) {
            $table->id("id");
            $table->string("username",50)->default("");
            $table->string("password",255)->default("");
            $table->string("full_name",50)->default("");
            $table->date("date_of_birth",6)->default("2022-12-12");
            $table->string("address",255)->default("");
            $table->string("email")->default("");
            $table->string("phone",50)->default("");
            $table->integer("gender")->comment("1 laki, 2 perempuan")->default(1);
            $table->integer("balance")->default(0);
            $table->integer("blocked")->comment("0 ngga ke block, 1 ter block")->default(1);
            $table->integer("role_id",0)->nullable()->comment("1 customer, 2 restaurant, 3 admin");
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
        Schema::dropIfExists('users');
    }
};
