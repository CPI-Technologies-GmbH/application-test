<?php

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TimetrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $immutable = CarbonImmutable::now();
        return [
            'id' => 1,
            'user_id' => 1,
            'project_id' => 1,
            'start_time' => $immutable->sub(1, 'hour'),
            'end_time' => $immutable,
        ];
    }

}
