#!/usr/bin/env bash

 set -e

ENV="${1}"
TARBALL_NAME="${2}"
CI_PROJECT_NAME="${3}"
BUILD_DIR_NAME="${CI_PROJECT_NAME}-build"

# shellcheck disable=SC1090 # Shellcheck cannot follow this file because this file is dynamically generated.
source "/tmp/${BUILD_DIR_NAME}/.env"

# Update Symlink
(
  cd "${DEPLOYMENT_PATH}/builds" || exit 1

  # shellcheck disable=SC2035 # the echo command does not accept any options
  CURRENT_RELEASE="$(echo * | tr ' ' '\n' | sort -nr | head -n 1)"
  NEXT_RELEASE="$((CURRENT_RELEASE + 1))"
  mkdir -p "${NEXT_RELEASE}"

  cd "${NEXT_RELEASE}" || exit 1

  tar -xf "/tmp/${BUILD_DIR_NAME}/${TARBALL_NAME}" -C .
  ln -sf "${DEPLOYMENT_PATH}/shared/files" .
  rm -rf public/media public/thumbnail
  ln -sf "${DEPLOYMENT_PATH}/shared/media" public/
  ln -sf "${DEPLOYMENT_PATH}/shared/thumbnail" public/
  cp "/tmp/${BUILD_DIR_NAME}/.env" .
  if [[ -f "/tmp/${BUILD_DIR_NAME}/.htpasswd" ]]; then
    mv "/tmp/${BUILD_DIR_NAME}/.htpasswd" .htpasswd
  fi

  cd bin || exit 1
  ./console system:generate-jwt-secret
  ./build-administration.sh
  ./build-storefront.sh
  ./console theme:compile
  ./console cache:clear

  cd "${DEPLOYMENT_PATH}" || exit 1
  rm -rf current
  ln -sf "${PWD}/builds/${NEXT_RELEASE}" current
)

# Cleanup old builds
(
  cd "${DEPLOYMENT_PATH}/builds" || exit 1

  # shellcheck disable=SC2035 # the echo command does not accept any options
  OLD_RELEASES=$(echo * | tr ' ' '\n' | sort -n | head -n -3 | tr '\n' ' ')

  # shellcheck disable=SC2086 # Values of OLD_RELEASES should glob here
  rm -rf ${OLD_RELEASES};
)

rm -rf "/tmp/${BUILD_DIR_NAME}"



