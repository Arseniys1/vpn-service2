<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpnServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpn_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id');
            $table->string('ip', 100);
            $table->string('port', 100);
            $table->string('vps_username')->nullable();
            $table->string('vps_password')->nullable();
            $table->integer('max_online')->default(1);
            $table->integer('online_counter')->default(0);
            $table->boolean('online')->default(false);
            $table->boolean('show')->default(false);
            $table->boolean('banned')->default(false);
            $table->boolean('free')->default(false);
            $table->string('token', 30);
            $table->text('ovpn_config')->nullable();
            $table->integer('cpu')->default(0);
            $table->integer('ram')->default(0);
            $table->integer('hdd')->default(0);
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
        Schema::dropIfExists('vpn_servers');
    }
}
