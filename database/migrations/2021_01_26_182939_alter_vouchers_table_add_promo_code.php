<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVouchersTableAddPromoCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->string('promo_code', 7);
            $table->dateTime('active_until');
            $table->bigInteger('max_cut');
            $table->integer('percentage');
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('promo_code');
            $table->dropColumn('active_until');
            $table->dropColumn('max_cut');
            $table->dropColumn('percentage');
            $table->dropSoftDeletes();
        });
    }
}
