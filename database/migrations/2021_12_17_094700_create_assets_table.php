<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('barcode')->nullable();
            $table->longText('note')->nullable();
            $table->string('city')->nullable();
            $table->integer('price')->nullable();
            $table->string('purchase_year')->nullable();
            $table->string('status')->nullable();

            $table->integer('worker_id')->unsigned()->nullable();
            $table->foreign('worker_id')->references('id')->on("workers")->onDelete('cascade');

            $table->string('follow_up')->nullable();

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
        Schema::dropIfExists('assets');
    }
}
