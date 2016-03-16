#!/bin/sh
#
# Attempts to shutdown, rebuild and reactivate the docker containers. (Useful for starting from scratch)

# Make sure the user actually wants to revert the site to the previously exported stated.
read -p "This will destroy all containers and the machine for the rackspace-homepage application. You will lose any unsaved changes, and have to rerun scripts/setup.sh to start over. Are you sure? [y|N] " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

# Determine APP path (parent to script path)
SCRIPT_PATH=$(dirname $0)
cd "$SCRIPT_PATH/.."
APP_PATH=$(pwd)

# Set Machine Info
DOCKER_MACHINE=$APP_PATH/bin/docker-machine
MACHINE_NAME="rackspace-homepage"

# stop any running containers
$APP_PATH/scripts/stop.sh

# reset our environment variables.
eval $($APP_PATH/bin/docker-machine env $MACHINE_NAME)

# destroy all the old containers
$APP_PATH/bin/docker ps -a | grep rackspacehomepage | awk '{print $1}' | xargs $APP_PATH/bin/docker rm

# destroy the machine
$APP_PATH/bin/docker-machine rm --force $MACHINE_NAME

