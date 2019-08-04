<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("compra_id");
            $table->unsignedBigInteger("cliente_id");
            $table->timestamps();

            $table->foreign('compra_id')->on('compras')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('cliente_id')->on('clientes')
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
        Schema::dropIfExists('compras_clientes');
    }
}
