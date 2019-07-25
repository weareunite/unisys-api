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
            $table->integer('instance_id')->unsigned();
            $table->foreign('instance_id')->references('id')->on('instances');
            $table->string('name');
            $table->string('group')->nullable();
            $table->timestamps();

            $table->index(['group']);
            $table->index(['name', 'group']);
        });

        Schema::create('categoryables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->morphs('categoryable');

            $table->unique(['category_id', 'categoryable_id', 'categoryable_type']);
        });
    }

    public function down()
    {
        Schema::drop('categoryables');
        Schema::drop('categories');
    }
}
