#!/bin/sh
#
# Attempts to install our application and prerequisite software.

##################################################################
# Walks through each step of the installation process.
##################################################################
main() {
  initializeVariables
  initializePaths
  checkPrerequisites
  downloadDocker
  createDockerMachine
  setDockerEnvironment
  startDrupalApp
  generateSSHKeys
  generateDrushAlias
  displayInfoMessage
}

##################################################################
# Initializes variables that will be used by other functions.
##################################################################
initializeVariables() {
  # Determine APP path (parent to script path)
  SCRIPT_PATH=$(dirname $0)
  cd "$SCRIPT_PATH/.."
  APP_PATH=$(pwd)
  cd $APP_PATH

  # Drush Configuration settings
  DB_USER='root'
  DB_PASS='mysql'
  DB_PORT=3307
  DB_NAME='drupal'
  SSH_USER='root'
  SSH_PORT=2222
  SSH_KEY="$APP_PATH/certs/id_rsa"
  FILE_PATH="/var/www/html/sites/default/files"

  # Docker Settings
  DOCKER="$APP_PATH/bin/docker"
  DOCKER_TGZ="$APP_PATH/bin/docker.tgz"
  DOCKER_URL="https://get.docker.com/builds/Darwin/x86_64/docker-latest.tgz"
  DOCKER_COMPOSE="$APP_PATH/bin/docker-compose"
  DOCKER_COMPOSE_URL="https://github.com/WidgetsBurritos/docker-compose-old-mac/raw/master/bin/docker-compose-Darwin-x86_64"
  DOCKER_MACHINE="$APP_PATH/bin/docker-machine"
  DOCKER_MACHINE_URL="https://github.com/docker/machine/releases/download/v0.6.0/docker-machine-Darwin-x86_64"
  DOCKER_MACHINE_NAME="rackspace-homepage"

  # VirtualBox settings
  VIRTUAL_BOX_URL="http://download.virtualbox.org/virtualbox/5.0.16/VirtualBox-5.0.16-105871-OSX.dmg"
}

##################################################################
# Makes sure necessary system paths exists.
##################################################################
initializePaths() {
  mkdir -p $APP_PATH/bin
  mkdir -p $APP_PATH/certs
  mkdir -p $HOME/.drush
}

##################################################################
# Makes sure system prerequisites are met.
##################################################################
checkPrerequisites() {
  # Ensure git is installed
  GIT=$(command -v git)
  if [[ $GIT == "" ]]; then
    echo "Git is required. Aborting."
    exit 1
  fi

  # Ensure curl is installed (needed to install composer, virtualbox and docker)
  CURL=$(command -v curl)
  if [[ $CURL == "" ]]; then
    echo "Curl is required. Aborting."
    exit 1
  fi

  # Ensure php is installed (needed to install composer)
  PHP=$(command -v php)
  if [[ $PHP == "" ]]; then
    echo "PHP is required. Aborting."
    exit 1
  fi

  # Check if Drush is installed. If not, attempt to install it.
  DRUSH=$(command -v drush)
  if [[ $DRUSH == "" ]]; then
    echo "Drush is missing."
    installDrush
  fi

  # Check if VirtualBox is installed. If not, attempt to install it.
  VIRTUALBOX=$(command -v drush)
  if [[ $VIRTUALBOX == "" ]]; then
    echo "VirtualBox is missing."
    installVirtualBox
  fi
}

##################################################################
# Attempts to install Drush, per instructions here:
# https://www.drupal.org/node/1674222
##################################################################
installDrush() {
  read -p "Would you like to install Drush? (NOTE: This will require sudo privileges) [y|N] " -n 1 -r
  echo
  if [[ $REPLY =~ ^[Yy]$ ]]; then
    # Download composer
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar $APP_PATH/bin/composer
    chmod +x $APP_PATH/bin/composer

    # Ensure our drush code respository exists.
    SRC_PATH=/usr/local/src/rh-drush
    sudo mkdir -p $SRC_PATH
    sudo chown -R $(whoami) $SRC_PATH
    cd $SRC_PATH
    git clone https://github.com/drush-ops/drush.git
    cd $SRC_PATH/drush
    $APP_PATH/bin/composer install

    # Create a symbolic link
    sudo ln -s $SRC_PATH/drush/drush /usr/local/bin/drush
    cd $APP_PATH
  else
    echo "Exiting..."
    exit 1
  fi
}

