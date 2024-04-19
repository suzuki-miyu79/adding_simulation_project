<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController;

class PaymentTest extends TestCase
{
    public function testPaymentProcess()
    {
        // テストデータの準備
        $itemId = 1; // 商品ID
        $token = 'tok_visa'; // ダミーの支払いトークン

        // テスト用のRequestオブジェクトを作成
        $request = new Request([
            'itemId' => $itemId,
        ]);

        // StripeのMockを作成（テスト用のダミーデータを返す）
        $stripeMock = $this->createMock(\Stripe\Stripe::class);
        $stripeMock->method('setApiKey')->willReturn(true);
        $stripeMock->method('createToken')->willReturn((object) ['token' => ['id' => $token]]);
        \Stripe\Stripe::setApiKey('dummy_secret_key'); // 仮のシークレットキーを設定

        // コントローラーのインスタンスを作成
        $controller = new PaymentController();

        // テスト対象のメソッドを呼び出し
        $response = $controller->charge($request, $itemId);

        // アサーション：期待される結果を確認
        $this->assertInstanceOf(RedirectResponse::class, $response); // リダイレクトレスポンスが返されることを確認
        $this->assertEquals('thanks', $response->getTargetUrl()); // 正しいリダイレクト先URLが返されることを確認
    }
}