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
        Schema::create('core_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('core_province_id')->constrained('core_provinces')->onDelete('cascade');
            $table->string('name', 255)->nullable();
            $table->char('zip', 5)->nullable();
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
        Schema::dropIfExists('core_cities');
    }
};
