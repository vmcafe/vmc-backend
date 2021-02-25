<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->string('name', 99);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('id_category')->unsigned()->nullable()->after('id');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->string('name', 99);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('id_category')->unsigned()->nullable()->after('id');
        });
    }
}
