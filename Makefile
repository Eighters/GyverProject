env ?= dev

ifeq ($(env),prod)
	CONFIG ?= docker-compose-prod.yml
else
	CONFIG ?= docker-compose.yml
endif

DOCKER_COMPOSE = docker-compose -p$(USER) -f$(CONFIG)

all: up

up: start

start:
	$(DOCKER_COMPOSE) up -d

init: start
	$(DOCKER_COMPOSE) run symfony /bin/sh -ec '/entrypoint.sh'

ssh: start
	$(DOCKER_COMPOSE) run symfony bash

logs: start
	$(DOCKER_COMPOSE) logs -f

list:
	$(DOCKER_COMPOSE) ps

prod:
	make -e env=prod

stop:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) stop
	$(DOCKER_COMPOSE) rm -f

clean:
	npm run gulp gitClean

mrpropre: stop clean
