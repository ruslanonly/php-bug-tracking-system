INSERT INTO product (name, description) VALUES
('blindtyping.com', 'Сайт для слепой печати'),
('Ucheba MiniApp', 'Приложение, позволяющее эффективно структурировать учебные процессы.'),
('Sudoku VK MiniApp ', 'Игра Судоку'),
('Schedule VK MiniApp ', 'Мини-приложение для организации расписания в учебной группе'),
('Twinby VK Miniapp', 'Приложение для знакомств');

INSERT INTO report (name, product_id, priority, problem, playback_steps, actual_result, expected_result) VALUES
('Плохо выглядит 1', 1, 0, 0, '', '', ''),
('Плохо выглядит 2', 1, 1, 1, '', '', ''),
('Плохо выглядит 3', 2, 2, 2, '', '', ''),
('Плохо выглядит 3', 2, 2, 7, '', '', ''),
('Не нажимается кнопочка', 2, 2, 7, '', '', '');
