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
 * - $page['ceiling']: Items for the ceiling region.
 * - $page['navigation']: Items for the navigation region.
 * - $page['footer']: Items for the footer region.
 * - $page['basement']: Items for the basement region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>

<div id="header">
  <div id="ceiling-bar">
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

  <div id="navigation-bar" class="hidden-xs">
    <div class="container clearfix">
      <div class="col-sm-2">
        <a class="logo" href="<?php echo $front_page; ?>"></a>
      </div>
      <div class="col-sm-7">
        <ul>
          <li><a href="#">xyz</a></li>
          <li><a href="#">xyz</a></li>
          <li><a href="#">xyz</a></li>
          <li><a href="#">xyz</a></li>
        </ul>
      </div>
      <div class="col-sm-2">
        MAG
      </div>
    </div>
  </div>
</div>


<!-- BEGIN CONTENT -->
<?php if (!empty($page['content'])): ?>
  <div class="region-content">
    <div class="container">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="region-highlighted">
          <?php print render($page['highlighted']); ?>
        </div>
      <?php endif; ?>



      <?php /* if (!empty($breadcrumb)): print $breadcrumb; endif; */ ?>
      <a id="main-content"></a>
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


      <?php print render($page['content']); ?>
    </div>
  </div>
<?php endif; ?>
<!-- END CONTENT -->

<!-- BEGIN FOOTER -->
<?php if (!empty($page['footer'])): ?>
  <div class="region-footer">
    <div class="container">
      <?php print render($page['footer']); ?>
    </div>
  </div>
<?php endif; ?>
<!-- END FOOTER -->

<!-- BEGIN BASEMENT -->
<?php if (!empty($page['basement'])): ?>
  <div class="region-basement">
    <div class="container">
      <?php print render($page['basement']); ?>
    </div>
  </div>
<?php endif; ?>
<!-- END BASEMENT -->
