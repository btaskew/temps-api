<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_experience', function (Blueprint $table) {
            $table->primary(['application_id', 'experience_id']);
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('experience_id');

            $table->foreign('application_id')
                ->references('id')->on('applications')
                ->onDelete('cascade');

            $table->foreign('experience_id')
                ->references('id')->on('experience')
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
        Schema::dropIfExists('application_experience');
    }
}
