<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentTest()
    {
        // テスト用のデータを作成
        $item = Item::factory()->create();

        // テスト用のユーザーを作成し、認証状態にする
        $user = User::factory()->create();
        $this->actingAs($user);

        // Stripeの処理をモック
        $mockStripe = $this->mock(\Stripe\Charge::class);
        $mockStripe->shouldReceive('create')->once()->andReturn((object) ['id' => 'fake_charge_id']);

        // コントローラのアクションを実行
        $response = $this->post(route('charge', ['item_id' => $item->id]), [
            'stripeToken' => 'fake_token', // テスト用のStripeトークン
        ]);

        // データベースに購入情報を挿入
        Purchase::create([
            'item_id' => $item->id,
            'buyer_user_id' => $user->id,
        ]);

        // データベースに購入情報が保存されていることを確認
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_user_id' => $user->id,
        ]);

        // リダイレクト先が正しいことを確認
        $response->assertRedirect(route('complete', ['item_id' => $item->id]));

        // リダイレクト後のビューが正しいことを確認
        $this->get(route('complete', ['item_id' => $item->id]))
            ->assertViewIs('complete');

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