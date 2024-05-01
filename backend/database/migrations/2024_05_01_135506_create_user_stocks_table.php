<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('stock_id')->constrained('stocks')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('volume');
            $table->date('buy_date');
            $table->float('buy_price', 8, 2);
            $table->float('buy_fee_discount', 8, 2);
            $table->integer('total_cost');
            $table->date('sell_date');
            $table->float('sell_price', 8, 2);
            $table->float('sell_fee_discount', 8, 2);
            $table->integer('tax');
            $table->integer('total_profit');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('user_stocks');
    }
}
