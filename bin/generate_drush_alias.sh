#!/bin/sh
# Generates a drush alias file for use with the Drupal app and database containers.

export DOCKER_HOSTNAME=$(docker-machine ip)
export DB_HOST=${DOCKER_HOSTNAME}
export DB_USER='root'
export DB_PASS='mysql'
export DB_PORT=3307
export DB_NAME='drupal'
export SSH_USER=root
export SSH_KEY="$(pwd)/certs/id_rsa"
export SSH_PORT=2222
export FILE_PATH='/var/www/html/sites/default/files'


sed \
  -e "s|##DOCKER_HOSTNAME##|${DOCKER_HOSTNAME}|g" \
  -e "s|##DB_HOST##|${DB_HOST}|g" \
  -e "s|##DB_USER##|${DB_USER}|g" \
  -e "s|##DB_PASS##|${DB_PASS}|g" \
  -e "s|##DB_PORT##|${DB_PORT}|g" \
  -e "s|##DB_NAME##|${DB_NAME}|g" \
  -e "s|##SSH_USER##|${SSH_USER}|g" \
  -e "s|##SSH_KEY##|${SSH_KEY}|g" \
  -e "s|##SSH_PORT##|${SSH_PORT}|g" \
  -e "s|##FILE_PATH##|${FILE_PATH}|g" \
  ./drush/rackdock.aliases.drushrc.php \
  > ~/.drush/rackdock.aliases.drushrc.php

drush cc drush

