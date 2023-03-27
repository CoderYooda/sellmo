## Sellmo

* [Frontend](#frontend)

## Frontend

Мы используем отдельный контейнер с `nodejs` и `npm` как сервис `front-admin`.
При запуске этого контейнера происходит автоматическая установка всех зависимостей,
а затем сборка скриптов с использованием команды из переменных окружения `NPM_COMMAND`.
Доступные команды можно посмотреть в [package.json](./src/package.json) в секции `scripts`. Основными являются следующие:

1. `dev` - сборка в окружении разработчика.
1. `watch` - сборка в окружении разработчика с дальнейшим отслеживанием изменений файлов и пересборкой скриптов.
   Контейнер при этом остаётся в запущенном состоянии.
1. `build` - сборка в окружении прода, когда происходит минификация и оптимизация скриптов.

Для установки и управления зависимостями можно использовать следующие команды:

```shell
# установка всех зависимостей
docker-compose run --rm front-admin -c "npm ci"
# установка зависимости somepackage версии 1.0.0 с сохранением точной версии в package.json 
docker-compose run --rm front-admin -c "npm i --save-exact somepackage@1.0.0"
# установка dev-зависимости somepackage версии 1.0.0 с сохранением точной версии в package.json
docker-compose run --rm front-admin -c "npm i --save-dev --save-exact somepackage@1.0.0"
```

Чтобы запустить сборку в режиме разработки:

```shell
docker-compose run --rm front-admin -c "npm run watch"
```

Чтобы запустить сборку, нужно выполнить следующую команду:

```shell
docker-compose run --rm front-admin -c "npm run build"
```
