#!/bin/sh
#
# Attempts to bring up our app containers.

# Determine APP path (parent to script path)
SCRIPT_PATH=$(dirname $0)
cd "$SCRIPT_PATH/.."
APP_PATH=$(pwd)
cd $APP_PATH

# Restart our containers
$APP_PATH/bin/docker-compose restart
