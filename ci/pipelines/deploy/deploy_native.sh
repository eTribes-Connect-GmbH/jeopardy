#!/usr/bin/env bash

set -e

SCRIPT_PATH="$(realpath "$(dirname "${0}")")"
PROJECT_ROOT="$(realpath "${SCRIPT_PATH}/../../..")"
TAG="${CI_COMMIT_REF_NAME}"
NAME="${CI_PROJECT_NAME}-shopware"
TARBALL_NAME="${NAME}_${TAG}.tar.bz2"
BUILD_DIR_NAME="${CI_PROJECT_NAME}-build"

if [[ -z "${ENV}" ]] || [[ -z "${SSH_SERVER}" ]]; then
  echo "Missing ENV or SSH_SERVER argument!"

  exit 1
fi

(
  cd "${PROJECT_ROOT}"

  echo "Create build directory"
  mkdir "${BUILD_DIR_NAME}" -p

  echo "Create env file"
  cat docker/.base.env "./.${ENV}.env" >"${BUILD_DIR_NAME}/.env"
  cp "./.${ENV}.htpasswd" "${BUILD_DIR_NAME}/.htpasswd"

  echo "Adding ci/pipelines/deploy/run_native.sh"
  cp ci/pipelines/deploy/run_native.sh "${BUILD_DIR_NAME}"

  echo "Adding build/${TARBALL_NAME}"
  cp "build/${TARBALL_NAME}" "${BUILD_DIR_NAME}"

  echo "Syncing build directory"
  rsync -xzzr "${BUILD_DIR_NAME}" "${SSH_SERVER}:/tmp"
)

echo "Running remote commands"
# shellcheck disable=SC2029 # The "${CI_PROJECT_NAME}" is intended to just pass its value
ssh "${SSH_SERVER}" bash "/tmp/${BUILD_DIR_NAME}/run_native.sh" "${ENV}" "${TARBALL_NAME}" "${CI_PROJECT_NAME}"
