#!/bin/sh
# Attempts to shutdown our app containers.

# Determine APP path
SCRIPT_PATH=$(dirname $0)
cd ${SCRIPT_PATH}/..
APP_PATH=$(pwd)

${APP_PATH}/bin/docker-compose down