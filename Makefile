# Docker commands.
start:
		docker-compose up -d

start-rebuild:
		docker-compose up -d --build

stop:
		docker-compose down

restart: stop
		make start

restart-rebuild: stop
		make start-rebuild

init: start
		docker-compose exec php composer install

clean:
		docker system prune -f

clean-hard:
		docker system prune -a --volumes -f
# End of - Docker commands.

# Backend commands.
enter-back:
		docker-compose exec php bash
# End of - Backend commands.
