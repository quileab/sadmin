<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->primary(['user_id', 'subject_id','date_id']);
            //$table->unsignedBigInteger('user_id');
            //$table->unsignedBigInteger('subject_id');
            // $table->unique(["user_id","subject_id"],"user_subject_unique");
            $table->foreignId('user_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->date('date_id')->key();
            $table->tinyText('name');
            
            $table->tinyInteger('grade')->default(0);
            $table->tinyInteger('approved')->default(0);
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
        Schema::dropIfExists('grades');
    }
}
