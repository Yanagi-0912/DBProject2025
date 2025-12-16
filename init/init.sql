
-- 遊戲分享平台 - 資料庫初始化腳本
-- 本檔會在容器第一次啟動時由 MariaDB 自動執行
-- 依據 docker-compose 的 MYSQL_DATABASE 環境變數建立於預設資料庫中

-- 注意：請勿在此硬編 USE <DB_NAME>，以便配合 .env 中 DB_NAME 的設定

-- 1) 使用者資料表
--    欄位命名配合 src/api 程式碼 (id, username, account, password)
CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    account VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    follower_count INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_account (account)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2) 遊戲資料表
CREATE TABLE IF NOT EXISTS games (
    game_id INT NOT NULL AUTO_INCREMENT,
    game_title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NULL,
    platform VARCHAR(100) NULL,
    genre VARCHAR(100) NULL,
    price DECIMAL(10,2) NULL,
    image VARCHAR(255) NULL,
    PRIMARY KEY (game_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3) 文章資料表（貼文）
CREATE TABLE IF NOT EXISTS posts (
    post_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    game_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    rating TINYINT NULL,
    post_date DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    image_url VARCHAR(255) NULL,
    PRIMARY KEY (post_id),
    KEY idx_posts_user_id (user_id),
    KEY idx_posts_game_id (game_id),
    CONSTRAINT fk_posts_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_posts_game
        FOREIGN KEY (game_id) REFERENCES games (game_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4) 範例資料
-- 使用者（密碼以應用程式註冊 API 產生雜湊，這裡放示意字串）
INSERT INTO users (username, account, password, follower_count)
VALUES
    ('capoo', '01257002', '123456', 0)
ON DUPLICATE KEY UPDATE username = VALUES(username);

-- 遊戲
INSERT INTO games (game_title, description, platform, genre, price, image) VALUES
    ('魔法少女ノ魔女裁判', '視覺小說 推理遊戲 galgame', 'PC', 'Visual Novel', 398.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIQJKFky9TgNt0Ip9hctDNqJXfqach0ZZmQA&s'),
    ('Honkai: Star Rail', '回合制 劇情 Turn-based RPG', 'PC / PS5 / Mobile', 'Turn-based RPG', 0.00, 'https://upload.wikimedia.org/wikipedia/zh/1/11/Honkai%EF%BC%9AStar_Rail%E5%B4%A9%E5%A3%9E%EF%BC%9A%E6%98%9F%E7%A9%B9%E9%90%B5%E9%81%93.png'),
    ('Elden Ring', '開放世界動作 RPG', 'PC / PS5 / Xbox', 'Action RPG', 1790.00, 'https://upload.wikimedia.org/wikipedia/zh/6/62/Elden_Ring_cover.png'),
    ('Genshin Impact', '開放世界動作 RPG', 'Android / iOS / PC', 'Action RPG', 0.00, 'https://upload.wikimedia.org/wikipedia/zh/f/fc/%E5%8E%9F%E7%A5%9E_%E5%9C%8B%E9%9A%9B%E7%89%88.jpeg');


-- 貼文（範例：user 1 評論 game 1）
INSERT INTO posts (user_id, game_id, title, content, rating, image_url, post_date)
VALUES
    (1, 1, '好玩', '超級神作，劇情超讚', 10, 'images/post1.jpg', '2025-01-18 21:30:00');
