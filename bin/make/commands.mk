test-back-coverage tests-back tests-back-unit tests-back-acceptance lint-back fix-back psalm phpstan:
	@$(DOCKER_BACK_EXEC) composer run $(COMPOSER_COMMAND)

stop start status build-images rebuild-images shell-front shell-back shell-back-root:
	$(DOCKER_COMPOSE) $(COMMAND)
