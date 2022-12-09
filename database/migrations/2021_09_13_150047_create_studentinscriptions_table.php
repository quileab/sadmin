<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentinscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentinscriptions', function (Blueprint $table) {
            $table->primary(['user_id', 'subject_id', 'name']);

            $table->foreignId('user_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->string('name', 30)->key();
            $table->string('type', 5); // text, bool, int, radio, check, csv
            $table->string('value', 250);

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
        Schema::dropIfExists('studentinscriptions');
    }
}
