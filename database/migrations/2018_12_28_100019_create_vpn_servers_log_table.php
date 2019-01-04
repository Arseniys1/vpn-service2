<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpnServersLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpn_servers_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_id')->nullable();
            $table->integer('vpn_server_id');
            $table->integer('user_id')->nullable();
            $table->enum('type', ['request', 'response']);
            $table->string('action');
            $table->text('data')->nullable();
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
        Schema::dropIfExists('vpn_servers_log');
    }
}
