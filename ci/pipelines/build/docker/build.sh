#!/usr/bin/env bash

set -e

SCRIPT_PATH="$(realpath "$(dirname "${0}")")"
PROJECT_ROOT="$(realpath "${SCRIPT_PATH}/../../../..")"
TAG="${CI_COMMIT_REF_NAME}"
REGISTRY="${CI_DOCKER_REGISTRY_URL}"
NAME="${CI_PROJECT_NAME}-shopware"

echo "${CI_DOCKER_REGISTRY_PASSWORD}" | docker login "${REGISTRY}" --username="${CI_DOCKER_REGISTRY_USER}" --password-stdin
docker build -f ci/pipelines/build/docker/Dockerfile "${PROJECT_ROOT}" -t "${REGISTRY}/${NAME}:${TAG}"
docker push "${REGISTRY}/${NAME}:${TAG}"
docker logout "${REGISTRY}"
