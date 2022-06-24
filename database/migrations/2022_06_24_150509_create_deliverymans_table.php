<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverymansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverymans', function (Blueprint $table) {
            $table->id();
            $table->string('dm_name');
            $table->string('dm_password');
            $table->string('dm_email');
            $table->string('dm_phone');
            $table->string('dm_nid');
            $table->date('dm_dob');
            $table->string('dm_gender');
            $table->double('dm_rating');
            $table->string('dm_status');

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
        Schema::dropIfExists('deliverymans');
    }
}
