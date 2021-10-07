.PHONY: fresh stop

fresh: build up db-setup
	open https://turbo.docker.so/rooms

build:
	composer install
	yarn

up:
	docker compose up -d

db-setup:
	docker compose exec php bin/console doctrine:schema:update --force

watch:
	yarn encore dev --watch

stop:
	docker compose stop

down:
	docker compose down -v
	rm -rf node_modules var vendor
