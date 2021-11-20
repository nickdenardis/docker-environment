NAME = host_php80_fpm

default: up

up:
	docker-compose up -d

down:
	docker-compose down

debug:
	docker exec -it $(NAME) /bin/bash
