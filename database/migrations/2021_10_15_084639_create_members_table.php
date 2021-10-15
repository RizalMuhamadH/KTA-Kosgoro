<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('nik')->unique();
            $table->string('no_member')->unique();
            $table->string('photo');
            $table->string('address');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('sub_district_id');
            $table->unsignedInteger('village_id');
            $table->string('post_code');
            $table->string('qrcode');
            $table->string('status');
            $table->string('token');
            $table->unsignedBigInteger('position_id');
            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('sub_district_id')->references('id')->on('sub_districts');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('village')->references('id')->on('villages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
