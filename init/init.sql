
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
    ('capoo', '01257002', '123456', 0),
    ('thugcreeper', '12345@gmail', 'aabbcc', 0)
ON DUPLICATE KEY UPDATE username = VALUES(username);
-- 遊戲
INSERT INTO games (game_title, description, platform, genre, price, image) VALUES
    ('魔法少女ノ魔女裁判', '視覺小說 推理遊戲 galgame', 'PC', 'Visual Novel', 398.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIQJKFky9TgNt0Ip9hctDNqJXfqach0ZZmQA&s'),
    ('Honkai: Star Rail', '回合制 劇情 Turn-based RPG', 'PC / PS5 / Mobile', 'Turn-based RPG', 0.00, 'https://upload.wikimedia.org/wikipedia/zh/1/11/Honkai%EF%BC%9AStar_Rail%E5%B4%A9%E5%A3%9E%EF%BC%9A%E6%98%9F%E7%A9%B9%E9%90%B5%E9%81%93.png'),
    ('Elden Ring', '開放世界動作 RPG', 'PC / PS5 / Xbox', 'Action RPG', 1790.00, 'https://upload.wikimedia.org/wikipedia/zh/6/62/Elden_Ring_cover.png'),
    ('Genshin Impact', '開放世界動作 RPG', 'Android / iOS / PC', 'Action RPG', 0.00, 'https://upload.wikimedia.org/wikipedia/zh/f/fc/%E5%8E%9F%E7%A5%9E_%E5%9C%8B%E9%9A%9B%E7%89%88.jpeg'),
    ('PUGB: Battlegrounds', '大逃殺射擊遊戲', 'PC / Console / Mobile', 'Battle Royale', 0.00, 'https://cdn1.epicgames.com/spt-assets/53ec4985296b4facbe3a8d8d019afba9/pubg-battlegrounds-16v1j.jpg');
    ('特展硬漢','《特戰硬漢》是一款主打 高強度動作與戰術射擊 的軍事風格遊戲。','PC','Action',0,'https://cmsassets.rgpub.io/sanity/images/dsfx7636/content_organization/731216ff2453134e530feabc9dbd3c44e480e352-1200x625.jpg?accountingTag=VAL');
    ('植物大戰殭屍','《植物大戰殭屍》是一款結合策略與塔防元素的遊戲，玩家需要利用各種植物來抵禦殭屍的入侵。','PC / Mobile','Strategy / Tower Defense',100,'https://static.wikia.nocookie.net/plantsvszombies/images/0/01/Pvz_logo_stacked_rgb.png/revision/latest?cb=20150520132615');
    ('Arcaea,','《Arcaea》是一款音樂節奏遊戲，玩家需要跟隨音樂的節奏點擊螢幕上的音符。','Mobile','Rhythm',0,'hhttps://play-lh.googleusercontent.com/6vtKnbt-Rd5y5KIDHUy5adgZAmHBKBMmat0MiRh53qPYr6KqIvgSsYcqAQCsP_CeXXM');
    ('Geogusser','《Geoguessr》是一款地理知識遊戲，玩家需要根據隨機生成的街景圖像來猜測自己的位置。','Web','Geography / Trivia',0,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP-MVMbidvg5KaftAVjHBVNh_62vrEEJ5mgw&s');
    ('瘟疫公司','《瘟疫公司》是一款策略模擬遊戲，玩家需要設計並控制一種致命的病毒，目標是感染並消滅全球人口。','PC / Mobile','Strategy / Simulation',50,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQX3kjb_5CElkijzwbOb2xtmlWMZpxIRbzpHA&s');
    ('貓咪大戰爭','《貓咪大戰爭》是一款結合策略與塔防元素的遊戲，玩家需要利用各種貓咪來抵禦敵人的入侵。','PC / Mobile','Strategy / Tower Defense',0,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgA9hODOo4NsAAZomJKsMKiT6V0XqSWxHO2w&s');
    ('Phigros','《Phigros》是一款音樂節奏遊戲，玩家需要跟隨音樂的節奏點擊螢幕上的音符。','PC / Mobile','Rhythm',0,'https://play-lh.googleusercontent.com/IQHEMsqUXxWdPNSFD42NgAGoVf9n3HEMfUQ2rMWj8o1Ioi_UHCYJ9g3TK-jYm2yEzdo');
-- 貼文（範例：user 1 評論 game 1）
INSERT INTO posts (user_id, game_id, title, content, rating, image_url, post_date)
VALUES
    (1, 1, '好玩', '超級神作，劇情超讚', 10, 'images/post1.jpg', '2025-01-18 21:30:00'),
    (2, 5, '還不錯', '越改越爛，唉', 8, 'images/post2.jpg', '2025-02-10 15:45:00');
    (1, 3, 'Elden Ring 評測', '這款遊戲的開放世界設計非常出色，戰鬥系統也很有深度。推薦給喜歡挑戰的玩家！', 9, 'images/post3.jpg', '2025-03-05 10:20:00'),
    (2, 4, '原神心得', '遊戲畫面精美，角色設計多樣，但抽卡系統讓人有點失望。整體來說還是值得一玩。', 7, 'images/post4.jpg', '2025-04-12 18:55:00');
--建立procedure：依使用者 ID 取得貼文列表
DELIMITER $$
CREATE PROCEDURE getpostByUserId(IN userId INT)
BEGIN
    SELECT 
        p.post_id,
        p.title,
        p.content,
        p.rating,
        p.post_date,
        p.image_url,
        u.id AS user_id,
        u.username,
        g.game_id,
        g.game_title,
        g.platform,
        g.genre,
        g.price
    FROM posts p
    JOIN users u ON p.user_id = u.id
    JOIN games g ON p.game_id = g.game_id
    WHERE p.user_id = userId
    ORDER BY p.post_date DESC;
END
$$
DELIMITER ;

--建立trigger: 每當有新貼文插入時，更新使用者的 follower_count，
DELIMITER $$
CREATE TRIGGER updateFollowerCount
AFTER INSERT ON posts

FOR EACH ROW
BEGIN
    UPDATE users
    SET follower_count = follower_count + 
        addRandomFollowers(1, (SELECT COUNT(*) FROM posts WHERE user_id = NEW.user_id))
    WHERE id = NEW.user_id;
END
$$
DELIMITER ;

--建立function:隨機增加一定區間的follower
DELIMITER $$
CREATE FUNCTION addRandomFollowers(minIncrease INT,  post_count INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE randomIncrease INT;
    DECLARE maxIncrease INT;

    IF post_count BETWEEN 1 AND 10 THEN
        SET maxIncrease = 5;
    ELSEIF post_count BETWEEN 11 AND 50 THEN
        SET maxIncrease = 10;
    ELSE
        SET maxIncrease = 7;
    END IF;

    SET randomIncrease = FLOOR(RAND() * (maxIncrease - minIncrease + 1)) + minIncrease;
    RETURN randomIncrease;
END$$
DELIMITER ;