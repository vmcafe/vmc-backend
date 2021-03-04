<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->string('email', 99)->unique();
      $table->string('gender', 10);
      $table->string('phone', 20)->unique();
      $table->string('password', 99);
      $table->timestamps();
      $table->softDeletes();
      $table->engine = 'InnoDB';
    });

    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('products', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_category')->unsigned();
      $table->string('name', 99);
      $table->text('description');
      $table->integer('stock')->unsigned(); //stok produk
      $table->string('type', 99);
      $table->integer('netto')->unsigned();
      $table->integer('price')->unsigned();
      $table->string('photo', 99);
      $table->timestamps();
      $table->softDeletes();
      $table->engine = 'InnoDB';
    });
    Schema::table('products', function (Blueprint $table) {
      $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
    });
    Schema::create('carts', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_user')->unsigned();
      $table->integer('id_product')->unsigned();
      $table->integer('quantity')->unsigned();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    Schema::table('carts', function (Blueprint $table) {
      $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
    });

    Schema::create('vouchers', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('promo_code', 7);
      $table->dateTime('active_until');
      $table->bigInteger('max_cut');
      $table->integer('percentage');
      $table->softDeletes()->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('orders', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_user')->unsigned();
      $table->integer('id_voucher')->unsigned()->nullable();
      $table->string('status', 20)->nullable();
      $table->string('payment', 99)->nullable();
      $table->string('address', 199)->nullable();
      $table->integer('range')->unsigned()->nullable();
      $table->integer('ongkir')->unsigned()->nullable();
      $table->integer('sumcost')->unsigned()->nullable();
      $table->timestamps();
      $table->softDeletes();
      $table->engine = 'InnoDB';
    });
    Schema::table('orders', function (Blueprint $table) {
      $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('id_voucher')->references('id')->on('vouchers')->onDelete('cascade');
    });

    Schema::create('ordersproducts', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_order')->unsigned();
      $table->integer('id_product')->unsigned();
      $table->integer('quantity')->unsigned();
      $table->integer('cost')->unsigned()->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    Schema::table('ordersproducts', function (Blueprint $table) {
      $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade');
      $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
    });

    Schema::create('admin', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->string('email', 99);
      $table->string('password', 99);
      $table->softDeletes();
      $table->timestamps();
    });
    Schema::create('article', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->string('photo', 99);
      $table->boolean('type');
      $table->string('link', 99);
      $table->softDeletes();
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
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->string('email', 99)->unique();
      $table->string('gender', 10);
      $table->string('phone', 20)->unique();
      $table->string('password', 99);
      $table->timestamps();
      $table->softDeletes();
      $table->engine = 'InnoDB';
    });

    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('products', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_category')->unsigned();
      $table->string('name', 99);
      $table->text('description');
      $table->integer('stock')->unsigned(); //stok produk
      $table->string('type', 99)->unsigned();
      $table->integer('netto')->unsigned();
      $table->integer('price')->unsigned();
      $table->boolean('bundle')->unsigned();
      $table->string('photo', 99);
      $table->timestamps();
      $table->softDeletes();
      $table->engine = 'InnoDB';
    });
    Schema::table('products', function (Blueprint $table) {
      $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
    });
    Schema::create('carts', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_user')->unsigned();
      $table->integer('id_product')->unsigned();
      $table->integer('quantity')->unsigned();
      $table->string('note', 199);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    Schema::table('carts', function (Blueprint $table) {
      $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
    });

    Schema::create('vouchers', function (Blueprint $table) {
      $table->string('promo_code', 7);
      $table->dateTime('active_until');
      $table->bigInteger('max_cut');
      $table->integer('percentage');
      $table->softDeletes()->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('orders', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_user')->unsigned();
      $table->integer('id_voucher')->unsigned()->nullable();
      $table->string('status', 20)->nullable();
      $table->string('payment', 99)->nullable();
      $table->string('address', 199)->nullable();
      $table->integer('range')->unsigned()->nullable();
      $table->integer('ongkir')->unsigned()->nullable();
      $table->integer('sumcost')->unsigned()->nullable();
      $table->timestamps();
      $table->softDeletes();
      $table->engine = 'InnoDB';
    });
    Schema::table('orders', function (Blueprint $table) {
      $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('id_voucher')->references('id')->on('vouchers')->onDelete('cascade');
    });

    Schema::create('ordersproducts', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->integer('id_order')->unsigned();
      $table->integer('id_product')->unsigned();
      $table->integer('quantity')->unsigned();
      $table->integer('cost')->unsigned()->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    Schema::table('ordersproducts', function (Blueprint $table) {
      $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade');
      $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
    });

    Schema::create('admin', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->string('email', 99);
      $table->string('password', 99);
      $table->softDeletes();
      $table->timestamps();
    });
    Schema::create('article', function (Blueprint $table) {
      $table->increments('id', true)->unsigned();
      $table->string('name', 99);
      $table->string('photo', 99);
      $table->string('type', 99);
      $table->string('link', 99);
      $table->softDeletes();
      $table->timestamps();
    });
  }
}
