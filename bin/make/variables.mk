DOCKER_COMPOSE:=USER_ID=${shell id -u} docker compose
dbStringConnection := -uroot --password='root'
DOCKER_FRONT_EXEC=$(DOCKER_COMPOSE) exec frontend
DOCKER_BACK_EXEC=$(DOCKER_COMPOSE) exec backend

