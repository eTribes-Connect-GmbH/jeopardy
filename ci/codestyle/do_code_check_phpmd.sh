#!/usr/bin/env bash

set -e

IGNORED_FILES='*/vendor/*'
SCRIPT_PATH="$(realpath "$(dirname "$0")")"

function add_ignore() {
    IGNORED_FILES="${IGNORED_FILES},${1}"
}

# Ignore assets from PHP check
add_ignore '*.css'
add_ignore '*.js'
add_ignore '*.twig'

PATH_TO_CHECK="${SCRIPT_PATH}/../../src/custom/plugins/UrbanElectrics"
PHPMD_PATH="$(which phpmd)"

echo "Checking $(realpath "${PATH_TO_CHECK}")"

(
    cd "${SCRIPT_PATH}" &&
        php -d memory_limit=512M "${PHPMD_PATH}" "${PATH_TO_CHECK}" text "phpmd/ruleset.xml" --exclude "${IGNORED_FILES}"
)
