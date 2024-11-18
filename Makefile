.PHONY: all init up down build copy-env composer-install composer-validate composer-audit cache-clear fixer-check fixer-fix help

# Запуск проекта и установка зависимостей
init: build

# Запуск контейнеров
up:
	docker compose -f docker/docker-compose.yml up -d --force-recreate --remove-orphans

# Остановка контейнеров
down:
	docker compose -f docker/docker-compose.yml down --remove-orphans

# Сборка контейнеров
build:
	docker compose -f docker/docker-compose.yml build
	make composer-install
	make up

# Установка пакетов Composer
composer-install:
	docker compose -f docker/docker-compose.yml run --rm backend composer install --no-scripts --prefer-dist

# Очистка кеша приложения
cache-clear:
	docker compose -f docker/docker-compose.yml run --rm backend php artisan cache:clear

## Проверка стиля написания кода
#fixer-check:
#	docker compose -f docker/docker-compose.yml run --rm backend ./vendor/bin/pint --test --config=pint.json
#
## Исправление стиля написания кода
#fixer-fix:
#	docker compose -f docker/docker-compose.yml run --rm backend ./vendor/bin/pint -v --config=pint.json

# Справка по командам
help:
	@grep -E '^[a-zA-Z0-9_-]+:.*#' Makefile | sort | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done
