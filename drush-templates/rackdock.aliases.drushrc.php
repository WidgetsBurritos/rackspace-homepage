<?php
/*
 * A template for a drush alias file to be stored in ~/.drush when the
 * bin/generate-drush-alias script is ran.
 */

$aliases['dev'] = array(
  'uri' => '##DOCKER_HOSTNAME##',
  'db-url' => 'mysql://##DB_USER##:##DB_PASS##@##DB_HOST##:##DB_PORT##/##DB_NAME##',
  'db-allows-remote' => TRUE,
  'remote-host' => '##DOCKER_HOSTNAME##',
  'remote-user' => '##SSH_USER##',
  'ssh-options' => '-i ##SSH_KEY## -p ##SSH_PORT## -o "AddressFamily inet"',
  'strict' => 0,
  'root' => '/var/www/html',
  'path-aliases' => array(
    '%files' => '##FILE_PATH##',
    '%drush-script' => 'drush',
  ),
);