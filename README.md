# Rackspace Homepage Project

A project to emulate the homepage of rackspace.com on a locally hosted environment using Docker containers.
This project assumes you are running on Mac OS X. If you are running on any other environment, you may need
to adjust your process accordingly.

## Step 1.) Cloning this repository to your system

From a terminal window, navigate to a directory you wish to install this app into and run the following command:

`git clone https://github.com/WidgetsBurritos/rackspace-homepage.git`

## Step 2.) Install VirtualBox

VirtualBox is a prerequisite to getting this application to work. You can either download it through

The easiest way to get Docker running on your system is by installing Docker Toolbox, [available for download here](https://www.docker.com/products/docker-toolbox).

During install, select the "Docker Quickstart Terminal" option, which will create a default docker container, create SSH keys and VirtualBoxes.
This process may take up to 10 minutes to complete, depending on the machine.

If you closed the installation window before running that command, you can run it by going into your Applications folder, selected "Docker" and then opening "Docker Quickstart Terminal."

Upon successful installation, you should get a confirmation message with your machines IP address, which is also available at anytime by running:
`docker-machine ip`

If you don't get a valid IP address, there was a problem installing docker on your system. You may need to completely remove it from your system and try again. See [Install Docker Toolbox on Mac OS X](https://docs.docker.com/mac/step_one/) for more information if you continue to have issues on your system.

### Fixing Your Environment Variables

**IMPORTANT:** Whenever you try to access docker outside of the *Docker Quickstart Terminal*, you have to set your shell to use the appropriate Docker environment variables.
You can set your shell to use the appropriate environmental variables by running:

`eval $(docker-machine env default)`

If you forget to do so, you may see the following error, when running the `docker` command:

> docker: Cannot connect to the Docker daemon. Is the docker daemon running on this host?.

Or you may see the following error when running the `docker-compose` command:

> ERROR: Couldn't connect to Docker daemon - you might need to run `docker-machine start default`.

You can also add the above command to your `~/.bash_profile`, `~/.profile`, or `~/.bashrc` files so you don't have to do this every time you open a new terminal.

## Step 3.) Setting up the Docker Containers

To get the containers up and running, run the following in your terminal with the properly set environment variables ([see above](#fixing-your-environment-variables)):
```
cd /path/to/rackspace-homepage
chmod +x ./bin/build.sh
./bin/build.sh
```

`./bin/build.sh` can be used anytime you wish to revert to the original database that came with the project. It must be ran in the application root directory.

**IMPORTANT:** you will lose any unsaved database changes, so be careful when running it.

### Turning the containers off and on again.

The build script aboves stops and running containers, rebuilds them, and then starts them again.

If you're only looking to stop/start the containers without rebuilding (and losing DB changes you made), you may use the following commands:

**Turning off the containers:**
`docker-compose down`

**Turning on the containers:**
`docker-compose up -d`

(Note the -d flag, which forces the containers to run as a background daemon instead of in the foreground)

**Restarting containers:**
`docker-compose restart`


## Step 4.) Opening the Site In Your Browser

The application can be accessed by going to `http://DOCKER_IP_ADDRESS:8910` in your browser, where `DOCKER_IP_ADDRESS` is the value of your Docker machine's IP address.

If you don't know what the IP address is you can just run the following command to load the site in your system's default browser:

`./bin/load-site.sh`


---
## Other

### Using SSH & Drush on Your Docker-based Drupal App.

#### Setting up SSH keys & drush alias.

The first time you wish to use drush, you will need to generate a SSH key. You can do so with the following command:

`./bin/generate_ssh_keys.sh`

When prompted to enter the password for *root*, enter: `toor`.

This should generate and upload an SSH key onto the app's sshd container.

After the key is generated, you need to setup your drush alias by running the following command:

`./bin/generate_drush_alias.sh`

#### Running Drush Commands

At this point you should be able to run any drush command on your container by using the following command:

`drush @rackdock.dev your-drush-command-here`

So for example, if you wish to clear all of your cache bins, you can do so with:

`drush @rackdock.dev cc all`


### Destroying the Evidence

To remove the project and it's respective containers from your system run the following commands:
```
cd /path/to/rackspace-homepage
docker-compose down
docker ps -a | grep rackspacehomepage | awk '{print $1}' | xargs docker rm
docker ps -a | grep drush | awk '{print $1}' | xargs docker rm
cd ../
rm -Rf /path/to/rackspace-homepage
```
