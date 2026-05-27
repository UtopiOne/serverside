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