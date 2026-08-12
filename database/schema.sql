-- Jalankan script ini di pgAdmin (Query Tool) setelah membuat database "berca_login"

CREATE TABLE IF NOT EXISTS users (
    id          SERIAL PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    full_name   VARCHAR(100),
    created_at  TIMESTAMP DEFAULT NOW()
);

-- Contoh data user untuk testing login.
-- Password plain: "password123"
-- Hash di b"awah dibuat dengan password_hash('password123', PASSWORD_DEFAULT) di PHP.
INSERT INTO "User" (username, password, employee_id)
VALUES (
    'admin',
    'admin@berca.co.id',
    '$2y$10$1vDIO879kLkokH7kfPy1SumOPnPe.1Rdsl4Goqgf2aoU2uRQqb.KK',
    'Administrator'
)
ON CONFLICT (username) DO NOTHING;
