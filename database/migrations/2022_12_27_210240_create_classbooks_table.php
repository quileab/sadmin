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
        Schema::create('classbooks', function (Blueprint $table) {
            //$table->id();
            $table->foreignId('subject_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('date_id');
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('Authority_user_id')->nullable();
            $table->foreign('Authority_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->unsignedSmallInteger('ClassNr');
            $table->unsignedTinyInteger('Unit');
            $table->string('Type',25);
            $table->string('Contents',240);
            $table->string('Activities',100);
            $table->string('Observations',60)->nullable();
            $table->timestamps();

            $table->primary(['subject_id', 'date_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classbooks');
    }
};
