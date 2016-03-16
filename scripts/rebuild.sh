#!/bin/sh
#
# Attempts to shutdown, rebuild and reactivate the docker containers. (Useful for starting from scratch)

# Make sure the user actually wants to revert the site to the previously exported stated.
read -p "This will revert the current drupal site to the previously exported state. Are you sure? [y|N] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    exit 1
fi

# Determine APP path (parent to script path)
SCRIPT_PATH=$(dirname $0)
cd "$SCRIPT_PATH/.."
APP_PATH=$(pwd)
cd $APP_PATH

# Set Machine Info
DOCKER_MACHINE=$APP_PATH/bin/docker-machine
DOCKER_COMPOSE=$APP_PATH/bin/docker-compose
MACHINE_NAME=rackspace-homepage
eval $(DOCKER_MACHINE env $MACHINE_NAME)

# Shut down any running containers, rebuild everything, and restart containers.
$DOCKER_COMPOSE down
$DOCKER_COMPOSE build
$DOCKER_COMPOSE up -d
