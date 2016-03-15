#!/bin/sh
# Attempts to shutdown, rebuild and reactivate the docker containers. (Useful for starting from scratch)

read -p "This will revert the current drupal site to the previously exported state. Are you sure? [y|N] " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

docker-compose down
docker-compose build
docker-compose up -d
