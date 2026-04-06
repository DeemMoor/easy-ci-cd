# Easy CI/CD

Простое PHP-приложение с настроенными пайплайнами GitLab CI/CD и GitHub Actions.

## Приложение

- PHP 8.4
- `index.php` — выводит "Hello, World!"
- Зависимости управляются через Composer

## Docker

Сборка разделена на два образа.

**`Dockerfile.base`** — базовый образ на основе `php:8.4-fpm`. Устанавливает системные пакеты, PHP-расширения (`pdo_mysql`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`), Composer и зависимости проекта. Публикуется с тегом `:deps`.

**`Dockerfile`** — финальный образ. Наследуется от базового (`:deps`) через `ARG BASE_IMAGE`, копирует исходный код приложения. Публикуется с тегом `:latest`.

Образы публикуются в:
- GitLab Registry: `registry.gitlab.com/dm_webpractik/cicdskill`
- GitHub Container Registry: `ghcr.io/deeemmoor/easy-ci-cd`

## GitLab CI/CD

Пайплайн состоит из трёх стадий, запускается только на ветке `master`:

**build-base** — сборка базового образа из `Dockerfile.base` и публикация в GitLab Registry с тегом `:deps`.

**build** — сборка финального образа из `Dockerfile` на основе базового (`:deps`) и публикация с тегом `:latest`.

**deploy** — деплой на сервер через `DOCKER_HOST` по SSH. Docker daemon подключается к удалённому серверу напрямую, выполняет `compose pull` → `compose down` → `compose up`. SSH-ключ передаётся через `ssh-agent`.

Переменные в GitLab CI/CD Settings:
- `SSH_PRIVATE_KEY` — приватный SSH-ключ для подключения к серверу
- `SERVER_USER` — пользователь на сервере
- `SERVER_HOST` — IP-адрес сервера

## GitHub Actions

Пайплайн состоит из трёх стадий:

**build-base** — сборка базового образа из `Dockerfile.base` и публикация в GitHub Container Registry с тегом `:deps`.

**build** — сборка финального образа из `Dockerfile` на основе базового (`:deps`) и публикация с тегом `:latest`.

**deploy** — заглушка (`echo "Деплой выполнен"`), так как сервер находится в локальной сети и недоступен снаружи.

Секреты в GitHub Actions Secrets:
- `SSH_PRIVATE_KEY`
- `SERVER_USER`
- `SERVER_HOST`
- `ENV_FILE`

## Репозитории

- GitLab: https://gitlab.com/dm_webpractik/cicdskill
- GitHub: https://github.com/DeemMoor/easy-ci-cd