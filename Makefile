env ?= dev

ifeq ($(env),prod)
	CONFIG = docker-compose-prod.yml
else
	CONFIG = docker-compose.yml
endif

DOCKER_COMPOSE = docker-compose -p$(USER) -f$(CONFIG)

#####
# Executed when you run "make" cmd
# Simply run "start" tasks
all: start

#####
# Start containers (Also builds images, if there not exists)
start:
	$(DOCKER_COMPOSE) up -d

#####
# Stop containers (And also remove it)
stop:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) stop
	$(DOCKER_COMPOSE) rm --force

#####
# List current running containers
list:
	$(DOCKER_COMPOSE) ps

#####
# Execute "start" tasks and run provisioning scripts
init: start
	$(DOCKER_COMPOSE) run symfony /bin/sh -ec '/entrypoint.sh'

#####
# Start new bash terminal inside the Symfony Container
ssh:
	$(DOCKER_COMPOSE) run symfony bash

#####
# Display current running containers logs (Press "Ctrl + c" to exit)
logs:
	$(DOCKER_COMPOSE) logs -f

#####
# Execute "make" cmd & give environment variable "env" = prod
# This will results to start containers using configs & services described in "docker-compose-prod.yml" file
prod:
	make -e env=prod

#####
# Used to "reset" project for testing provisioning from scratch
clean:
	npm run gulp gitClean
