#!/usr/bin/env bash
set -euo pipefail

if [[ ! -f ".env" ]]; then
  echo "Файл .env не найден. Скопируйте .env.example в .env и заполните значения."
  exit 1
fi

set -a
source ./.env
set +a

docker compose up -d db wordpress

echo "Ожидаем готовность базы данных..."
for i in {1..40}; do
  if docker compose run --rm --profile tools wpcli db check >/dev/null 2>&1; then
    break
  fi
  sleep 3
done

if ! docker compose run --rm --profile tools wpcli db check >/dev/null 2>&1; then
  echo "База данных не стала доступной вовремя."
  exit 1
fi

if ! docker compose run --rm --profile tools wpcli core is-installed >/dev/null 2>&1; then
  echo "Устанавливаем WordPress..."
  docker compose run --rm --profile tools wpcli core install \
    --url="${WP_HOME}" \
    --title="${WP_SITE_TITLE}" \
    --admin_user="${WP_ADMIN_USER}" \
    --admin_password="${WP_ADMIN_PASSWORD}" \
    --admin_email="${WP_ADMIN_EMAIL}" \
    --skip-email
else
  echo "WordPress уже установлен."
fi

echo "Активируем тему и применяем базовые настройки..."
docker compose run --rm --profile tools wpcli theme activate it-cube-enrollment
docker compose run --rm --profile tools wpcli option update blogdescription "Бесплатное IT-обучение для детей и подростков 7-18 лет"
docker compose run --rm --profile tools wpcli option update timezone_string "Asia/Chita"
docker compose run --rm --profile tools wpcli rewrite structure "/%postname%/" --hard

if ! docker compose run --rm --profile tools wpcli post list --post_type=post --name=dobro-pozhalovat-v-it-kub --field=ID --format=ids | grep -q .; then
  docker compose run --rm --profile tools wpcli post create \
    --post_type=post \
    --post_status=publish \
    --post_title="Добро пожаловать в IT-Куб" \
    --post_name="dobro-pozhalovat-v-it-kub" \
    --post_content="Открыт набор на новый учебный год. Следите за новостями и мероприятиями центра на этом сайте."
fi

echo "Готово. Сайт: ${WP_HOME}"
echo "Админка: ${WP_HOME}/wp-admin"
