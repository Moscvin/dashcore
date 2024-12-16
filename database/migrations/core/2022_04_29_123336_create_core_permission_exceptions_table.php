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
        Schema::create('core_permission_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('core_menu_id')->constrained('core_menus')->onDelete('cascade');
            $table->foreignId('core_user_id')->constrained('core_users')->onDelete('cascade');
            $table->string('permission', 20)->nullable();
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
        Schema::dropIfExists('core_permission_exceptions');
    }
};
