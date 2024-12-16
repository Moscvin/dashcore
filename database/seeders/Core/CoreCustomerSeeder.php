<?php

namespace Database\Seeders\Core;

use Illuminate\Database\Seeder;
use App\Models\Core\CoreCustomer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
class CoreCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customersJson = json_decode(Storage::disk('public')->get('/json/core_customers.json'), true);

        foreach ($customersJson as $customerJson) {
            CoreCustomer::create([
                'is_company' => $customerJson['is_company'],
                'company_name' => $customerJson['company_name'],
                'surname' => $customerJson['surname'],
                'name' => $customerJson['name'],

                'date_birth' => $customerJson['date_birth'],
                'city_birth' => $customerJson['city_birth'],
                'province_birth' => $customerJson['province_birth'],
                'vat' => $customerJson['vat'],
                'code_fiscal' => $customerJson['code_fiscal'],

                'phone_1' => $customerJson['phone_1'],
                'prefix_1' => $customerJson['prefix_1'],
                'phone_2' => $customerJson['phone_2'],
                'prefix_2' => $customerJson['prefix_2'],
                'fax' => $customerJson['fax'],
                'prefix_fax' => $customerJson['prefix_fax'],
                'email' => $customerJson['email'],
                'pec' => $customerJson['pec'],

                'country_sl' => $customerJson['country_sl'],
                'province_sl' => $customerJson['province_sl'],
                'city_sl' => $customerJson['city_sl'],
                'zip_sl' => $customerJson['zip_sl'],
                'street_address_sl' => $customerJson['street_address_sl'],
                'house_number_sl' => $customerJson['house_number_sl'],


                'rl_surname' => $customerJson['rl_surname'],
                'rl_name' => $customerJson['rl_name'],
                'rl_phone_1' => $customerJson['rl_phone_1'],
                'rl_prefix_1' => $customerJson['rl_prefix_1'],
                'rl_phone_2' => $customerJson['rl_phone_2'],
                'rl_prefix_2' => $customerJson['rl_prefix_2'],
                'rl_email' => $customerJson['rl_email'],

                'referent_description' => $customerJson['referent_description'],
                'referent_name' => $customerJson['referent_name'],
                'referent_surname' => $customerJson['referent_surname'],
                'referent_phone_1' => $customerJson['referent_phone_1'],
                'referent_prefix_1' => $customerJson['referent_prefix_1'],
                'referent_phone_2' => $customerJson['referent_phone_2'],
                'referent_prefix_2' => $customerJson['referent_prefix_2'],
                'referent_email' => $customerJson['referent_email'],

                'active' => $customerJson['active']
            ]);
        }

        $faker = Faker::create('it_IT'); // Use Italian locale

        for ($i = 0; $i < 10; $i++) {
            CoreCustomer::create([
                'is_company' => $faker->boolean, // Randomly choose if it's a company or not
                'company_name' => $faker->company, // Generates a random company name
                'surname' => $faker->lastName, // Generates a random surname
                'name' => $faker->firstName, // Generates a random first name
                'date_birth' => $faker->optional()->date(), // Optionally generates a birth date
                'city_birth' => $faker->city, // Generates a random Italian city
                'province_birth' => $faker->stateAbbr, // Generates a random Italian province
                'vat' => $faker->vat(), // Generates a random VAT ID (Partita IVA)
                'code_fiscal' => $faker->taxId(), // Generates a random Italian tax code (Codice Fiscale)
                'phone_1' => $faker->phoneNumber, // Generates a random phone number
                'prefix_1' => '+39', // Italian prefix
                'phone_2' => $faker->optional()->phoneNumber, // Optional second phone number
                'prefix_2' => $faker->optional()->randomElement(['+39', '+41']), // Optional prefix for the second number
                'fax' => $faker->optional()->phoneNumber, // Optional fax number
                'prefix_fax' => '+39', // Fax prefix
                'email' => $faker->optional()->email, // Generates a random email
                'pec' => $faker->optional()->email, // Generates a random PEC (certified email)

                // Shipping address (SL)
                'country_sl' => 'ITALIA', 
                'province_sl' => $faker->stateAbbr, 
                'city_sl' => $faker->city, 
                'zip_sl' => $faker->postcode, // Generates a valid Italian ZIP code
                'street_address_sl' => $faker->streetName, 
                'house_number_sl' => $faker->buildingNumber,

                // Optional Secondary Office (SO)
                'country_so' => $faker->optional()->randomElement(['ITALIA', null]),
                'province_so' => $faker->optional()->stateAbbr,
                'city_so' => $faker->optional()->city,
                'zip_so' => $faker->optional()->postcode,
                'street_address_so' => $faker->optional()->streetName,
                'house_number_so' => $faker->optional()->buildingNumber,

                // Legal Representative (RL)
                'rl_surname' => $faker->optional()->lastName, 
                'rl_name' => $faker->optional()->firstName, 
                'rl_phone_1' => $faker->optional()->phoneNumber,
                'rl_prefix_1' => $faker->optional()->randomElement(['+39', '+41']),
                'rl_phone_2' => $faker->optional()->phoneNumber,
                'rl_prefix_2' => $faker->optional()->randomElement(['+39', '+41']),
                'rl_email' => $faker->optional()->email,

                // Referent (Referente)
                'referent_description' => $faker->optional()->jobTitle,
                'referent_name' => $faker->optional()->firstName,
                'referent_surname' => $faker->optional()->lastName,
                'referent_phone_1' => $faker->optional()->phoneNumber,
                'referent_prefix_1' => $faker->optional()->randomElement(['+39', '+41']),
                'referent_phone_2' => $faker->optional()->phoneNumber,
                'referent_prefix_2' => $faker->optional()->randomElement(['+39', '+41']),
                'referent_email' => $faker->optional()->email,
                'active' => $faker->boolean, // Randomly set the active status
            ]);
        }

        
    }
}
