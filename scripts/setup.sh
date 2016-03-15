#!/bin/sh
# Attempts to install our application and prerequisite software.

# changeable constants
DRUPAL7_VERSION="drupal-7.43"
MACHINE_NAME="rackspace-homepage"
DB_USER='root'
DB_PASS='mysql'
DB_PORT=3307
DB_NAME='drupal'
SSH_USER=root
SSH_KEY="${APP_PATH}/certs/id_rsa"
SSH_PORT=2222
FILE_PATH='/var/www/html/sites/default/files'

# Determine APP path
SCRIPT_PATH=$(dirname $0)
cd ${SCRIPT_PATH}/..
APP_PATH=$(pwd)
DOCKER_MACHINE=${APP_PATH}/bin/docker-machine

main()
{ # Walks through each step of the installation process.
  checkPrerequisites
  downloadDrupal7
  createDockerMachine
  setDockerEnvironment
  startDrupalApp
  generateSSHKeys
  generateDrushAlias
}

checkPrerequisites()
{ # Makes sure git, php and curl installed on the local system
  GIT=$(command -v git)
  if [ "${GIT}" == "" ]; then
    echo "Git is required. Aborting."
    exit 1
  fi

  PHP=$(command -v php)
  if [ "${PHP}" == "" ]; then
    echo "PHP is required. Aborting."
    exit 1
  fi

  CURL=$(command -v php)
  if [ "${CURL}" == "" ]; then
    echo "Curl is required. Aborting."
    exit 1
  fi

  DRUSH=$(command -v drush)
  if [ "${DRUSH}" == "" ]; then
    echo "Drush is missing."
    installDrush
  fi

  VIRTUALBOX=$(command -v drush)
  if [ "${VIRTUALBOX}" == "" ]; then
    echo "VirtualBox is missing."
    installVirtualBox
  fi

}

installDrush()
{ # Attempts to install Drush (per instructions here: https://www.drupal.org/node/1674222)
  read -p "Would you like to install Drush? [y|N] " -n 1 -r
  echo
  if [[ $REPLY =~ ^[Yy]$ ]]; then
    SRC_PATH=/usr/local/src/
    mkdir -p ${SRC_PATH}
    cd ${SRC_PATH}
    git clone https://github.com/drush-ops/drush.git
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar ${APP_PATH}/bin/composer
    chmod +x ${APP_PATH}/bin/composer
    cd ${SRC_PATH}/drush
    ${APP_PATH}/bin/composer install
    ln -s ${SRC_PATH}/drush/drush /usr/local/bin/drush
    cd ${APP_PATH}
  else
    echo "Exiting..."
    exit 1
  fi
}

installVirtualBox()
{ # Attempts to install VirtualBox (per instructions here: https://www.virtualbox.org/manual/ch02.html#idp46457698147472)
  read -p "Would you like to install VirtualBox 5.0.16? (NOTE: This will require sudo privileges). [y|N] " -n 1 -r
  echo
  if [[ $REPLY =~ ^[Yy]$ ]]; then
    TMP_PATH=${APP_PATH}/.setup-virtualbox
    mkdir -p ${TMP_PATH}
    VOLUME_PATH=/Volumes/VirtualBox
    curl http://download.virtualbox.org/virtualbox/5.0.16/VirtualBox-5.0.16-105871-OSX.dmg > ${TMP_PATH}/VirtualBox.dmg
    hdiutil attach ${TMP_PATH}/VirtualBox.dmg
    sudo installer -pkg ${VOLUME_PATH}/VirtualBox.pkg -target /
    hdiutil unmount ${VOLUME_PATH}
    rm ${TMP_PATH}/VirtualBox.dmg
    rm -Rf ${TMP_PATH}
  else
    echo "Exiting..."
  fi
}


downloadDrupal7()
{ # Downloads Drupal 7 to the drupal7/ folder
  cd ${APP_PATH}
  if [ ! -d "${APP_PATH}/drupal7" ]; then
    # Download the drupal tarball, extract it and then remove the tarball.
    curl -O https://ftp.drupal.org/files/projects/${DRUPAL7_VERSION}.tar.gz
    tar xzf ${APP_PATH}/${DRUPAL7_VERSION}.tar.gz
    mv ${APP_PATH}/${DRUPAL7_VERSION} ${APP_PATH}/drupal7
    rm ${APP_PATH}/${DRUPAL7_VERSION}.tar.gz

    # Since we're rewriting our paths using Docker, remove the stock modules/themes/libraries/files directories to avoid confusion.
    rm -Rf ${APP_PATH}/drupal7/sites/all/modules 2> /dev/null
    rm -Rf ${APP_PATH}/drupal7/sites/all/themes 2> /dev/null
    rm -Rf ${APP_PATH}/drupal7/sites/all/libraries 2> /dev/null
    rm -Rf ${APP_PATH}/drupal7/sites/default/files 2> /dev/null
    rm -Rf ${APP_PATH}/drupal7/sites/default/settings.php 2> /dev/null
  fi
}

createDockerMachine()
{ # Creates a docker machine for our application
  ${DOCKER_MACHINE} create --driver virtualbox ${MACHINE_NAME}
}

setDockerEnvironment()
{ # Allows the remainder of the script to execute with the appropriate docker environment variables.
  eval $(${DOCKER_MACHINE} env ${MACHINE_NAME})
}

startDrupalApp()
{ # Attempts to start our app
  cd ${APP_PATH}
  ${APP_PATH}/bin/docker-compose up -d
}

generateSSHKeys()
{ # Generates SSH key and copies it onto the SSHD container, so we can use Drush.
  mkdir -p ${APP_PATH}/certs
  ssh-keygen -f ${APP_PATH}/certs/id_rsa -t rsa -N ''
  cat ${APP_PATH}/certs/id_rsa.pub | ssh -p 2222 root@$(${DOCKER_MACHINE} ip ${MACHINE_NAME}) "mkdir -p ~/.ssh && cat > ~/.ssh/authorized_keys"
}

generateDrushAlias()
{ # Creates a drush alias file so we can access our containers.
  DOCKER_HOSTNAME=$(${DOCKER_MACHINE} ip ${MACHINE_NAME})
  DB_HOST=${DOCKER_HOSTNAME}

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
    ${APP_PATH}/drush-templates/rackdock.aliases.drushrc.php \
    > $HOME/.drush/rackdock.aliases.drushrc.php

  drush cc drush
}

# Run it all
main "$@"