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
        Schema::create('core_menus', function (Blueprint $table) {
            $table->id();
            $table->string('description', 50);
            $table->integer('parent_id')->default(0);
            $table->boolean('show')->default(1);
            $table->integer('list_order')->default(0);
            $table->string('icon', 50)->nullable();
            $table->string('link', 100)->nullable();
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
        Schema::dropIfExists('core_menus');
    }
};
