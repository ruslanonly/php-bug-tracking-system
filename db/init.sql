-- init.sql
USE bts_database;

CREATE TABLE company (
    id INT AUTO_INCREMENT,
    name VARCHAR(20),
    description VARCHAR(200),
    PRIMARY KEY (id)
);

CREATE TABLE product (
    id INT AUTO_INCREMENT,
    name VARCHAR(20) UNIQUE NOT NULL,
    company_id INT,
    description VARCHAR(200),
    moderated BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id)
);

CREATE TABLE report (
    id INT AUTO_INCREMENT,
    name VARCHAR(200),
    description VARCHAR(500),
    product_id INT,
    status INT NOT NULL DEFAULT 0,
    priority INT DEFAULT 0,
    problem INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES product(id),
    CONSTRAINT CHECK_REPORT CHECK (status >= 0 AND status <= 4 AND priority >= 0 AND priority <= 4 AND problem >= 0)
);

INSERT INTO company (name, description) VALUES
('Blindtyping Inc.', 'Компания, которая занимается разработкой сайта blindtyping.com (основной продукт)'),
('Ucheba Inc.', 'Компания, которая занимается разработкой VK MiniApp ucheba.com (основной продукт)'),
('MiniApp Inc.', 'Компания, которая занимается разработкой VK MiniApp приложений');

INSERT INTO product (name, description, company_id) VALUES
('blindtyping.com', 'Сайт для слепой печати', 1),
('Ucheba MiniApp', 'Приложение, позволяющее эффективно структурировать учебные процессы.', 2),
('Sudoku VK MiniApp ', 'Игра Судоку', 3),
('Schedule VK MiniApp ', 'Мини-приложение для организации расписания в учебной группе', 3),
('Twinby VK Miniapp', 'Приложение для знакомств', 3);

INSERT INTO report (name, description, product_id, priority, problem) VALUES
('Плохо выглядит 1', 'Плохо выглядит основное меню', 1, 0, 0),
('Плохо выглядит 2', 'Плохо выглядит sidebar', 1, 1, 1),
('Плохо выглядит 3', 'Плохо выглядит sidebar', 2, 2, 2),
('Плохо выглядит 3', 'Плохо выглядит sidebar', 2, 2, 7),
('Не нажимается кнопочка', 'Кнопка на основном экране не работает', 2, 2, 7);