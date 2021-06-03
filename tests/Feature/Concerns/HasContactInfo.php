<?php

namespace Pleets\Tests\Feature\Concerns;

trait HasContactInfo
{
    protected function generateContactInfo(): array
    {
        return [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'companyName' => $this->faker->address,
            'address1' => $this->faker->name,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'country' => $this->faker->countryCode,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email
        ];
    }
}
