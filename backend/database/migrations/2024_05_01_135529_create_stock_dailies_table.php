<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_dailies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained('stocks')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date');
            $table->bigInteger('trading_volume');
            $table->bigInteger('trading_money');
            $table->float('open', 8, 2);
            $table->float('max', 8, 2);
            $table->float('min', 8, 2);
            $table->float('close', 8, 2);
            $table->float('spread', 8, 2);
            $table->integer('trading_turnover');
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
        Schema::dropIfExists('stock_dailies');
    }
}
