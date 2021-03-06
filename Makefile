env ?= dev

ifeq ($(env),prod)
	CONFIG = docker-compose-prod.yml
else
	CONFIG = docker-compose.yml
endif

DOCKER_COMPOSE = docker-compose -p$(USER) -f$(CONFIG)

#####
# Executed when you run "make" cmd
# Simply run "start" tasks
all: start

#####
# Start containers (Also builds images, if there not exists)
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
# Run the PhpMetrics analysis and output "report.html"
metrics:
	$(DOCKER_COMPOSE) run symfony phpmetrics --report-html=report.html /home/docker/src

#####
# Run the PhpMetrics analysis and output "report.html"
documentation:
	$(DOCKER_COMPOSE) run symfony phpDocumentor -d src/ -t doc/

#####
# Run the entire Unitary & Functional PhpUnit tests
tests:
	$(DOCKER_COMPOSE) run symfony bin/phpunit -c app/phpunit.xml

#####
# Display current running containers logs (Press "Ctrl + c" to exit)
logs:
	$(DOCKER_COMPOSE) logs -f

#####
# Execute "make" cmd & give environment variable "env" = prod
# This will results to start containers using configs & services described in "docker-compose-prod.yml" file
prod:
	make -e env=prod

#####
# Delete compiled Css & JavaScripts files from "Web/assets" folders
clean-assets:
	npm run gulp cleanCss cleanJs
	rm web/rev-manifest.json

#####
# Remove stopped container
clean-container:
	$(DOCKER_COMPOSE) rm --force

#####
# Used to "reset" project for testing provisioning from scratch (Remove files ignored by GIT)
raz: stop
	npm run gulp gitClean

#####
# Display available make commands
help:
	@echo 'Recipes List:'
	@echo ''
	@echo 'run make <recipes>'
	@echo ''
	@echo '+-----------------+--------------------------------------------------------------------+'
	@echo '| Recipes         | Utility                                                            |'
	@echo '+-----------------+--------------------------------------------------------------------+'
	@echo '| start           | Start containers (Also builds images, if there not exists)         |'
	@echo '| stop            | Stop containers (And also remove it)                               |'
	@echo '| list            | List current running containers                                    |'
	@echo '| init            | Execute "start" tasks and run provisioning scripts                 |'
	@echo '| ssh             | Start new bash terminal inside the Symfony Container               |'
	@echo '| metrics         | Run the PhpMetrics analysis (output report.html)                   |'
	@echo '| documentation   | Run the PhpDocumentor & generate documentation at doc/index.html   |'
	@echo '| tests           | Execute the entire Unitary & Functional PhpUnit tests suit         |'
	@echo '| logs            | Display current running containers logs (Press "Ctrl + c" to exit) |'
	@echo '| prod            | Execute "make" cmd & give environment variable "env" = prod        |'
	@echo '| clean-assets    | Delete compiled Css & JavaScripts files from "Web/assets" folders  |'
	@echo '| clean-container | Remove stopped useless containers                                  |'
	@echo '| raz             | Used to "reset" project for testing provisioning from scratch      |'
	@echo '+-----------------+--------------------------------------------------------------------+'
