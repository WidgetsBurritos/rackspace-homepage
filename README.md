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
  - Attempts to download VirtualBox/Drush if missing
  - Downloads Drupal 7
  - Creates a unique Docker machine
  - Sets Docker environment variables
  - Starts the application containers
  - Generates custom ssh keys for use with the ssh container & Drush
  - Generates Drush aliases for use with the application.

From the previous step just type in the following commands:

```
cd rackspace-homepage
./scripts/setup.sh
```

If Drush or virtualbox are missing from your system, you will be prompted to install them:

> Would you like to install Drush? [y|N]

> Would you like to install VirtualBox 5.0.16? (NOTE: This will require sudo privileges). [y|N]

When asked for `root@192.168.99.100's password:` enter `toor`.


### Step 3.) Opening the Site in Your Browser

The application can be accessed by going to `http://DOCKER_IP_ADDRESS:8910` in your browser, where `DOCKER_IP_ADDRESS` is the value of your Docker machine's IP address.

If you don't know what the IP address you can just run the following command to load the site in your system's default browser:

`./scripts/load-site.sh`

If you wish to login to Drupal, goto `http://DOCKER_IP_ADDRESS:8910/user` and user the `admin`/`admin` as your credentials.

---

## Project Notes:

The site was developed to be fully responsive, and make improvements on the existing website's responsiveness by utilizing bootstrap as the core style framework.
Bootstrap is normally used for 1200px grids out of the box, but [following the steps laid out here](http://stackoverflow.com/questions/20057380/bootstrap-3-how-to-set-default-grid-to-960px-width#answer-21107438), I converted it into a 960px grid, to match the existing Rackspace grid system.

All links to other pages on the website open in the www.rackspace.com counterpart in a new window, so you don't lose track of the Docker app.

#### Modules used
- `block_class` - Used to apply CSS classes to blocks.
- `blockreference` - Used to reference blocks as fields in the content region field collection.
- `captcha` - Used to add the captcha check on the form.
- `conditional_fields` - Used to hide fields when they weren't necessary in the admin panel.
- `ctools` - Required by views module.
- `devel` - Used to debug my code along the way.
- `ds` - Used to layout various entity types, both in the front-end and administratively.
- `ds_bootstrap_layouts` - Provided bootstrap-specific layouts to Display Suite.
- `entity` - Required by field_collection module.
- `fancybox` - Used for region/language selection modal.
- `field_collection` - Used to create repeatable-subfields for page nodes, allowing for easy embedding of bootstrap-styled content.
- `jquery_update` - Used to meet bootstrap requirements. 
- `libraries` - Used to store the fancybox library.
- `menu_attributes` - Used to add CSS classes to menu links, and &lt;li&gt; tags.
- `recaptcha` - The specific captcha mechanism used.
- `references` - Required by blockreference module.
- `special_menu_items` - Allows the addition of &lt;nolink&gt; and &lt;separator&gt; links, into standard menu functionality.
- `views` - Used to display various content types and taxonomy terms in a visually appealing manner.
- `webform` - Used to create the contact form.

#### Locations of App-Specific Resources

Since Docker builds Drupal from an image, our app-specific resources are located in the following locations relative to the application path:

- Modules:  `./modules/`
- Themes: `./themes/`
- Libraries: `./libraries/`
- Files: `./files/`
- Settings file: `./settings.php`

---

## Content Regions

Here is how each component of the site was constructed:

#### Ceiling Regions

The ceiling consists of two regions: *Ceiling Left* and *Ceiling Right*.

Both regions contain menu blocks. Making use of the *menu_attributes* and *special_menu_items* modules, I was able to add extra style to the menus.

#### Navigation Bar Region

The navigation bar consists of main navigation menu, and a few content blocks for the search and mobile navigation icons.

The navigation system was built based off the standard bootstrap navigation system, but modified to mimick the existing rackspace.com functionality as much as possible.

#### Hero Region

The hero region, utilizes a custom content type, called *Hero Content*, which allows a user to enter a background image and content.
It is then rendered as a block via the *Hero Graphic* view, which is then padded with bootstrap wrappers via the `views-view--hero-graphic.tpl.php` template file located in the theme.

#### Content Region

The *content region* is a combination of the Field Collection, Views, Blocks and Display Suite modules.

They are rendered via the `rackspace_preprocess_field_content_regions()` function in the theme's `template.php` file and via a special template: `field-collection-item--field-content-regions.tpl.php`

Each individual content region is either a single, or two-columned content area, that can utilize either straight content, or include blocks directly into the page, in a bootstrap-friendly manner.

- The *hosting solutions* section is a 7/5 bootstrap column structure, where each column has a view-based block as its content, displaying the particular hosting solution taxonomy terms.

- The *IT solutions* section is a single view block referencing all IT solution taxonomy terms.

- The contact form section is a 6/6 bootstrap column structure, where the left column is straight content, and the right content is a webform block.

- The *news &amp; events* section is a single-column view block. The view itself then breaks the articles up into the 4/4/4 bootstrap layout.

#### Carpet Region

The *carpet region* is defined by blocks with appropriate bootstrap CSS classes.

#### Footer Region

The *footer region* is one giant menu block, whose functionality was made to mimick the existing functionality on rackspace.com.

#### Basement Region

Contains three visible blocks laid out as columns:
- Region Selector
- Currency Selector
- Copyright Info

It also contains a block for the live chat slider.

---
## Other Items of Importance

#### Running Drush Commands

You can run any Drush command on your Docker container by doing the following:

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
/path/to/rackspace-homepage/script/destroy.sh
cd ~/
rm -Rf /path/to/rackspace-homepage
```
