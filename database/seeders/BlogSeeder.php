<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogTranslation;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [];
        foreach (['Новини УПЛ', 'Трансфери', 'Матчі та Огляди', 'Інтервʼю'] as $name) {
            $categories[] = Category::firstOrCreate([
                'category_name' => $name,
            ]);
        }

        $posts = [
            [
                'uk' => ['title' => 'Шахтар перемагає у центральному матчі туру', 'desc' => 'Донецький клуб здобув впевнену перемогу з рахунком 2:0.', 'text' => 'Детальний звіт про матч між лідерами чемпіонату УПЛ. Гра була насичена гострими моментами.'],
                'en' => ['title' => 'Shakhtar wins the central match of the round', 'desc' => 'The Donetsk club secured a confident 2:0 victory.', 'text' => 'Detailed match report between the leaders of the UPL. The game was full of sharp moments.']
            ],
            [
                'uk' => ['title' => 'Динамо підписує нового півзахисника', 'desc' => 'Кияни оголосили про трансфер молодого таланту.', 'text' => 'Контракт розрахований на 4 роки. Гравець уже приєднався до тренувань з основною командою.'],
                'en' => ['title' => 'Dynamo signs a new midfielder', 'desc' => 'Kyiv announced the transfer of a young talent.', 'text' => 'The contract is signed for 4 years. The player has already joined first-team training.']
            ],
            [
                'uk' => ['title' => 'Підсумки 10-го туру Української Прем’єр-Ліги', 'desc' => 'Огляд усіх результатів та турнірної таблиці.', 'text' => 'Аналітика матчів, найкращі голи та несподівані результати вікенду.'],
                'en' => ['title' => 'UPL Matchday 10 Roundup', 'desc' => 'Review of all results and table standings.', 'text' => 'Match analysis, top goals and unexpected weekend results.']
            ],
            [
                'uk' => ['title' => 'Інтервʼю з головним тренером Полісся', 'desc' => 'Думки про тактику, підготовку та цілі на сезон.', 'text' => 'Тренер розповів про зміни у складі та майбутні виклики в чемпіонаті.'],
                'en' => ['title' => 'Interview with Polissya Head Coach', 'desc' => 'Thoughts on tactics, preparation, and season goals.', 'text' => 'The coach spoke about roster changes and upcoming championship challenges.']
            ],
            [
                'uk' => ['title' => 'Олександрія піднімається у топ-3', 'desc' => 'Перемога на виїзді дозволила команді закріпитися серед лідерів.', 'text' => 'Яскравий матч з трьома забитими м’ячами подарував уболівальникам справжнє свято.'],
                'en' => ['title' => 'Oleksandriya moves into top 3', 'desc' => 'An away victory helped the team solidify its place among the leaders.', 'text' => 'An exciting match with three goals gave fans a real football celebration.']
            ],
            [
                'uk' => ['title' => 'Збірна України формує розширений список', 'desc' => 'Гравці УПЛ отримали виклики до національної команди.', 'text' => 'Головний тренер викликав 8 представників з вітчизняного чемпіонату.'],
                'en' => ['title' => 'Ukraine National Team forms expanded squad', 'desc' => 'UPL players receive national team call-ups.', 'text' => 'The head coach called up 8 representatives from the domestic league.']
            ],
            [
                'uk' => ['title' => 'Реконструкція стадіону в Житомирі завершена', 'desc' => 'Оновлена арена готова приймати матчі найвищого рівня.', 'text' => 'Встановлено нове освітлення та сучасні сидіння для вболівальників.'],
                'en' => ['title' => 'Stadium reconstruction in Zhytomyr completed', 'desc' => 'The renovated arena is ready to host top-level matches.', 'text' => 'New lighting and modern seating for fans have been installed.']
            ],
            [
                'uk' => ['title' => 'Календар наступних матчів УПЛ', 'desc' => 'Розклад і час початку ігор 11-го туру.', 'text' => 'Дізнайтеся, коли грає ваша улюблена команда наступного вікенду.'],
                'en' => ['title' => 'Upcoming UPL Fixtures Calendar', 'desc' => 'Schedule and kick-off times for Matchday 11.', 'text' => 'Find out when your favorite team plays next weekend.']
            ],
        ];

        foreach ($posts as $i => $data) {
            $cat = $categories[$i % count($categories)];
            $blog = Blog::create([
                'title' => $data['uk']['title'],
                'description' => $data['uk']['desc'],
                'text' => $data['uk']['text'],
                'category_id' => $cat->category_id,
                'user_id' => null,
            ]);

            BlogTranslation::create([
                'blog_id' => $blog->blog_id,
                'locale' => 'uk',
                'title' => $data['uk']['title'],
                'description' => $data['uk']['desc'],
                'text' => $data['uk']['text'],
            ]);

            BlogTranslation::create([
                'blog_id' => $blog->blog_id,
                'locale' => 'en',
                'title' => $data['en']['title'],
                'description' => $data['en']['desc'],
                'text' => $data['en']['text'],
            ]);
        }
    }
}
