#!/bin/sh
# Attempts to open the application in the system-default browser.

# Determine APP path
SCRIPT_PATH=$(dirname $0)
cd ${SCRIPT_PATH}/..
APP_PATH=$(pwd)
DOCKER_MACHINE=${APP_PATH}/bin/docker-machine

# Set our machine name
MACHINE_NAME="rackspace-homepage"

# Load site in system-default browser.
open http://$(${DOCKER_MACHINE} ip ${MACHINE_NAME}):8910

