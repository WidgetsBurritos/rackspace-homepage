#!/bin/sh
# Replaces the original import.sql with an updated version based on the current state of the database.  Must be run from root of docker app. 

read -p "This will force all rebuilds to revert to the current state. Are you sure?  [y|N] " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

docker exec -i -t rackspacehomepage_db_1 sh -c 'mysqldump -u root -pmysql drupal 2> /dev/null' > import-sql/import.sql
