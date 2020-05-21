#!/usr/bin/env bash

ENV="${1}"
CONTAINER_NAME="${2}"
IMAGE_NAME="${3}"
CI_PROJECT_NAME="${4}"
SHARED_DIRECTORY="/srv/docker/${CONTAINER_NAME}"
BUILD_DIR_NAME="${CI_PROJECT_NAME}-build"

alias echo='echo "[Remote] "'

# shellcheck source=docker/.base.env
source "/tmp/${BUILD_DIR_NAME}/.base.env"

# shellcheck source=./.test.env
source "/tmp/${BUILD_DIR_NAME}/.${ENV}.env"

echo "Using '${DOCKER_EXEC}' as docker command"

echo "Loading container image from /tmp/${BUILD_DIR_NAME}/shopware.tar"
$DOCKER_EXEC load --input "/tmp/${BUILD_DIR_NAME}/shopware.tar"

echo "Rename ${CONTAINER_NAME} to ${CONTAINER_NAME}-old"
$DOCKER_EXEC rename "${CONTAINER_NAME}" "${CONTAINER_NAME}-old" || true

echo "Starting new container ${CONTAINER_NAME}"
$DOCKER_EXEC run --rm -d \
    --name="${CONTAINER_NAME}" \
    --env-file="/tmp/${BUILD_DIR_NAME}/.base.env" \
    --env-file="/tmp/${BUILD_DIR_NAME}/.${ENV}.env" \
    --volume="${SHARED_DIRECTORY}/files:/sw6/files" \
    --volume="${SHARED_DIRECTORY}/media:/sw6/public/media" \
    "${IMAGE_NAME}"

printf "Adding container to networks: "
for NETWORK in $(echo "${DOCKER_ADDITIONAL_NETWORKS}" | tr ' ' '\n'); do
    printf "%s " "${NETWORK}"
    $DOCKER_EXEC network connect "${NETWORK}" "${CONTAINER_NAME}"
done

echo "done"

echo "Compiling themes"
$DOCKER_EXEC exec -w /sw6/bin "${CONTAINER_NAME}" ./build-administration.sh
$DOCKER_EXEC exec -w /sw6/bin "${CONTAINER_NAME}" ./build-storefront.sh
$DOCKER_EXEC exec -w /sw6/bin "${CONTAINER_NAME}" ./console theme:compile

echo "Clearing cache"
$DOCKER_EXEC exec -w /sw6/bin "${CONTAINER_NAME}" ./console cache:clear

if [[ -f "/tmp/${BUILD_DIR_NAME}/.${ENV}.htpasswd" ]]; then
    $DOCKER_EXEC cp "/tmp/${BUILD_DIR_NAME}/.${ENV}.htpasswd" "${CONTAINER_NAME}:/sw6/.htpasswd"
fi

echo "Stopping old container"
($DOCKER_EXEC stop "${CONTAINER_NAME}-old" && $DOCKER_EXEC rm "${CONTAINER_NAME}-old") || true

echo "Remove build directory"
rm -r "/tmp/${BUILD_DIR_NAME}"
