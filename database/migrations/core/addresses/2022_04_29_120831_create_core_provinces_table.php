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
        Schema::create('core_provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('core_region_id')->nullable()->constrained('core_regions')->onDelete('cascade');
            $table->string('name');
            $table->char('short_name', 6);
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
        Schema::dropIfExists('core_provinces');
    }
};
