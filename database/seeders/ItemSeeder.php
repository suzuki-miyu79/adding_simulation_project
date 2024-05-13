<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemsData = [
            [
                'child_category_id' => 5,
                'condition_id' => 2,
                'name' => 'ポケットモンスター バイオレット',
                'brand' => 'NINTENDO SWITCH',
                'description' => '動作確認済みです。自宅保管ですのでご理解のある方のみご検討お願いします！',
                'price' => '4000',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/game-poke.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 1,
                'condition_id' => 2,
                'name' => '9mm バンドTシャツ',
                'brand' => '9mm parabellum bullet',
                'description' => '20周年アニバーサリーTシャツです。サイズはメンズのLLです。',
                'price' => '1500',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/T-men.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 5,
                'condition_id' => 3,
                'name' => 'クレヨンしんちゃんオラと博士の夏休み～おわらない七日間の旅～プレミアムボックス',
                'brand' => 'ニンテンドースイッチ',
                'description' => 'Nintendo Switchソフト「クレヨンしんちゃん『オラと博士の夏休み』～おわらない七日間の旅～」特装版です。ビジュアルブックとアクション仮面絵日記帳がついています。',
                'price' => '3333',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/game-summer.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 6,
                'condition_id' => 2,
                'name' => 'ぐるり森大冒険 シーリヴァイア キラカード',
                'description' => '表面には傷等無くきれいな状態です。',
                'price' => '900',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/card-149.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 3,
                'condition_id' => 3,
                'name' => 'ワンピース1巻',
                'brand' => '集英社',
                'description' => 'ワンピースの1巻初版です。擦り傷があります。',
                'price' => '300',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/comic-1.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 3,
                'condition_id' => 1,
                'name' => 'ワンピース107巻',
                'brand' => '集英社',
                'description' => 'ワンピースの107巻初版です。特典のシール付きです。',
                'price' => '300',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/comic-107.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 2,
                'condition_id' => 2,
                'name' => 'BISH バンドTシャツ',
                'brand' => 'BISH',
                'description' => 'サイズ:レディースL',
                'price' => '1000',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/T-woman.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 6,
                'condition_id' => 2,
                'name' => 'ぐるり森大冒険 キラ ランドユニコ',
                'description' => '子どもがぐるりが好きで良くやっていましたが、卒業したようなので出品しました。',
                'price' => '700',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/card-151.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 6,
                'condition_id' => 2,
                'name' => 'おかあさんといっしょ 卒業特集',
                'brand' => '講談社',
                'description' => 'よしおにいさん、りさおねえさんの卒業特集号です。',
                'price' => '200',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/magazine.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 4,
                'condition_id' => 3,
                'name' => '',
                'description' => '最強レベル シージェネシスのカードになります。',
                'price' => '1250',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/card-213.jpg',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // アイテムデータをテーブルに挿入
        foreach ($itemsData as $item) {
            DB::table('items')->insert($item);
        }
    }
}