##################################################################
# Attempts to install VirtualBox, per instructions here:
# https://www.virtualbox.org/manual/ch02.html#idp46457698147472
##################################################################
installVirtualBox() {
  read -p "Would you like to install VirtualBox 5.0.16? (NOTE: This will require sudo privileges). [y|N] " -n 1 -r
  echo
  if [[ $REPLY =~ ^[Yy]$ ]]; then
    # Create a temporary path for installing virtualbox
    TMP_PATH=$APP_PATH/.setup-virtualbox
    mkdir -p $TMP_PATH

    # Download and attach volume
    VOLUME_PATH=/Volumes/VirtualBox
    curl -L $VIRTUAL_BOX_URL > $TMP_PATH/VirtualBox.dmg
    hdiutil attach $TMP_PATH/VirtualBox.dmg
    sudo installer -pkg $VOLUME_PATH/VirtualBox.pkg -target /
    hdiutil unmount $VOLUME_PATH

    # Remove VirtualBox.dmg and tmp path.
    rm $TMP_PATH/VirtualBox.dmg
    rm -Rf $TMP_PATH
  else
    echo "Exiting..."
  fi
}

##################################################################
# Downloads the Docker binary files and set execute permissions.
##################################################################
downloadDocker() {
  if [[ ! -f $DOCKER ]]; then
    curl -L $DOCKER_URL > $DOCKER_TGZ
    pushd $APP_PATH/bin
    tar -xzf $DOCKER_TGZ
    mv docker docker_dir
    mv docker_dir/docker docker
    rm $DOCKER_TGZ
    chmod +x $DOCKER
    popd
  fi
  if [[ ! -f $DOCKER_COMPOSE ]]; then
    curl -L $DOCKER_COMPOSE_URL > $DOCKER_COMPOSE
    chmod +x $DOCKER_COMPOSE
  fi
  if [[ ! -f $DOCKER_MACHINE ]]; then
    curl -L $DOCKER_MACHINE_URL > $DOCKER_MACHINE
    chmod +x $DOCKER_MACHINE
  fi
}

##################################################################
# Creates a docker machine for our application
##################################################################
createDockerMachine() {
  $DOCKER_MACHINE create --driver virtualbox $DOCKER_MACHINE_NAME
}

##################################################################
# Allows the remainder of the script to execute with the appropriate docker environment variables.
##################################################################
setDockerEnvironment() {
  eval $($DOCKER_MACHINE env $DOCKER_MACHINE_NAME)
}

##################################################################
# Attempts to start our app
##################################################################
startDrupalApp() {
  cd $APP_PATH
  $DOCKER_COMPOSE up -d
}

##################################################################
# Generates SSH key and copies it onto the SSHD container, so we can use Drush.
##################################################################
generateSSHKeys() {
  ssh-keygen -f $APP_PATH/certs/id_rsa -t rsa -N ''
  cat $APP_PATH/certs/id_rsa.pub | ssh -p 2222 root@$($DOCKER_MACHINE ip $DOCKER_MACHINE_NAME) "mkdir -p ~/.ssh && cat > ~/.ssh/authorized_keys"
}

##################################################################
# Creates a drush alias file so we can access our containers.
##################################################################
generateDrushAlias() {
  DOCKER_HOSTNAME=$($DOCKER_MACHINE ip $DOCKER_MACHINE_NAME)
  DB_HOST=$DOCKER_HOSTNAME

  # Replace variables and store into drush alias folder.
  sed \
    -e "s|##DOCKER_HOSTNAME##|$DOCKER_HOSTNAME|g" \
    -e "s|##DB_HOST##|$DB_HOST|g" \
    -e "s|##DB_USER##|$DB_USER|g" \
    -e "s|##DB_PASS##|$DB_PASS|g" \
    -e "s|##DB_PORT##|$DB_PORT|g" \
    -e "s|##DB_NAME##|$DB_NAME|g" \
    -e "s|##SSH_USER##|$SSH_USER|g" \
    -e "s|##SSH_KEY##|$SSH_KEY|g" \
    -e "s|##SSH_PORT##|$SSH_PORT|g" \
    -e "s|##FILE_PATH##|$FILE_PATH|g" \
    $APP_PATH/drush-templates/rackdock.aliases.drushrc.php \
    > $HOME/.drush/rackdock.aliases.drushrc.php

  drush cc drush
}

##################################################################
# Shows basic info on how to launch the app.
##################################################################
displayInfoMessage() {
  echo
  echo "********************************************"
  echo "Rackspace Homepage app installation complete"
  echo "Run ./scripts/load-site.sh to launch the app"
  echo "********************************************"
  echo
}

# Run it all
main "$@"
