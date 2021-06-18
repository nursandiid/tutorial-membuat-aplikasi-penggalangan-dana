<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToBankSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_setting', function (Blueprint $table) {
            $table->foreign('bank_id')
                  ->references('id')
                  ->on('bank')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('setting_id')
                  ->references('id')
                  ->on('settings')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_setting', function (Blueprint $table) {
            $table->dropForeign('bank_setting_bank_id_foreign');
            $table->dropForeign('bank_setting_setting_id_foreign');
        });
    }
}
