<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('worker_id');
            $table->unsignedInteger('job_id');
            $table->text('cover_letter');
            $table->timestamps();

            $table->foreign('worker_id')
                ->references('id')->on('workers')
                ->onDelete('cascade');

            $table->foreign('job_id')
                ->references('id')->on('jobs')
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
        Schema::dropIfExists('applications');
    }
}
