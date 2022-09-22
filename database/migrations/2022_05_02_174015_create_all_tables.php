<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('user_verify', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('cnpj');
            $table->string('code')->nullable($value = true);
            $table->timestamps();
        });
        Schema::connection('mysql')->create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('cnpj');
            $table->timestamps();
        });
        Schema::connection('mysql')->table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('cnpj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
