<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_education', function (Blueprint $table) {
            $table->primary(['application_id', 'education_id']);
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('education_id');

            $table->foreign('application_id')
                ->references('id')->on('applications')
                ->onDelete('cascade');

            $table->foreign('education_id')
                ->references('id')->on('education')
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
        Schema::dropIfExists('application_education');
    }
}
