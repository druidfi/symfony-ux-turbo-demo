.PHONY: fresh stop

fresh:
	composer install
	yarn
	docker-compose up -d
	docker-compose exec php bin/console doctrine:schema:update --force
	yarn encore dev --watch

watch:
	yarn encore dev --watch

stop:
	docker-compose stop

down:
	docker-compose down -v
	rm -rf node_modules var vendor
