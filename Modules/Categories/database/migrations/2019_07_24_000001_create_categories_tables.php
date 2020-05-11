<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTables extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('group')->nullable();
            $table->timestamps();

            $table->index(['group']);
            $table->index(['name', 'group']);
        });

        Schema::create('model_has_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->morphs('model');

            $table->unique(['category_id', 'model_id', 'model_type']);
        });
    }

    public function down()
    {
        Schema::drop('model_has_categories');
        Schema::drop('categories');
    }
}
