<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAllColumnToNullableMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('no_member')->nullable()->change();
            $table->string('photo')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->unsignedBigInteger('province_id')->default(0)->change();
            $table->unsignedBigInteger('district_id')->default(0)->change();
            $table->unsignedBigInteger('sub_district_id')->default(0)->change();
            $table->unsignedBigInteger('village_id')->default(0)->change();
            $table->string('post_code')->nullable()->change();
            $table->string('status')->default(0)->change();
            $table->unsignedBigInteger('position_id')->default(3)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->string('phone')->unique()->change();
            $table->string('nik')->unique()->change();
            $table->string('no_member')->unique()->change();
            $table->string('photo')->change();
            $table->string('address')->change();
            $table->unsignedBigInteger('province_id')->change();
            $table->unsignedBigInteger('district_id')->change();
            $table->unsignedBigInteger('sub_district_id')->change();
            $table->unsignedBigInteger('village_id')->change();
            $table->string('post_code')->change();
            $table->string('status')->default(0)->change();
            $table->unsignedBigInteger('position_id')->change();
        });
    }
}
