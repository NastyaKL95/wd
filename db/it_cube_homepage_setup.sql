-- IT-Куб: подготовка главной страницы набора в WordPress
-- Важно: скрипт рассчитан на стандартный префикс таблиц wp_.
-- Если у вас другой префикс, замените wp_ на свой.

START TRANSACTION;

-- 1) Активируем тему лендинга.
INSERT INTO wp_options (option_name, option_value, autoload)
VALUES ('template', 'it-cube-enrollment', 'yes')
ON DUPLICATE KEY UPDATE option_value = 'it-cube-enrollment';

INSERT INTO wp_options (option_name, option_value, autoload)
VALUES ('stylesheet', 'it-cube-enrollment', 'yes')
ON DUPLICATE KEY UPDATE option_value = 'it-cube-enrollment';

-- 2) Создаём страницу для главной, если она ещё не существует.
SET @front_page_id = (
    SELECT ID
    FROM wp_posts
    WHERE post_name = 'it-cube-enrollment-home'
      AND post_type = 'page'
      AND post_status IN ('publish', 'draft', 'pending', 'private')
    ORDER BY ID DESC
    LIMIT 1
);

INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_password,
    post_name,
    to_ping,
    pinged,
    post_modified,
    post_modified_gmt,
    post_content_filtered,
    post_parent,
    guid,
    menu_order,
    post_type,
    post_mime_type,
    comment_count
)
SELECT
    1,
    NOW(),
    UTC_TIMESTAMP(),
    'Главная страница формируется шаблоном front-page.php темы IT Cube Enrollment.',
    'Главная IT-Куб',
    '',
    'publish',
    'closed',
    'closed',
    '',
    'it-cube-enrollment-home',
    '',
    '',
    NOW(),
    UTC_TIMESTAMP(),
    '',
    0,
    'https://it-cube.zabedu.ru/?page_id=0',
    0,
    'page',
    '',
    0
WHERE @front_page_id IS NULL;

SET @front_page_id = IF(@front_page_id IS NULL OR @front_page_id = 0, LAST_INSERT_ID(), @front_page_id);

-- 3) Включаем статическую главную страницу.
INSERT INTO wp_options (option_name, option_value, autoload)
VALUES ('show_on_front', 'page', 'yes')
ON DUPLICATE KEY UPDATE option_value = 'page';

INSERT INTO wp_options (option_name, option_value, autoload)
VALUES ('page_on_front', CAST(@front_page_id AS CHAR), 'yes')
ON DUPLICATE KEY UPDATE option_value = CAST(@front_page_id AS CHAR);

-- 4) Базовые контактные поля для футера (можно заменить в админке или SQL).
INSERT INTO wp_options (option_name, option_value, autoload)
VALUES ('it_cube_contact_phone', '[добавить номер]', 'yes')
ON DUPLICATE KEY UPDATE option_value = '[добавить номер]';

INSERT INTO wp_options (option_name, option_value, autoload)
VALUES ('it_cube_contact_email', '[добавить e-mail]', 'yes')
ON DUPLICATE KEY UPDATE option_value = '[добавить e-mail]';

INSERT INTO wp_options (option_name, option_value, autoload)
VALUES ('it_cube_contact_address', '[добавить адрес]', 'yes')
ON DUPLICATE KEY UPDATE option_value = '[добавить адрес]';

COMMIT;
