# Render 部署檢查清單

## 必要設定

### 1. 環境變數配置
在 Render Dashboard 中設定以下變數：
- `PORT` → 留空或設為預設值（Render 自動指派）
- `DB_HOST` → 資料庫主機地址
- `DB_NAME` → 資料庫名稱
- `DB_USER` → 資料庫使用者
- `DB_PASSWORD` → 資料庫密碼

### 2. 資料庫連線
- Render 不提供免費 MySQL，需使用：
  - **Neon** (PostgreSQL)
  - **Railway.app** (MySQL)
  - **Planetscale** (MySQL)
  - **自建 VPS** 上的 MySQL

### 3. Dockerfile 檢查
✅ 監聽環境變數 PORT（動態監聽）
✅ Apache 配置正確
✅ PHP 擴展完整
✅ 根索引入口配置

### 4. Docker 構建驗證
```bash
docker build -t gamehub:latest .
docker run -p 8080:80 -e PORT=8080 gamehub:latest
```

### 5. render.yaml 配置
- 設定正確的 GitHub repo URL
- 配置資料庫連線字串
- 設置環境變數來源

## 常見問題

**Q: Port 403 錯誤**
A: 檢查 `/src/index.php` 根索引是否存在

**Q: 資料庫連線失敗**
A: 確認環境變數正確，且資料庫允許遠端連線

**Q: 502 Bad Gateway**
A: 查看 Render Logs，確認 Apache/PHP 正常啟動
