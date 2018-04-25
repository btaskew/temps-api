<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('worker_id');
            $table->string('level');
            $table->string('name');
            $table->string('grade');
            $table->string('institution');
            $table->date('completion_date');
            $table->timestamps();

            $table->foreign('worker_id')
                ->references('id')->on('workers')
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
        Schema::dropIfExists('education');
    }
}
