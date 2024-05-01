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
            $table->integer('volume');
            $table->integer('amount');
            $table->float('open', 8, 2);
            $table->float('close', 8, 2);
            $table->float('high', 8, 2);
            $table->float('low', 8, 2);
            $table->float('change', 8, 2);
            $table->integer('total_transaction');
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
        Schema::dropIfExists('stock_dailies');
    }
}
