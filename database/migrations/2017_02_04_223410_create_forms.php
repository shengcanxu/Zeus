<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("forms",function(Blueprint $table){
            $table->increments("id");
            $table->timestamps();
            $table->string("form_name",100)->unique();
            $table->integer("user_id");

            $table->index("form_name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("forms");
    }
}
