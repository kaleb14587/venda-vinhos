<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("compra_id");
            $table->unsignedBigInteger("item_id");
            $table->timestamps();

            $table->foreign('compra_id')->on('compras')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('item_id')->on('items')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras_items');
    }
}
