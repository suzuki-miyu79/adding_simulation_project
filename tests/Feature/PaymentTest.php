<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController;

class PaymentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testPaymentTest()
    {
        // テスト用の商品を作成
        $item = Item::factory()->create();

        // テスト用のユーザーIDを作成
        $userId = $this->faker->randomNumber();

        // Stripeの処理をモック
        $mockStripe = $this->mock(\Stripe\Charge::class);
        $mockStripe->shouldReceive('create')->once()->andReturn((object) ['id' => 'fake_charge_id']);

        // コントローラのアクションを実行
        $response = $this->post(route('charge', ['item_id' => $item->id]), [
            'stripeToken' => 'fake_token', // テスト用のStripeトークン
        ]);

        // データベースに購入情報が保存されていることを確認
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_user_id' => $userId,
        ]);

        // 正しいビューが返されることを確認
        $response->assertViewIs('thanks');

        // エラーメッセージがないことを確認
        $response->assertSessionHasNoErrors();
    }

    public function test_charge_action_failure()
    {
        // Stripeの処理をモックして例外をスローさせる
        $mockStripe = $this->mock(\Stripe\Charge::class);
        $mockStripe->shouldReceive('create')->once()->andThrow(new \Exception('Test Stripe Error'));

        // コントローラのアクションを実行
        $response = $this->post(route('charge', ['item_id' => 1]), [
            'stripeToken' => 'fake_token', // テスト用のStripeトークン
        ]);

        // エラーメッセージがセッションに設定されていることを確認
        $response->assertSessionHas('error', '支払い処理中にエラーが発生しました。もう一度お試しください。');
    }
}