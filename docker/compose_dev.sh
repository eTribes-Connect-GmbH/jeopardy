#!/usr/bin/env bash

DOCKER_FILES="-f docker-compose.yml -f docker-compose.dev.yml"
export ENV=dev
source "../.${ENV}.env"
export COMPOSE_PROJECT_NAME

exec docker-compose ${DOCKER_FILES} ${@:1}
