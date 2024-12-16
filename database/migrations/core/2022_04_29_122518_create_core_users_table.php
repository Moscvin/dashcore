<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('core_group_id')->constrained('core_groups')->onDelete('cascade');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('surname');
            $table->rememberToken();
            $table->string('app_token', 100)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('first_login')->default(true);
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
        Schema::dropIfExists('core_users');
    }
};
