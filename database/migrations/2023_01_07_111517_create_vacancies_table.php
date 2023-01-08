<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->unsignedBigInteger('position_id');
            $table->double('salary_from');
            $table->double('salary_to');
            $table->json('skills');
            $table->text('job_procedure');
            $table->unsignedBigInteger('number_of_views')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
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
        Schema::drop('vacancies');
    }
};
