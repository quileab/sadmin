<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',120);
            $table->string('publisher',60);
            $table->string('author',60);
            $table->string('gender',30);
            $table->integer('extent')->default(0);
            $table->date('edition')->default('1973-01-01');
            $table->string('isbn',20)->nullable();
            $table->string('container',40)->nullable();
            $table->string('signature',30)->nullable();
            $table->string('digital',250)->nullable();
            $table->string('origin',80);
            $table->date('date_added');
            $table->decimal('price',10,2)->default(0);
            $table->date('discharge_date');
            $table->string('discharge_reason',200)->nullable();
            $table->text('synopsis');
            $table->string('note',300)->nullable();
            $table->foreignId('user_id')->nullable()->index();
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
        Schema::dropIfExists('books');
    }
}
