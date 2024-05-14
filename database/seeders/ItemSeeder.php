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
                'child_category_id' => 3,
                'condition_id' => 2,
                'name' => '美顔器',
                'brand' => 'coachtech beauty',
                'description' => '動作確認済みです。自宅保管ですのでご理解のある方のみご検討お願いします！',
                'price' => '5000',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/biganki.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 4,
                'condition_id' => 1,
                'name' => 'チーク',
                'brand' => 'coachtech make',
                'description' => 'カラー：ベビーピンク 新品未開封です。',
                'price' => '1500',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/cheek.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 1,
                'condition_id' => 2,
                'name' => 'チノパン ベージュ L',
                'description' => '全体的に使用感少なめで膝擦れやアタリ無くメンズのused品としてはまずまず綺麗なコンディションです。',
                'price' => '2300',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/chinopan.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 6,
                'condition_id' => 3,
                'name' => 'ヘッドマッサージャー',
                'description' => '持ち手に擦り傷がありますが、まだまだお使いいただけます。',
                'price' => '999',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/head.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 6,
                'condition_id' => 1,
                'name' => '電動カッサ',
                'brand' => 'coachtech beauty',
                'description' => '温熱と振動のダブル効果で、全身のお手入れをするのがオススメです。',
                'price' => '520',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/kassa.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 3,
                'condition_id' => 1,
                'name' => '化粧水',
                'brand' => 'coachtech make',
                'description' => '箱はつきませんが、プチプチに包んで発送させて頂きます。',
                'price' => '1000',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/keshousui.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 4,
                'condition_id' => 2,
                'name' => 'リップスティック',
                'brand' => 'coachtech make',
                'description' => '1回使用しました。使用品の為、神経質な方や完璧を求める方の購入は御遠慮下さい。',
                'price' => '1200',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/rouge.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 5,
                'condition_id' => 1,
                'name' => '鉄分サプリ',
                'description' => '業界最高水準の鉄分10mg配合。鉄分不足にはもう悩まない！サポート成分も豊富！',
                'price' => '2100',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/sapuri.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 1,
                'condition_id' => 2,
                'name' => 'メンズ タイダイシャツ',
                'description' => 'サイズ：XL 目立った傷汚れはありません。',
                'price' => '700',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/T-shirt.png',
                'seller_user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_category_id' => 2,
                'condition_id' => 3,
                'name' => 'ロングワンピース',
                'description' => '中古品となりますので、ご理解の上購入お願いします。',
                'price' => '980',
                'image' => 'https://market09-bucket.s3.ap-northeast-1.amazonaws.com/wanpi.png',
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
