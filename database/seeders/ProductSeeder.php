<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name'        => 'AirPods',
                'description' => 'Беспроводные',
                'category_id' => 5,
                'price'       => 20000,
                'image'       => 'https://www.cnet.com/a/img/resize/66e6ea3dc191424c5a4ab5a0ea649595e024b6f8/hub/2016/09/13/1d528046-b515-48e5-a170-b9895ec09e89/apple-airpods-2016-014.jpg?auto=webp&fit=crop&height=900&width=1200'
            ],
            [
                'name'        => 'Смартфон Itel A17 16 ГБ голубой',
                'description' => 'Сенсорный',
                'category_id' => 7,
                'price'       => 3999,
                'image'       => 'https://c.dns-shop.ru/thumb/st4/fit/200/200/a5a04939a6562582b04002a5e86c68e8/43d3064523a5ed21578841ffb3a7662d274177ab1e92b78250a25bd44de625a1.jpg.webp'
            ],
            [
                'name'        => 'Philips Xenium E590 черный',
                'description' => 'Кнопочный',
                'category_id' => 6,
                'price'       => 5899,
                'image'       => 'https://main-cdn.sbermegamarket.ru/big1/hlr-system/-13/766/316/749/261/636/100028735051b0.jpg'
            ],
            [
                'name'        => 'Mi Band 7',
                'description' => 'Смарт-часы',
                'category_id' => 9,
                'price'       => 4000,
                'image'       => 'https://main-cdn.sbermegamarket.ru/big1/hlr-system/-96/016/168/811/722/600008563109b0.jpeg'
            ],
            [
                'name'        => 'Casio',
                'description' => 'Наручные',
                'category_id' => 8,
                'price'       => 15000,
                'image'       => 'http://casio-shops.ru/image/cache/catalog/files/dJkPpl5zwaDtJ8j0jIQRaA-500x500.jpg'
            ],
            [
                'name'        => 'Портативная колонка JBL Boombox 2 Black',
                'description' => 'Беспроводная',
                'category_id' => 4,
                'price'       => 33000,
                'image'       => 'https://ipioneer.ru/static/content/images/items/55a2e364cfd298307817acd94941e9b6b4b3a8d6e4046bca3a2af88f30a739f8.jpg'
            ],
        ]);
    }
}
