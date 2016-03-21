<?php
/**
 * @file
 * Displays the basic page structure of the site.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 * - $primary_navigation: The main menu of the site formatted with each <li>
 *   containing a css class indicative of it's depth relative to the root.
 *   (e.g. li.depth-1, li.depth-2, etc...)
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['ceiling_left']: Items for the left portion of the ceiling.
 * - $page['ceiling_right']: Items for the right portion of the ceiling.
 * - $page['navbar']: Items for the navigation bar region.
 * - $page['hero']: Items for the hero content region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['carpet']: Items for the carpet region.
 * - $page['footer']: Items for the footer region.
 * - $page['basement']: Items for the basement region.
 *
 * @see rackspace_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 */
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="ceiling hidden-xs hidden-sm">
    <div class="container clearfix">
      <div class="row">
        <div class="col-sm-6 ceiling-col">
          <?php
          if (!empty($page['ceiling_left'])) {
            print render($page['ceiling_left']);
          }
          ?>
        </div>
        <div class="col-sm-6 ceiling-col">
          <?php
          if (!empty($page['ceiling_right'])) {
            print render($page['ceiling_right']);
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- ./ceiling -->

  <div class="main-menu">
    <div class="container">
      <div class="row">
        <?php
        if (!empty($page['navbar'])) {
          print render($page['navbar']);
        }
        ?>

        <div class="collapse navbar-collapse" id="main-menu-nav">
          <?php
          print $primary_navigation;
          ?>
        </div>
        <!-- ./navbar-collapse -->
      </div>
    </div>
  </div>
  <!-- /.main-menu -->
</nav>
<!-- /.navbar-fixed-top -->


<?php if (!empty($page['hero'])): ?>
  <div class="outer-region-hero text-left">
    <?php print render($page['hero']); ?>
  </div>
  <!-- /.outer-region-hero -->
<?php endif; ?>

<?php if (!empty($page['content'])): ?>
  <div class="outer-region-content">
    <div class="container">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="outer-region-highlighted">
          <?php print render($page['highlighted']); ?>
        </div>
        <!-- /.outer-region-highlighted -->
      <?php endif; ?>

      <!-- Anchor here-->
      <a id="main-content"></a>

      <?php print $messages; ?>
      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <div class="outer-region-help">
          <?php print render($page['help']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php
      // Non-page style nodes do not create their own bootstrap containers, so
      // they should be nested inside the default container.
      if ($page['#type'] != 'page') {
        print render($page['content']);
      } ?>
    </div>

    <?php
    // Pages create their own containers, so they must be included outside of
    // the <div class="container"> above.
    if ($page['#type'] == 'page') {
      print render($page['content']);
    } ?>
  </div>
  <!-- /.outer-region-content -->

<?php endif; ?>


<?php if (!empty($page['carpet'])): ?>
  <div class="outer-region-carpet hidden-xs text-left">
    <div class="container clearfix">
      <div class="row">
        <?php print render($page['carpet']); ?>
      </div>
    </div>
  </div>
  <!-- /.outer-region-carpet -->
<?php endif; ?>

<?php if (!empty($page['footer'])): ?>
  <div class="outer-region-footer">
    <div class="container clearfix">
      <?php print render($page['footer']); ?>
    </div>
  </div>
  <!-- /.outer-region-footer -->
<?php endif; ?>


<?php if (!empty($page['basement'])): ?>
  <div class="outer-region-basement">
    <div class="container">
      <div class="row clearfix">
        <?php print render($page['basement']); ?>
      </div>
    </div>
  </div>
  <!-- /.outer-region-basement -->
<?php endif; ?>

