<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->string('id');
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->string('country')->nullable();
            $table->dateTime('published_at');
            $table->bigIncrements('number');
            $table->timestamps();

            $table->unique('number');
            $table->dropPrimary();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
