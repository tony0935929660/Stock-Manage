<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['related_transaction_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('related_transaction_id');
        });

        Schema::create('transaction_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buy_transaction_id')->constrained('transactions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sell_transaction_id')->constrained('transactions')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity');
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
        Schema::dropIfExists('transaction_mappings');
    }
}
