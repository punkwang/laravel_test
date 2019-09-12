<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberOpenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_open', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('member_id');
            $table->string('zone',12);
            $table->string('open_id', 64);
            $table->string('sub_open_id', 64)->nullable(true);
            $table->string('token',256)->nullable(true);
            $table->text('info');
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
        Schema::dropIfExists('member_open');
    }
}
