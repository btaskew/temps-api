<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_id');
            $table->enum('type', ['approved', 'rejected']);
            $table->text('comment');
            $table->timestamps();

            $table->foreign('application_id')
                ->references('id')->on('applications')
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
        Schema::dropIfExists('application_responses');
    }
}
