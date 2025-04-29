<?php

namespace Database\Factories;

use App\Enums\Sexo;
use App\Models\Desenvolvedor;
use App\Models\Nivel;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class DesenvolvedorFactory extends Factory
{
    protected $model = Desenvolvedor::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->word(),
            'sexo' => $this->faker->randomElement(Sexo::cases()),
            'data_nascimento' => CarbonImmutable::now()->subYears(rand(18, 60)),
            'hobby' => $this->faker->word(),
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now(),

            'nivel_id' => Nivel::factory(),
        ];
    }
}
