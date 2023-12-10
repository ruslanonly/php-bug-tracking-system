-- init.sql
USE bts_database;

CREATE TABLE product (
    id INT AUTO_INCREMENT,
    name VARCHAR(20) UNIQUE NOT NULL,
    description VARCHAR(200),
    moderated BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id)
);

CREATE TABLE report (
    id INT AUTO_INCREMENT,
    name VARCHAR(250) NOT NULL,
    product_id INT,
    playback_steps VARCHAR(1000) NOT NULL,
    actual_result VARCHAR(1000) NOT NULL,
    expected_result VARCHAR(1000) NOT NULL,
    status INT NOT NULL DEFAULT 0,
    priority INT DEFAULT 0,
    problem INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES product(id),
    CONSTRAINT CHECK_REPORT CHECK (status >= 0 AND status <= 4 AND priority >= 0 AND priority <= 4 AND problem >= 0)
);
ALTER TABLE report CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO product (name, description, company_id) VALUES
('blindtyping.com', 'Сайт для слепой печати', 1),
('Ucheba MiniApp', 'Приложение, позволяющее эффективно структурировать учебные процессы.', 2),
('Sudoku VK MiniApp ', 'Игра Судоку', 3),
('Schedule VK MiniApp ', 'Мини-приложение для организации расписания в учебной группе', 3),
('Twinby VK Miniapp', 'Приложение для знакомств', 3);

INSERT INTO report (name, product_id, priority, problem) VALUES
('Плохо выглядит 1', 1, 0, 0),
('Плохо выглядит 2', 1, 1, 1),
('Плохо выглядит 3', 2, 2, 2),
('Плохо выглядит 3', 2, 2, 7),
('Не нажимается кнопочка', 2, 2, 7);
