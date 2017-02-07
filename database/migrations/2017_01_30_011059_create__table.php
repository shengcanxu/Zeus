<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('');

        Schema::create('', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('textboxname', 100);
            $table->integer('checkb');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('');
    }
}

?>
