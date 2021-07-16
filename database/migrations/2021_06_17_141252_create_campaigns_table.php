<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug')
                  ->unique();
            $table->string('short_description');
            $table->longText('body');
            $table->integer('view_count')
                  ->default(0);
            $table->enum('status', ['publish', 'pending', 'archived'])
                  ->default('pending');
            $table->integer('nominal')
                  ->default(0);
            $table->integer('goal');
            $table->dateTime('end_date');
            $table->text('note')
                  ->nullable();
            $table->string('receiver');
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
        Schema::dropIfExists('campaigns');
    }
}
