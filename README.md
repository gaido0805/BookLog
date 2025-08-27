# BookLog - 読書ログ管理システム

Clean Architectureを使用した読書ログ管理システムです。

## 機能

- 新規会員登録
- ログイン機能
- 読んだ本のタイトルと読んだ日、読んだ感想の保存
- 読書ログの一覧表示・編集・削除

## 技術スタック

### バックエンド
- Laravel 8 (Clean Architecture)
- MySQL 8.0
- Docker

### フロントエンド
- Nuxt 2
- Vue.js
- Tailwind CSS
- Axios
- js-cookie (認証トークン管理)

## プロジェクト構造

```
BookLog/
├── api/                 # Laravel API (Clean Architecture)
│   ├── app/
│   │   ├── Domain/      # ドメイン層
│   │   │   ├── Entities/
│   │   │   ├── Repositories/
│   │   │   └── UseCases/
│   │   ├── Infrastructure/  # インフラストラクチャ層
│   │   │   └── Repositories/
│   │   └── Interfaces/      # インターフェース層
│   │       ├── Controllers/
│   │       ├── Requests/
│   │       └── Resources/
│   ├── database/
│   │   └── migrations/
│   └── routes/
│       └── api.php
├── frontend/            # Nuxt 2 フロントエンド
│   ├── pages/
│   ├── components/
│   ├── layouts/
│   └── middleware/
├── docker-compose.yml   # Docker環境設定
└── README.md
```

## セットアップ

### 1. リポジトリのクローン
```bash
git clone <repository-url>
cd BookLog
```

### 2. Docker環境の起動
```bash
docker-compose up -d
```

### 3. API側のセットアップ
```bash
# APIコンテナに入る
docker-compose exec api bash
docker-compose exec api sh

# アプリケーションキーの生成
php artisan key:generate

# データベースマイグレーション
php artisan migrate

# ストレージの権限設定
chmod -R 775 storage bootstrap/cache
```

### 4. フロントエンド側のセットアップ
```bash
# フロントエンドコンテナに入る
docker-compose exec frontend sh

# 依存関係のインストール
npm install
```

## アクセス

- フロントエンド: http://localhost:3000
- API: http://localhost:8000
- phpMyAdmin: http://localhost:8080
- MySQL: localhost:3306

## Clean Architecture

このプロジェクトはClean Architectureパターンに従って設計されています：

- **Entities**: ビジネスロジックの中心となるエンティティ
- **Use Cases**: アプリケーションのビジネスルール
- **Interface Adapters**: 外部システムとのインターフェース
- **Frameworks & Drivers**: フレームワークやデータベース

## API エンドポイント

### 認証
- `POST /api/auth/register` - ユーザー登録
- `POST /api/auth/login` - ログイン
- `POST /api/auth/logout` - ログアウト
- `GET /api/auth/user` - ユーザー情報取得

### 読書ログ
- `GET /api/books` - 読書ログ一覧取得
- `POST /api/books` - 読書ログ作成
- `GET /api/books/{id}` - 読書ログ詳細取得
- `PUT /api/books/{id}` - 読書ログ更新
- `DELETE /api/books/{id}` - 読書ログ削除

## 開発

### フロントエンド開発サーバーの起動
```bash
docker-compose exec frontend npm run dev
```

### API開発サーバーの起動
```bash
docker-compose exec api php artisan serve --host=0.0.0.0 --port=8000
```

## 認証システム

このプロジェクトでは、カスタム認証システムを使用しています：
- Laravel Sanctumを使用したトークンベース認証
- js-cookieを使用したクライアントサイドでのトークン管理
- Axiosインターセプターによる自動的な認証ヘッダーの追加

## 注意事項

- 初回起動時は、データベースの準備が完了するまで数分かかる場合があります
- フロントエンドとAPIの両方が起動していることを確認してからアクセスしてください
