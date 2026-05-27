CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nickname TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    is_confirmed INTEGER NOT NULL DEFAULT 0,
    role TEXT NOT NULL CHECK (role IN ('admin', 'user')),
    password_hash TEXT NOT NULL,
    auth_token TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS articles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    author_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    text TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);
INSERT INTO users (
        nickname,
        email,
        is_confirmed,
        role,
        password_hash,
        auth_token
    )
SELECT 'admin',
    'admin@example.com',
    1,
    'admin',
    'hash1',
    'token1'
WHERE NOT EXISTS (
        SELECT 1
        FROM users
        WHERE nickname = 'admin'
    );
INSERT INTO users (
        nickname,
        email,
        is_confirmed,
        role,
        password_hash,
        auth_token
    )
SELECT 'user',
    'user@example.com',
    1,
    'user',
    'hash2',
    'token2'
WHERE NOT EXISTS (
        SELECT 1
        FROM users
        WHERE nickname = 'user'
    );
INSERT INTO articles (author_id, name, text)
SELECT 1,
    'Путешествие в Японию',
    'Откройте для себя красоту Японии: от храмов Киото до шумных улиц Токио. Исследуйте традиционную культуру и современные технологии.'
WHERE NOT EXISTS (
        SELECT 1
        FROM articles
        WHERE name = 'Путешествие в Японию'
    );
INSERT INTO articles (author_id, name, text)
SELECT 1,
    'Приключение в Альпах',
    'Горные вершины, живописные долины и очаровательные деревушки. Полное руководство по лучшим маршрутам для треккинга в Европейских Альпах.'
WHERE NOT EXISTS (
        SELECT 1
        FROM articles
        WHERE name = 'Приключение в Альпах'
    );
INSERT INTO articles (author_id, name, text)
SELECT 2,
    'Экзотический отдых на Мальдивах',
    'Погрузитесь в райский отдых на Мальдивах: белоснежные пляжи, кристально чистые воды и роскошные бунгало на воде. Идеальное место для романтического отпуска или медового месяца.'
WHERE NOT EXISTS (
        SELECT 1
        FROM articles
        WHERE name = 'Экзотический отдых на Мальдивах'
    );
CREATE TABLE IF NOT EXISTS tour_tags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    label TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS tours (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    price INTEGER NOT NULL,
    duration_days INTEGER NOT NULL,
    tag_id INTEGER NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tag_id) REFERENCES tour_tags(id)
);
INSERT INTO tour_tags (name, label)
SELECT 'beach',
    'Пляжный'
WHERE NOT EXISTS (
        SELECT 1
        FROM tour_tags
        WHERE name = 'beach'
    );
INSERT INTO tour_tags (name, label)
SELECT 'mountain',
    'Горный'
WHERE NOT EXISTS (
        SELECT 1
        FROM tour_tags
        WHERE name = 'mountain'
    );
INSERT INTO tour_tags (name, label)
SELECT 'city',
    'Городской'
WHERE NOT EXISTS (
        SELECT 1
        FROM tour_tags
        WHERE name = 'city'
    );
INSERT INTO tour_tags (name, label)
SELECT 'adventure',
    'Приключенческий'
WHERE NOT EXISTS (
        SELECT 1
        FROM tour_tags
        WHERE name = 'adventure'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Мальдивы — рай на земле',
    'Белоснежные пляжи, лазурные воды и подводное плавание с маской. Всё включено.',
    120000,
    10,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'beach'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Мальдивы — рай на земле'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Таиланд — жемчужина Азии',
    'Тропические острова, буддийские храмы и знаменитая тайская кухня. Незабываемый отдых.',
    85000,
    14,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'beach'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Таиланд — жемчужина Азии'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Альпы — покорение вершин',
    'Треккинг по живописным маршрутам, горные хижины и захватывающие панорамы Европейских Альп.',
    95000,
    8,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'mountain'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Альпы — покорение вершин'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Кавказ — дикая природа',
    'Пешие походы по Большому Кавказскому хребту, ночи у костра и горные озёра.',
    45000,
    7,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'mountain'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Кавказ — дикая природа'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Токио — город будущего',
    'Ультрасовременные технологии, аниме-культура, суши и сакура. Полное погружение в японскую жизнь.',
    110000,
    12,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'city'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Токио — город будущего'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Париж — город любви',
    'Эйфелева башня, Лувр, круассаны и прогулки по Сене. Классика европейского туризма.',
    80000,
    6,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'city'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Париж — город любви'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Амазония — в сердце джунглей',
    'Экспедиция по тропическим лесам Амазонки: уникальная флора, фауна и местные племена.',
    150000,
    14,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'adventure'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Амазония — в сердце джунглей'
    );
INSERT INTO tours (name, description, price, duration_days, tag_id)
SELECT 'Исландия — земля огня и льда',
    'Гейзеры, северное сияние, ледниковые пещеры и водопады. Настоящее приключение на краю света.',
    130000,
    9,
    (
        SELECT id
        FROM tour_tags
        WHERE name = 'adventure'
    )
WHERE NOT EXISTS (
        SELECT 1
        FROM tours
        WHERE name = 'Исландия — земля огня и льда'
    );