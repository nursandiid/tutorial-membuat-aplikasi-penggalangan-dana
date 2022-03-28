<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashouts', function (Blueprint $table) {
            $table->foreign('campaign_id')
                  ->references('id')
                  ->on('campaigns')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->foreign('bank_id')
                  ->references('id')
                  ->on('bank')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashouts', function (Blueprint $table) {
            $table->dropForeign('cashouts_campaign_id_foreign');
            $table->dropForeign('cashouts_user_id_foreign');
            $table->dropForeign('cashouts_bank_id_foreign');
        });
    }
}
