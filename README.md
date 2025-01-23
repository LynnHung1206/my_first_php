## PHP 初學日記
### 安裝環境
- ide下載 
- Php下載
```cmd
brew install php
```
- 配置環境
  - PhpStorm -> setting -> PHP
  - CLI Interpreter 右側的 ... 按鈕。
  - 在新彈出的窗口中，點擊左上角的 +，然後選擇 From Local
  - 瀏覽並選擇 PHP 的執行檔路徑 
  - ```which php``` 可找到執行檔路徑

### 套件管理器 composer

- 安裝
```cmd
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```
```cmd
composer -v
```
- 初始化 -> 到專案下
```cmd
composer init
```
要求輸入一些東西，然後生成composer.json

