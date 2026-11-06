<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            ['name' => 'Динамо', 'city' => 'Київ'],
            ['name' => 'Шахтар', 'city' => 'Донецьк'],
            ['name' => 'Олександрія', 'city' => 'Олександрія'],
            ['name' => 'Полісся', 'city' => 'Житомир'],
            ['name' => 'Рух', 'city' => 'Львів'],
        ];

        foreach ($teams as $team) {
            Team::firstOrCreate($team);
        }
    }
}
