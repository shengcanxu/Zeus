<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('form_names');

        Schema::create('form_names', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('textboxname', 1000);
            $table->string('checkboxname', 1000);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('form_names');
    }
}

?>
