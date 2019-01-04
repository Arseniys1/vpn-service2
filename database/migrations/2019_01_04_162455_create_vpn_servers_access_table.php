<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpnServersAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpn_servers_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vpn_servers_log_id');
            $table->integer('vpn_server_id');
            $table->integer('user_id');
            $table->text('ovpn')->nullable();
            $table->enum('status', ['open', 'close']);
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
        Schema::dropIfExists('vpn_servers_access');
    }
}
