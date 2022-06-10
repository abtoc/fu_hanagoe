<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('channel_id');
            $table->date('date');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('view_count_daily')->default(0);
            $table->unsignedBigInteger('subscriber_count')->default(0);
            $table->bigInteger('subscriber_count_daily')->default(0);
            $table->timestamps();

            $table->primary(['channel_id', 'date']);
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
