#!/bin/sh
#
# Replaces the original import.sql with an updated version based on the current state of the database.

# Make sure the user actually wants to replace the import.sql file.
read -p "This will force all rebuilds to revert to the current state. Are you sure?  [y|N] " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

# Determine APP path (parent to script path)
SCRIPT_PATH=$(dirname $0)
cd "$SCRIPT_PATH/.."
APP_PATH=$(pwd)

# Export database
drush @rackdock.dev sql-dump > $APP_PATH/import-sql/import.sql
