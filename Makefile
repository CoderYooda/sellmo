###> variables ###
DC=docker-compose
###< variables ###

#Поднимает проект и перезаписывает env и yml файлы, если они ещё не были созданы
up: common-up down up-only front-build

#Поднимает проект и перезаписывает env и yml файлы, если они ещё не были созданы
up-build: common-up down rebuild up-only

#Поднимает проект
up-only:
	$(DC) up -d

#Билдит проект
build-only:
	$(DC) build

#Тушит проект
down:
	$(DC) down --remove-orphans || true

#запускает только сервис init, который выполняет миграции/установку пакетов и т.п.
app-init:
	$(DC) run init

#Общая часть подъема контейнеров, без перезаписи config файлов
common-up:
	cp -n .env.example .env || true
	cp -n laravel.env.example laravel.env || true

#чистка базы
db-refresh:
	$(DC) stop db
	$(DC) rm -f db
	docker volume rm sellmo_sellmo-db
	$(DC) exec -it redis redis-cli FLUSHALL
	$(DC) up -d db
	$(DC) up init

rebuild: down
	$(DC) docker image prune --all --force
	$(DC) buildrebuild: down

front-build:
	$(DC) run npm run build
