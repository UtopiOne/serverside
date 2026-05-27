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
    'admin@gmail.com',
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
    'user@gmail.com',
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
    'Статья №1',
    'Можно взять что-то вроде Lorem Ipsum.'
WHERE NOT EXISTS (
        SELECT 1
        FROM articles
        WHERE name = 'Статья №1'
    );
INSERT INTO articles (author_id, name, text)
SELECT 1,
    'Статья №2',
    'Можно взять что-то вроде Lorem Ipsum.'
WHERE NOT EXISTS (
        SELECT 1
        FROM articles
        WHERE name = 'Статья №2'
    );