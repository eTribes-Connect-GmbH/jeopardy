#!/usr/bin/env bash

set -e

SCRIPT_PATH="$(realpath "$(dirname "${0}")")"
PROJECT_ROOT="$(realpath "${SCRIPT_PATH}/../../..")"
TAG="${CI_COMMIT_REF_NAME}"
REGISTRY="${CI_DOCKER_REGISTRY_URL}"
NAME="${CI_PROJECT_NAME}-shopware"
IMAGE_NAME="${REGISTRY}/${NAME}:${TAG}"
BUILD_DIR_NAME="${CI_PROJECT_NAME}-build"

if [[ -z "${ENV}" ]] || [[ -z "${SSH_SERVER}" ]]; then
  echo "Missing ENV or SSH_SERVER argument!"

  exit 1
fi

echo "Logging into docker registry ${REGISTRY}"
echo "${CI_DOCKER_REGISTRY_PASSWORD}" | docker login "${REGISTRY}" --username="${CI_DOCKER_REGISTRY_USER}" --password-stdin

echo "Pulling image ${IMAGE_NAME}"
docker pull "${IMAGE_NAME}"

echo "Logging out of docker registry ${REGISTRY}"
docker logout "${REGISTRY}"

(
  echo "Continuing in ${PROJECT_ROOT}"
  cd "${PROJECT_ROOT}"

  echo "Create build directory"
  mkdir "${BUILD_DIR_NAME}" -p

  echo "Adding docker/.base.env"
  cp docker/.base.env "${BUILD_DIR_NAME}"

  echo "Adding .${ENV}.env"
  cp ".${ENV}.env" "${BUILD_DIR_NAME}"

  echo "Adding .${ENV}.htpasswd"
  cp ".${ENV}.htpasswd" "${BUILD_DIR_NAME}"

  echo "Adding ci/pipelines/deploy/run_container.sh"
  cp ci/pipelines/deploy/run_container.sh "${BUILD_DIR_NAME}"

  echo "Syncing ${BUILD_DIR_NAME} directory"
  rsync -xzzr "${BUILD_DIR_NAME}" "${SSH_SERVER}:/tmp"
)

echo "Running remote commands"
# shellcheck disable=SC2029 # The "${CI_PROJECT_NAME}" is intended to just pass its value
ssh "${SSH_SERVER}" bash "/tmp/${BUILD_DIR_NAME}/run_container.sh" "${ENV}" "${NAME}" "${IMAGE_NAME}" "${CI_PROJECT_NAME}"
