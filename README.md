# DBProject2025

資料庫系統課程專題

組員:01257012游承諺，01257007王洪賢，01257002張宸翊

## 環境需求

- Docker
- Docker Compose

## 技術規格

- PHP 8.2.4
- MariaDB 10.4.28
- Apache Web Server

## 快速開始

1. 複製環境設定檔：

```bash
cp .env.example .env
```

2. 啟動 Docker 容器：

```bash
docker-compose up -d
```

3. 訪問應用程式：
   - 網站應用程式：http://localhost:8080/public/
   - phpMyAdmin 資料庫管理介面：http://localhost:8081

## 資料庫管理

本專案整合了 phpMyAdmin，提供直覺的圖形化介面來管理資料庫：

**訪問 phpMyAdmin**：http://localhost:8081

**登入資訊**：

- 伺服器：`db`
- 使用者名稱：`dbuser`（或使用 `root` 以完整權限登入）
- 密碼：`dbpassword`（root 密碼為 `rootpassword`）

**功能**：

- 瀏覽和編輯資料表
- 執行 SQL 查詢
- 匯入/匯出資料庫
- 管理使用者權限
- 檢視資料庫結構

## 開發指令

```bash
# 啟動容器
docker-compose up -d

# 停止容器
docker-compose down

# 查看日誌
docker-compose logs -f

# 重新建置映像
docker-compose build --no-cache

# 進入 PHP 容器
docker-compose exec web bash

# 進入 MariaDB 容器
docker-compose exec db mysql -u dbuser -p
```

## 專案結構

```
.
├── Dockerfile           # PHP 容器設定
├── docker-compose.yml   # Docker Compose 設定
├── .env.example         # 環境變數範例
├── src/                 # PHP 應用程式原始碼
│ ├── public/		 # PHP 應用程式公開程式碼
└── init/                # 資料庫初始化腳本
```
