#!/bin/sh
#
# Attempts to shutdown our app containers.

# Determine APP path (parent to script path)
SCRIPT_PATH=$(dirname $0)
cd "$SCRIPT_PATH/.."
APP_PATH=$(pwd)
cd $APP_PATH

# Bring down our containers
$APP_PATH/bin/docker-compose down