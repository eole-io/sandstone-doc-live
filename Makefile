all: install run

install:
	docker-compose up --no-deps -d php-fpm

	docker exec -ti sandstone-doc-live-php sh -c "composer install"

update:
	docker-compose up --build --force-recreate --no-deps -d php-fpm

	docker exec -ti sandstone-doc-live-php sh -c "composer update"

	docker-compose up --build --force-recreate -d

run:
	docker-compose up -d

logs:
	docker-compose logs -ft

optimize_autoloader:
	docker exec -ti sandstone-doc-live-php sh -c "composer install --optimize-autoloader"

bash:
	docker-compose up --no-deps -d php-fpm
	docker exec -ti sandstone-doc-live-php bash

restart_websocket_server:
	docker restart chat-sandstone-doc-live-ws
