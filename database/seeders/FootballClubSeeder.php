<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FootballClubSeeder extends Seeder
{
    public function run(): void
    {
        // Очищаємо таблицю перед додаванням (щоб не було дублікатів)
        DB::table('clubs')->truncate();

        DB::table('clubs')->insert([
            ['name' => 'Шахтар', 'city' => 'Донецьк', 'founded_year' => 1936, 'stadium' => 'Арена Львів', 'points' => 45],
            ['name' => 'Полісся', 'city' => 'Житомир', 'founded_year' => 1959, 'stadium' => 'Центральний', 'points' => 38],
            ['name' => 'Харків', 'city' => 'Харків', 'founded_year' => 2005, 'stadium' => 'Металіст', 'points' => 25],
            ['name' => 'Динамо', 'city' => 'Київ', 'founded_year' => 1927, 'stadium' => 'НСК Олімпійський', 'points' => 48],
            ['name' => 'Карпати', 'city' => 'Львів', 'founded_year' => 1963, 'stadium' => 'Україна', 'points' => 27],
            ['name' => 'ЛНЗ', 'city' => 'Черкаси', 'founded_year' => 2006, 'stadium' => 'Черкаси-Арена', 'points' => 26],
            ['name' => 'Зоря', 'city' => 'Луганськ', 'founded_year' => 1923, 'stadium' => 'Славутич-Арена', 'points' => 28],
            ['name' => 'Епіцентр', 'city' => 'Кам\'янець-Подільський', 'founded_year' => 2019, 'stadium' => 'Тонкочеєва', 'points' => 20],
            ['name' => 'Верес', 'city' => 'Рівне', 'founded_year' => 1957, 'stadium' => 'Авангард', 'points' => 21],
            ['name' => 'Колос', 'city' => 'Ковалівка', 'founded_year' => 2012, 'stadium' => 'Колос', 'points' => 24],
            ['name' => 'Буковина', 'city' => 'Чернівці', 'founded_year' => 1958, 'stadium' => 'Буковина', 'points' => 18],
            ['name' => 'Лівий Берег', 'city' => 'Київ', 'founded_year' => 2017, 'stadium' => 'Лівий Берег', 'points' => 16],
            ['name' => 'Оболонь', 'city' => 'Київ', 'founded_year' => 2013, 'stadium' => 'Оболонь-Арена', 'points' => 22],
            ['name' => 'Чорноморець', 'city' => 'Одеса', 'founded_year' => 1936, 'stadium' => 'Чорноморець', 'points' => 23],
            ['name' => 'Кудрівка', 'city' => 'Кудрівка', 'founded_year' => 1982, 'stadium' => 'Кудрівка-Арена', 'points' => 15],
            ['name' => 'Кривбас', 'city' => 'Кривий Ріг', 'founded_year' => 1959, 'stadium' => 'Гірник', 'points' => 35],
        ]);
    }
}
