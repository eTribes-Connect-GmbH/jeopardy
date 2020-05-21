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

PHPCS_ARGUMENTS=''
PATH_TO_CHECK="$(realpath "${SCRIPT_PATH}/../../src/custom/plugins/UrbanElectrics")"
PLUGIN=''

echo ""
echo "Checking ${PATH_TO_CHECK}"
echo ""

phpcs --standard="${SCRIPT_PATH}/phpcs/Symfony/ruleset.xml" -sp --report=full --ignore="${IGNORED_FILES}" ${PHPCS_ARGUMENTS} "${PATH_TO_CHECK}"
