# Rackspace Homepage Project

A project to emulate the homepage of rackspace.com on a locally hosted environment using Docker containers.
This project assumes you are running on Mac OS X. If you are running on any other environment, you may need
to adjust your process accordingly.

### Step 1.) Cloning This Repository to Your System

From a terminal window, navigate to a directory you wish to install this app into and run the following command:

`git clone https://github.com/WidgetsBurritos/rackspace-homepage.git`

### Step 2.) Using setup.sh to Get the Application Up and Running

*setup.sh* does all the hard work:

  - Checks software prerequisites
  - Attempts to download VirtualBox/drush if missing
  - Downloads Drupal 7
  - Creates a unique Docker machine
  - Sets docker environment variables
  - Starts the application containers
  - Generates custom SSH keys for use with the ssh container & drush
  - Generates Drush aliases for use with the application.

From the previous step just type in the following commands.

```
cd rackspace-homepage
./scripts/setup.sh
```

If drush or virtualbox are missing from your system, you will be prompted to install them:

> Would you like to install Drush? [y|N]

> Would you like to install VirtualBox 5.0.16? (NOTE: This will require sudo privileges). [y|N]

When asked for `root@192.168.99.100's password:` enter `toor`.


### Step 3.) Opening the site in your browser.

The application can be accessed by going to `http://DOCKER_IP_ADDRESS:8910` in your browser, where `DOCKER_IP_ADDRESS` is the value of your Docker machine's IP address.

If you don't know what the IP address you can just run the following command to load the site in your system's default browser:

`./scripts/load-site.sh`

---
## Other Items of Importance

#### Locations of Drupal Modules, Themes, Libraries, Files and settings.php

Our Docker application has completely isolated the modules, themes, libraries, files and settings.php from the rest of the Drupal 7 code base, from the host machine's perspective.

- Modules are located in the `./modules/` directory.
- Themes are located in the `./themes/` directory.
- Libraries are located in the `./libraries/` directory.
- Files are located in the `./files/` directory.
- The default settings.php file is located at `./settings.php`

#### Running Drush Commands

You can run any drush command on your container by doing the following:

`drush @rackdock.dev your-drush-command-here`

So for example, if you wish to clear all of your cache bins, you can do so with:

`drush @rackdock.dev cc all`

#### Stopping, Starting and Restarting the Containers

To start the app's Docker containers:

`./scripts/start.sh`

To stop the app's Docker containers:

`./scripts/stop.sh`

To restart the app's Docker containers:

`./scripts/restart.sh`

#### Updating the Latest SQL Dump ####

To update the SQL import file located at import-sql/import.sql, run:

`./scripts/update_sql_import.sh`

#### Reverting a Site To The Latest SQL Dump ####

To revert a site to the latest SQL import file located at import-sql/import.sql, run:

`./scripts/rebuild.sh`

#### Destroying the Evidence

To remove the project and it's respective containers from your system run the following commands:
```
cd /path/to/rackspace-homepage
./script/destroy.sh
cd ../
rm -Rf /path/to/rackspace-homepage
```
