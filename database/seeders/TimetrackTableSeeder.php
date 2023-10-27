<?php

namespace Database\Seeders;

use App\Models\Timetrack;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class TimetrackTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $immutable = CarbonImmutable::now();
        Timetrack::factory()->create([
            'id' => 1,
            'user_id' => 1,
            'project_id' => 1,
            'start_time' => $immutable->sub(10, 'hour'),
            'end_time' => $immutable->sub(9, 'hour'),
        ]);
        Timetrack::factory()->create([
            'id' => 2,
            'user_id' => 1,
            'project_id' => 2,
            'start_time' => $immutable->sub(8, 'hour'),
            'end_time' => $immutable->sub(7, 'hour'),
        ]);
        Timetrack::factory()->create([
            'id' => 3,
            'user_id' => 2,
            'project_id' => 1,
            'start_time' => $immutable->sub(5, 'hour'),
            'end_time' => $immutable->sub(3, 'hour'),
        ]);
        Timetrack::factory()->create([
            'id' => 4,
            'user_id' => 2,
            'project_id' => 2,
            'start_time' => $immutable->sub(5, 'hour'),
            'end_time' => $immutable->sub(3, 'hour'),
        ]);

    }
}
