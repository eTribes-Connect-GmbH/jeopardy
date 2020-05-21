#!/usr/bin/env bash

#
# Help:
#   Options:
#     -s               Skips the npm install
#

set -e

SCRIPT_PATH="$(realpath "$(dirname "$0")")"
ESLINT_ARGUMENTS='-c .eslintrc.js'
ESLINT_PATH='node_modules/eslint/bin/eslint.js'

function add_ignore_path() {
    ESLINT_ARGUMENTS="${ESLINT_ARGUMENTS} --ignore-pattern ${1}"
}

add_ignore_path '*.min.js'

while getopts 'sp:' OPTION_NAME; do
    case "${OPTION_NAME}" in
    "s")
        SKIP_NPM_INSTALL='s'
        ;;
    *)
        break
        ;;
    esac
done

if [[ "${SKIP_NPM_INSTALL}" != "s" ]]; then
    (
        cd "${SCRIPT_PATH}" &&
            npm install
    )
fi

(
    cd "${SCRIPT_PATH}" &&
        node "${ESLINT_PATH}" ${ESLINT_ARGUMENTS} ${SCRIPT_PATH}/../../src/custom/plugins/UrbanElectrics/**/*.js
)
