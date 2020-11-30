# Variables

stack_name = jpo

php_sources         ?= ./src
phpcs_ignored_files ?= vendor/*,var/cache/*

source_tag = latest

php_container_id = $(shell docker ps --filter name="$(stack_name)_php-fpm" -q)
user = $(shell id -u)

default: console


# Bash Commands

.PHONY: shell
shell:
	docker exec -it $(php_container_id) /bin/sh

.PHONY: command
command:
	docker exec -it $(php_container_id) $(cmd)


# UTILS

.PHONY: composer
composer:
	docker exec -it "$(php_container_id)" php -d memory_limit=-1 /usr/local/bin/composer $(cmd)

.PHONY: composer-update
composer-update:
	docker exec -it "$(php_container_id)" php -d memory_limit=-1 /usr/local/bin/composer update

.PHONY: composer-install
composer-install:
	docker exec -it "$(php_container_id)" php -d memory_limit=-1 /usr/local/bin/composer install --no-interaction


# SYMFONY

.PHONY: console
console:
	docker exec -it "$(php_container_id)" php bin/console $(cmd)


# IMAGES

.PHONY: build-image
build-image:
	docker build --build-arg source_tag=$(source_tag) --target=dev -t docker-registry.jpo.fr/php-fpm:$(source_tag) -f .docker/jpo/php-fpm/Dockerfile .

.PHONY: push-image
push-image:
	docker push docker-registry.jpo.fr/php-fpm:$(source_tag)