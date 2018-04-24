<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('worker_id');
            $table->enum('type', ['Paid work', 'Voluntary experience', 'Other']);
            $table->string('title');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');

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
        Schema::dropIfExists('experience');
    }
}
