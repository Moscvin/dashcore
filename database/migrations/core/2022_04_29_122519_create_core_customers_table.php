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
        Schema::create('core_customers', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_company')->default(true);
            $table->string('company_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('name')->nullable();

            $table->date('date_birth')->nullable();
            $table->string('city_birth')->nullable();
            $table->string('province_birth')->nullable();
            $table->string('country_birth')->nullable()->default('Italia');
            $table->string('country_fiscal')->nullable()->default('Italia');
            $table->string('vat')->nullable();
            $table->string('code_fiscal')->nullable();
            //Contact data
            $table->string('phone_1', 100)->nullable();
            $table->string('prefix_1', 4)->nullable();
            $table->string('phone_2', 100)->nullable();
            $table->string('prefix_2', 4)->nullable();
            $table->string('fax', 100)->nullable();
            $table->string('prefix_fax', 4)->nullable();
            $table->string('email')->nullable();
            $table->string('pec')->nullable();
            //Addresses
            $table->string('country_sl')->nullable()->default('Italia');
            $table->string('province_sl')->nullable();
            $table->string('city_sl')->nullable();
            $table->string('zip_sl')->nullable();
            $table->string('street_address_sl')->nullable();
            $table->string('house_number_sl')->nullable();
            $table->string('country_so')->nullable()->default('Italia');
            $table->string('province_so')->nullable();
            $table->string('city_so')->nullable();
            $table->string('zip_so')->nullable();
            $table->string('street_address_so')->nullable();
            $table->string('house_number_so')->nullable();
            //Reference persons
            $table->string('rl_surname')->nullable();
            $table->string('rl_name')->nullable();
            $table->string('rl_phone_1', 100)->nullable();
            $table->string('rl_prefix_1', 4)->nullable();
            $table->string('rl_phone_2', 100)->nullable();
            $table->string('rl_prefix_2', 400)->nullable();
            $table->string('rl_email')->nullable();
            $table->text('referent_description')->nullable();
            $table->string('referent_name')->nullable();
            $table->string('referent_surname')->nullable();
            $table->string('referent_phone_1', 100)->nullable();
            $table->string('referent_prefix_1', 4)->nullable();
            $table->string('referent_phone_2', 100)->nullable();
            $table->string('referent_prefix_2', 4)->nullable();
            $table->string('referent_email', 255)->nullable();
            //Other data
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('core_customers');
    }
};
