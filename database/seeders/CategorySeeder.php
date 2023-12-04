<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
           [
               'id'        => 1,
               'name'      => 'Аудиотехника',
               'parent_id' => 0
           ],
            [
                'id'        => 2,
                'name'      => 'Смартфоны и сотовые телефоны',
                'parent_id' => 0
            ],
            [
                'id'        => 3,
                'name'      => 'Часы',
                'parent_id' => 0
            ],
            [
                'id'        => 4,
                'name'      => 'Колонки',
                'parent_id' => 1
            ],
            [
                'id'        => 5,
                'name'      => 'Наушники',
                'parent_id' => 1
            ],
            [
                'id'        => 6,
                'name'      => 'Кнопочные',
                'parent_id' => 2
            ],
            [
                'id'        => 7,
                'name'      => 'Сенсорные',
                'parent_id' => 2
            ],
            [
                'id'        => 8,
                'name'      => 'Обычные часы',
                'parent_id' => 3
            ],
            [
                'id'        => 9,
                'name'      => 'Смарт-часы',
                'parent_id' => 3
            ],
        ]);
    }
}
