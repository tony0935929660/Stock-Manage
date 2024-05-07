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
            $table->integer('amount');
            $table->date('buy_date')->useCurrent();
            $table->float('buy_price', 8, 2);
            $table->float('buy_fee_discount', 8, 2);
            $table->integer('total_cost');
            $table->date('sell_date')->nullable();
            $table->float('sell_price', 8, 2)->nullable();
            $table->float('sell_fee_discount', 8, 2)->nullable();
            $table->integer('tax')->nullable();
            $table->integer('total_profit')->nullable();
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
