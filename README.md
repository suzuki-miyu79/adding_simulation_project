# coachtechフリマ
- ネットフリマサービス
![スクリーンショット 2024-05-14 140713](https://github.com/suzuki-miyu79/adding_simulation_project/assets/144597636/eb58b68a-1341-4c97-8caa-ca916819e26d)

## 作成した目的
- coachtechブランドのアイテムを出品するため。

## アプリケーションURL
開発環境：http://localhost/

本番環境：http://18.183.149.215/

### テスト用アカウント（開発・本番）
[管理者アカウント]
- メールアドレス：admin@abc.com
- パスワード：12345678

[一般ユーザーアカウント]
- メールアドレス：test@abc.com
- パスワード：12345678

## 機能一覧
- 認証
    - 会員登録
    - ログイン
    - ログアウト
- 商品取得機能
    - 商品一覧取得
    - 商品詳細取得
    - 商品お気に入り一覧取得
- ユーザー情報取得機能
    - 購入商品一覧取得
    - 出品商品詳細取得
    - プロフィール変更
    - 配送先変更
- お気に入り機能
    - お気に入り追加
    - お気に入り削除
- コメント機能
    - コメント追加
- 商品購入機能
    - Stripeを利用した決済
    - 支払方法の選択・変更
- 管理機能
    - ユーザー情報削除
    - コメント削除
- 検索機能
    - 商品検索
    - ユーザー検索（管理）
    - コメント検索（管理）
    - データ作成日検索（管理）
- メール送信機能
    - 宛先全件選択・解除機能
- ストレージ保存機能
- バリデーション
- 郵便番号入力時、住所自動表示機能
- レスポンシブデザイン（768px, 480px）
- PHPUnitを使用したテスト機能
- Circle CIを使用したデプロイとテストの自動化

## 使用技術（実行環境）
### プログラミング言語
- フロントエンド：HTML/CSS

- バックエンド：PHP(8.3.6)

### フレームワーク
- Laravel 11.0.8

### データベース
- MySQL 8.0.32

## テーブル設計
![スクリーンショット 2024-05-14 141431](https://github.com/suzuki-miyu79/adding_simulation_project/assets/144597636/f4318f76-5392-4463-99ac-f5bed00deae7)

## ER図
![ECサイト-ER図 drawio](https://github.com/suzuki-miyu79/adding_simulation_project/assets/144597636/d00f9e34-f480-4a54-8462-58b31f70ace5)

# 環境構築
### 1．Laravel Sailをインストール
- Laravel sailをインストールするディレクトリに移動し、Laravel sailをインストールします。
  
  curl -s "https://laravel.build/adding_simulation_project" | bash

### 2．Laravel sailを起動する
- 「adding_simulation_project」ディレクトリへ移動し、Laravel sailを起動するコマンドを実行します。
  
  cd adding_simulation_project
 
  ./vendor/bin/sail up

### 3．環境変数の変更
- .envの環境変数を変更します。
    - メール設定
  ```
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=465
  MAIL_USERNAME=<送信元gmailのアドレス>   #gmailの場合、USERNAMEはFROM_ADDRESSと同じ
  MAIL_PASSWORD=<アプリパスワード>　#gmailで二段階認証とアプリパスワードの発行を行ってください
  MAIL_ENCRYPTION=ssl
  MAIL_FROM_ADDRESS=<送信元gmailのアドレス>
  MAIL_FROM_NAME="${APP_NAME}"
  ```
    - Stripe設定
  ```
  STRIPE_KEY= # 公開可能キーを入力
  STRIPE_SECRET= # シークレットキーを入力
  ```
### 4．phpMyAdminを追加する
- 次の設定をdocker-compose.ymlに追加します。
```
   phpmyadmin:
        image: phpmyadmin/phpmyadmin
        links:
            - mysql:mysql
        ports:
            - 8080:80
        environment:
            MYSQL_USERNAME: '${DB_USERNAME}'
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            PMA_HOST: mysql
        networks:
            - sail
```
### 5．Laravel Breeze(ユーザー認証パッケージ)のインストール
- larabel/breezeのパッケージを追加します。

  ./vendor/bin/sail composer require larabel/breeze --dev

- breezeをインストールします。

  ./vendor/bin/sail artisan breeze:install

### 6．migrateコマンドの実行
- マイグレーションファイルの内容をデータベースに反映させます。

  ./vendor/bin/sail artisan migrate

### 7．ダミーデータの作成
- シーディングでダミーデータを作成します。

  ./vendor/bin/sail artisan db:seed

### 8．ストレージ設定
- アップロードした画像を格納するディレクトリを作成します。

  touch storage/app/public/item_images

  touch storage/app/public/profile_images

- シンボリックリンクを設定します。

  ./vendor/bin/sail artisan storage:link

### 9．PHPUnitを使用したテストの実行
- テストDBにマイグレーションを適用します。

  ./vendor/bin/sail artisan migrate --database=mysql_test

- シーディングを実行します。

　./vendor/bin/sail artisan db:seed --database=mysql_test

- テスト内容は、/tests配下のファイルを必要に応じて修正してください。
- 実行するテストファイルは、phpunit.xml内で変更できます。

- テストを実行します。

　./vendor/bin/sail artisan test

### 10．Circle CIを使用したデプロイとテストの自動化
- GithubにてEC2で作成した公開キーを登録し、Circle CI上で環境変数設定とEC2インスタンスの秘密キーを登録してください。
- config.ymlを修正してください。
  ```
  deploy:
        machine:
            image: circleci/classic:edge
        steps:
            - checkout
            - add_ssh_keys:
                fingerprints:
                  # CircleCI上でSSHキー登録を行った際に作成されるfingerprintsを記入！！
                  - ××:××:××:××:××:××:××:××:××:××:××:××:××:××:××:××
            #この箇所の［EC2上のプロジェクトパス］を自身のパスに書き換え！！
            - run: ssh ${USER_NAME}@${HOST_NAME} 'cd ［EC2上のプロジェクトパス］ && git pull'
  ```