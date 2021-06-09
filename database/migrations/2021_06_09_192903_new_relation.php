<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewRelation extends Migration
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
            $table->date('birthday')->nullable();
            $table->enum('role', ['customer', 'admin']);
            $table->string('password', 99);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->integer('id_user')->unsigned();
            $table->string('receiver', 99);
            $table->string('phone', 20);
            $table->string('district', 20);
            $table->string('postal_code', 20);
            $table->string('street', 99);
            $table->boolean('selected');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::table('address', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
            $table->integer('cost')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('id_product')->unsigned();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->string('promo_code', 7);
            $table->dateTime('active_until');
            $table->integer('max_cut');
            $table->integer('percentage');
            $table->softDeletes()->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('id_address')->unsigned()->nullable();
            $table->integer('id_product')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->enum('status', ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai']);
            $table->integer('cost')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_address')->references('id')->on('address')->onDelete('cascade');
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
            $table->date('birthday')->nullable();
            $table->enum('role', ['customer', 'admin']);
            $table->string('password', 99);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->integer('id_user')->unsigned();
            $table->string('receiver', 99);
            $table->string('phone', 20);
            $table->string('district', 20);
            $table->string('postal_code', 20);
            $table->string('street', 99);
            $table->boolean('selected');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::table('address', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
            $table->integer('cost')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('id_product')->unsigned();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->string('promo_code', 7);
            $table->dateTime('active_until');
            $table->integer('max_cut');
            $table->integer('percentage');
            $table->softDeletes()->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('id_address')->unsigned()->nullable();
            $table->integer('id_product')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->enum('status', ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai']);
            $table->integer('cost')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_address')->references('id')->on('address')->onDelete('cascade');
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
}
