<?php
namespace Modules\Central\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Central\Entities\Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company . " " . $this->faker->companySuffix,
            'document' => $this->faker->cnpj,
            'domain' => rand(0, 1) ? collect(explode('.', $this->faker->domainName))->first() : $this->faker->domainName,
            'license' => env('DB_DATABASE') . '_' . Str::random(10),
            'date_start' => Carbon::now(),
        ];
    }
}
