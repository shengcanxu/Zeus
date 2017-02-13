<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("form_nodes", function(Blueprint $table){
           $table->increments("id");
           $table->timestamps();
           $table->integer("form_id");
           $table->string("node_name",100);
           $table->text("json");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("form_nodes");
    }
}
