.DEFAULT_GOAL := help
.PHONY: help

dc-file := docker/docker-compose.yml
env := docker/.env

dc := @docker-compose --file $(dc-file) --env-file $(env) --project-name calc
service_php = app
service_webserver = webserver
php = /usr/local/bin/php

setup-text:
	@echo Starting setup

setup: setup-text
setup: start
setup: php-setup
setup: ## Run this to setup everything up (should only run once)
	@echo Finished setup

start: ## Start containers
	$(dc) up -d

stop: ## Stop containers
	$(dc) stop

restart: stop
restart: start
restart: ## Restart all containers
	@echo Finished restart

start-no-d: ## Start containers not in detach mode
	$(dc) up

logs: ## Show container logs
	$(dc) logs -f -t

status: ## List containers
	$(dc) ps

rebuild: ## Rebuild containers
	$(dc) build --pull

php-bash: ## Open bash prompt to php docker container
	@$(dc) exec $(service_php) bash

#https://xdebug.org/docs/step_debug#activate_debugger
php-bash-xdebug: ## Open bash prompt to php docker container with xdebug on (XDEBUG_SESSION)
	@$(dc) exec -e XDEBUG_TRIGGER=1 $(service_php) bash

php-setup-start-msg:
	@echo Running php setup

php-setup: php-setup-start-msg
php-setup: php-composer-install
php-setup: ## Run php setup steps
	@echo Finished php setup

php-composer-install: ## Run composer install
	@echo Running composer install
	$(dc) exec $(service_php) composer install

php-clear-cache: ## Clear cache (symfony)
	$(call docker_php_exec, bin/console cache:clear)

php-remove-cache: ## Remove cache by using rm -rf (symfony)
	$(dc) exec $(service_php) rm -rf ./var/cache/*

php-run-tests: ## Run all tests
	@$(dc) exec $(service_php) php bin/phpunit || true

ws-start: ## Start webserver (not detached)
	$(dc) up $(service_webserver)

.SILENT: php-composer-install
help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-40s\033[0m %s\n", $$1, $$2}'
