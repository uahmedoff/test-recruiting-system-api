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
        Schema::create('cv_vacancy', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('cv_id');
            $table->unsignedBigInteger('vacancy_id');
            $table->timestamp('created_at');
            $table->foreign('cv_id')
                ->references('id')
                ->on('cvs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('vacancy_id')
                ->references('id')
                ->on('vacancies')
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
        Schema::drop('cv_vacancies');
    }
};
