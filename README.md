# Atte(勤怠管理システム)

## 環境構築
### Dockerビルド

　1. `git clone git@github.com:YamaguchiTomoaki/Atte.git`  
　2. DockerDesktopアプリを立ち上げる  
　3. `docker compose up -d --build`  
　*MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせてdocker-compose.ymlファイルを編集してください  

### Laravel環境構築

　1. `docker compose exec php bash`  
　2. `composer install`  
　3. 「.env.example」ファイルを「.env」ファイルに命名を変更。又は、新しく「.env」ファイルを作成  
　4. 「.env」ファイルに以下の環境変数を追加  

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass  
    
　5. アプリケーションキーの作成
 
    php artisan key:generate

  6. マイグレーションの実行

    php artisan migrate

## 使用技術(実行環境)
* PHP 8.2.19
* Laravel 10.48.11
* MySQL 8.0.26

## ER図
![スクリーンショット 2024-07-19 172624](https://github.com/user-attachments/assets/92f1d83c-c80b-4ed6-8945-f72758d6b14b)

## URL
* 開発環境：http://localhost/
* phpMyAdmin：http://localhost:8080/
