<?php
/**
 * @file
 * Rackspace theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
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
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
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
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>


<nav class="navbar navbar-default navbar-fixed-top">
  <div class="row1 hidden-xs">
    <div class="container clearfix">
      <div class="col-sm-6 text-left">
        <ul>
          <li><?php echo l(t('Support: '), 'https://www.rackspace.com/support') . l(t('1-800-961-4454'), 'tel:+18009614454'); ?></li>
          <li><?php echo l(t('Sales: '), 'https://www.rackspace.com/sales') . l(t('1-844-858-8901'), 'tel:+18448588901'); ?></li>
          <li><?php echo l(t('Email Us'), 'https://www.rackspace.com/information/contactus#form'); ?></li>
          <li><?php echo l(t('Sales Chat'), 'https://www.rackspace.com/#chat'); ?></li>
        </ul>
      </div>
      <div class="col-sm-6 text-right">
        <ul>
          <li><a href="">DEVELOPERS</a></li>
          <li><a href="">PARTNERS</a></li>
          <li>SIGN UP</li>
          <li>LOG IN</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row2">
    <div class="container">
      <!-- Company Logo -->
      <div class="navbar-header">
        <a class="navbar-brand" href="#">
          <img alt="Rackspace - the #1 managed cloud company"
               src="https://752f77aa107738c25d93-f083e9a6295a3f0714fa019ffdca65c3.ssl.cf1.rackcdn.com/navigation/rackspace-logo-tagline-simplified.svg"/>
        </a>
      </div>
      <!-- End Company Logo -->

      <!-- Collapses on mobile -->
      <div class="collapse navbar-collapse" id="main-menu-nav">
        <?php print $primary_navigation; ?>

        <form action="https://www.rackspace.com/searchresults"
              class="navbar-form navbar-right" role="search">
          <div class="form-group">
            <input type="text" name="query" class="form-control"
                   placeholder="Search">
          </div>
          <span id="search-button" class="search-button"></span>
        </form>
      </div>
      <!-- End mobile collapse -->
    </div>
  </div>
</nav>


<!-- BEGIN CONTENT -->
<?php if (!empty($page['content'])): ?>
  <div id="region-content">
    <div class="container">
      <?php if (!empty($page['highlighted'])): ?>
        <!-- .region-highlighted -->
        <div class="region-highlighted">
          <?php print render($page['highlighted']); ?>
        </div>
        <!-- /.region-highlighted -->
      <?php endif; ?>

      <!-- Anchor here-->
      <a id="main-content"></a>

      <!-- .drupal-help -->
      <?php print $messages; ?>
      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <div class="region-help">
          <?php print render($page['help']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <!-- /.drupal-help -->

      <!-- .region-content -->
      <div class="region-content">
        <?php print render($page['content']); ?>
      </div>
      <!-- /.region-content -->
    </div>
  </div>
<?php endif; ?>



<?php if (!empty($page['footer'])): ?>
  <!-- .region-footer -->
  <div class="region-footer">
    <div class="container">
      <?php print render($page['footer']); ?>
    </div>
  </div>
  <!-- /.region-footer -->
<?php endif; ?>
<!-- END FOOTER -->


<?php if (!empty($page['basement'])): ?>
  <!-- .region-basement -->
  <div class="region-basement">
    <div class="container">
      <?php print render($page['basement']); ?>
    </div>
  </div>
  <!-- /.region-basement -->
<?php endif; ?>

