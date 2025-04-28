<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'name_boite' => $this->faker->company(),
            'prenom_client' => $this->faker->firstName(),
            'nom_client' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'numero_telephone' => $this->faker->phoneNumber(),
            'numero_mobile' => $this->faker->phoneNumber(),
        ];
    }
}
