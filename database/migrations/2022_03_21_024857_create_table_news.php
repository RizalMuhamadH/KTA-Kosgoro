<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->longText('description');
            $table->longText('body');
            $table->string('source');
            $table->string('source_link');
            $table->boolean('featured');
            $table->foreignId('category_id');
            $table->foreignIdFor(User::class);
            $table->enum('status',["Draft","Published","Deleted"]);
            $table->longText('meta_description');
            $table->longText('meta_keywords');
            $table->longText('seo_title');
            $table->softDeletes();
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
        Schema::dropIfExists('news');
    }
}
