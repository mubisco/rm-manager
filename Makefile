CURRENT_DIR:=$(dir $(abspath $(lastword $(MAKEFILE_LIST))))
DOCKER_COMPOSE=USER_ID=${shell id -u} GID=${shell id -g} docker-compose
dbStringConnection := -udb_user --password='db_pass' db_name

default: info
.PHONY: default
default: info

.PHONY: info
info:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?##/ { printf "  \033[36m%-27s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

start:DOCKER_COMMAND=up -d ##    Start containers
stop:DOCKER_COMMAND=down ##    Stop containers
status:DOCKER_COMMAND=ps ##    Show containers status
restart: stop start
build-images:DOCKER_COMMAND=build
rebuild-images:DOCKER_COMMAND=build --no-cache
build: stop build-images ##  Builds all images using cache if available
rebuild: stop rebuild-images ##  Rebuilds all images from scratch (without cache)

rebuild-front:TARGET=frontend
rebuild-back:TARGET=backend
rebuild-db:TARGET=database ##  Rebuilds database image
rebuild-common rebuild-db rebuild-back rebuild-front:
	@$(DOCKER_COMPOSE) build --no-cache $(TARGET)
	@$(DOCKER_COMPOSE) up --build --force-recreate --no-deps -d $(TARGET)


doco stop start status build-images rebuild-images:
	@$(DOCKER_COMPOSE) $(DOCKER_COMMAND)

deps-install: npm-install composer-install ##  Install frontend and backend dependencies
npm-install: ##  Install frontend dependencies
	@echo "Installing frontend dependencies..."
	@echo "---------------------------------"
	@$(DOCKER_COMPOSE) exec frontend npm install

composer-install: ##  Install backend dependencies
	@echo "Installing backend dependencies..."
	@echo "----------------------------------------"
	@$(DOCKER_COMPOSE) exec backend composer install

cache-clear: ##  Clears symfony cache
	@$(DOCKER_COMPOSE) exec backend symfony console cache:clear

doctrine-status:TARGET=migrations:status ##  Checks database sync with doctrine definitions
doctrine-migrate:TARGET=migrations:migrate --no-interaction ##  Executes migration from doctrine
doctrine-dump:TARGET=schema:update --dump-sql ##  Shows difference between database and doctrine migrations
doctrine-diff:TARGET=migrations:diff ##  Creates migration with difference between database and doctrine
doctrine-common doctrine-status doctrine-migrate doctrine-dump doctrine-diff:
	@$(DOCKER_COMPOSE) exec backend symfony console doctrine:$(TARGET)

db-restore: ##  Recreates database and import data from defined location
	@echo "Clearing database..."
	@docker exec -i database bash -l -c "mysql -uroot --password='root'" < .docker/mysql/clean-db.sql
	@echo "Importing new data..."
	@docker exec -i database bash -l -c "mysql ${dbStringConnection}" < .docker/mysql/bd-dump.sql

shell-back: ##  Access to backend shell
	@$(DOCKER_COMPOSE) exec backend bash

shell-front: ##  Access to frontend shell
	@$(DOCKER_COMPOSE) exec frontend /bin/sh

shell-db: ##  Access to database shell
	@$(DOCKER_COMPOSE) exec database mysql ${dbStringConnection}

tests-back:
	@$(DOCKER_COMPOSE) exec backend composer run tests
tests-front:
	@$(DOCKER_COMPOSE) exec frontend npm run test:unit
lint-back:
	@$(DOCKER_COMPOSE) exec backend composer run lint
lint-front:
	@$(DOCKER_COMPOSE) exec frontend npm run lint:script
fix-back:
	@$(DOCKER_COMPOSE) exec backend composer run fix
fix-front:
	@$(DOCKER_COMPOSE) exec frontend npm run lint:script
psalm:
	@$(DOCKER_COMPOSE) exec backend composer run psalm
