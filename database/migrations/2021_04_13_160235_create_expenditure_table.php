<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenditureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenditure', function (Blueprint $table) {
            $table->id();
            $table->integer('exp_type_id');
            $table->integer('bill_type_id')->nullable();
            $table->string('exp',100);
            $table->string('bills',100)->nullable();
            $table->longText('desc')->nullable();
            $table->bigInteger('amount');
            $table->integer('added_by');
            $table->date('date');
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
        Schema::dropIfExists('expenditure');
    }
}
