CURRENT_DIR:=$(dir $(abspath $(lastword $(MAKEFILE_LIST))))
#DOCKER=$(shell which docker)
#DOCKER_COMPOSE=USER_ID=${shell id -u} ${DOCKER} compose
DOCKER_COMPOSE:=USER_ID=${shell id -u} docker compose
dbStringConnection := -uroot --password='root'
DOCKER_FRONT_EXEC=$(DOCKER_COMPOSE) exec frontend
DOCKER_BACK_EXEC=$(DOCKER_COMPOSE) exec backend

.PHONY: default
default: info

.PHONY: info
info:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?##/ { printf "  \033[36m%-27s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

## -------------------
## -- Basic Actions --
## -------------------
start:COMMAND=up -d ##    Start containers
stop:COMMAND=down ##    Stop containers
restart: stop start ##     Restart containers
build-images:COMMAND=build
rebuild-images:COMMAND=build --no-cache
build-all: stop build-images ##  Builds all images using cache if available
rebuild-all: stop rebuild-images ##  Rebuilds all images from scratch (without cache)

doco stop start status build-images rebuild-images shell-front shell-back shell-back-root:
	$(DOCKER_COMPOSE) $(COMMAND)

## ----------------------
## -- Image Management --
## ----------------------
IMAGE=$(image)
.PHONY: rebuild-image
rebuild-image: ##  Rebuilds single image: backend, frontend or database
	@echo "Rebuilding $(IMAGE)"
	@$(DOCKER_COMPOSE) build --no-cache $(IMAGE)
	@$(DOCKER_COMPOSE) up --build --force-recreate --no-deps -d $(IMAGE)

## ------------------
## -- Shell access --
## ------------------
shell-back:COMMAND=exec backend /bin/zsh ##  Access to backend shell
shell-back-root:COMMAND=exec -u 0 backend /bin/zsh
shell-front:COMMAND=exec frontend /bin/zsh ##  Access to frontend shell
shell-front:COMMAND=exec -u 0 frontend /bin/zsh

## ------------------------
## -- Package management --
## ------------------------
deps: deps-front deps-back ##  Install frontend and backend dependencies
deps-front: ##  Install frontend dependencies
	@echo "Installing frontend dependencies..."
	@echo "---------------------------------"
	@$(DOCKER_FRONT_EXEC) npm install

deps-back: ##  Install backend dependencies
	@echo "Installing backend dependencies..."
	@echo "----------------------------------------"
	@$(DOCKER_BACK_EXEC) composer install

#------------------------
## -- Symfony commands --
## ----------------------
cache-clear: ##  Clears symfony cache
	@$(DOCKER_BACK_EXEC) symfony console cache:clear

messenger-start: ##  Starts messenger with previous messenger_messages table cleaning
	@docker exec -i database bash -l -c "mysql ${dbStringConnection}" < .docker/mysql/clear-messenger-tables.sql
	@$(DOCKER_COMPOSE) exec backend symfony console messenger:consume async -vv

## ------------------
## -- Code quality --
## ------------------
lint-back:
	@$(DOCKER_BACK_EXEC) composer run lint
fix-back:
	@$(DOCKER_BACK_EXEC) composer run fix
psalm:
	@$(DOCKER_BACK_EXEC) composer run psalm
phpstan:
	@$(DOCKER_BACK_EXEC) composer run phpstan
cq-back:lint-back psalm phpstan

lint-front:
	@$(DOCKER_FRONT_EXEC) npm run lint:script
fix-front:
	@$(DOCKER_FRONT_EXEC) npm run lint:script

## -------------
## -- Testing --
## -------------
tests-back-coverage:
	@$(DOCKER_BACK_EXEC) composer run tests -- --coverage-html=coverage
tests-back:
	@$(DOCKER_BACK_EXEC) composer run tests
tests-back-unit:
	@$(DOCKER_BACK_EXEC) composer run tests-unit
tests-back-acceptance:
	@$(DOCKER_BACK_EXEC) composer run tests-acceptance
tests-back-integration:
	@$(DOCKER_BACK_EXEC) symfony console doctrine:schema:drop --force --env=test
	@$(DOCKER_BACK_EXEC) symfony console doctrine:schema:create --env=test
	@$(DOCKER_BACK_EXEC) composer run tests-integration
tests-front:
	@$(DOCKER_FRONT_EXEC) npm run test:unit
tests: tests-front tests-back

## --------------------------------------
## -- Images management and monitoring --
## --------------------------------------
.PHONY: status
status:DOCKER_COMMAND=ps ##    Show containers status

.PHONY: stats
stats: ## - Check docker memory/cpu stats
	@docker stats

## -------------------------
## -- Database management --
## -------------------------
shell-db: ##  Access to database shell
	@$(DOCKER_COMPOSE) exec database mysql ${dbStringConnection}
db-restore: ##  Recreates database and import data from defined location
	@echo "Clearing database..."
	@docker exec -i database bash -l -c "mysql -uroot --password='root'" < .docker/mysql/clean-db.sql
	@echo "Importing new data..."
	@docker exec -i database bash -l -c "mysql ${dbStringConnection}" < .docker/mysql/bd-dump.sql
	@echo "DONE!!!!"

testdb-recreate: ##  Drops tests schema database and restores it
	@$(DOCKER_BACK_EXEC) symfony console doctrine:schema:drop --force --env=test
	@$(DOCKER_BACK_EXEC) symfony console doctrine:schema:create --env=test

testdb-status:TARGET=migrations:status --env=test
testdb-migrate:TARGET=migrations:migrate --no-interaction --env=test
testdb-dump:TARGET=schema:update --dump-sql --env=test
testdb-diff:TARGET=migrations:diff --env=test
doctrine-status:TARGET=migrations:status ##  Checks database sync with doctrine definitions
doctrine-migrate:TARGET=migrations:migrate --no-interaction ##  Executes migration from doctrine
doctrine-dump:TARGET=schema:update --dump-sql ##  Shows difference between database and doctrine migrations
doctrine-diff:TARGET=migrations:diff ##  Creates migration with difference between database and doctrine
doctrine-common testdb-status doctrine-status testdb-migrate doctrine-migrate testdb-dump doctrine-dump testdb-diff doctrine-diff:
	@$(DOCKER_COMPOSE) exec backend symfony console doctrine:$(TARGET)
