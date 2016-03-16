#!/bin/sh
#
# Attempts to bring up our app containers.

# Determine APP path (parent to script path)
SCRIPT_PATH=$(dirname $0)
cd "$SCRIPT_PATH/.."
APP_PATH=$(pwd)
cd $APP_PATH

# Set Machine Info
DOCKER_MACHINE=$APP_PATH/bin/docker-machine
DOCKER_COMPOSE=$APP_PATH/bin/docker-compose
MACHINE_NAME=rackspace-homepage
eval $($DOCKER_MACHINE env $MACHINE_NAME)

# Activate our containers
$APP_PATH/bin/docker-compose up -d