.PHONY: *

help:
	@printf "\033[33mComo usar:\033[0m\n  make [comando] [arg=\"valor\"...]\n\n\033[33mComandos:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-30s\033[0m %s\n", $$1, $$2}'

up: ## Subindo todos os containers do sistema
	docker-compose -f docker-compose.yaml stop
	docker-compose -f docker-compose.yaml up -d

fresh: ## Reiniciando toda a base de dados do sistema
	docker-compose -f docker-compose.yaml exec app php artisan migrate:fresh --seed

migrate: ## Migrando as migrações novas
	docker-compose -f docker-compose.yaml exec app php artisan migrate

build: ## Migrando as migrações novas
	docker-compose -f docker-compose.yaml build

tinker: ## Usando tinker
	docker-compose -f docker-compose.yaml exec app php artisan tinker

bash: ## Entrando dentro do container
	docker-compose -f docker-compose.yaml exec app bash

cron: ## Entrando dentro do container
	docker-compose -f docker-compose.yaml exec cron bash

chmod: ## Entrando dentro do container
	docker-compose -f docker-compose.yaml exec app chmod 777 -R storage
	docker-compose -f docker-compose.yaml exec app chmod 777 -R bootstrap

test: ## Migrando as migrações novas
	docker-compose -f docker-compose.yaml exec php artisan test

unit: ## Migrando as migrações novas
	docker-compose -f docker-compose.yaml exec php vendor/bin/phpunit
