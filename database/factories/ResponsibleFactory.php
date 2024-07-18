<?php

namespace Database\Factories;

use App\Models\Responsible;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Responsible>
 */
class ResponsibleFactory extends Factory
{
    protected $model = Responsible::class;

    public function definition()
    {
        return [
            'id_responsible' => $this->faker->unique()->regexify('RESP-[0-9]{4}'),
            'id_user' => User::all()->random()->id,
            'card_id' => $this->faker->numerify('##########'),
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'area' => $this->faker->word,
            'role' => $this->faker->jobTitle,
            'status' => $this->faker->boolean,
        ];
    }
}
