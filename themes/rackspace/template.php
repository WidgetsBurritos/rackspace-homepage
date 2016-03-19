<?php

/**
 * Adds variables to the html.tpl.php file.
 *
 * @param $vars
 * @param $hook
 */
function rackspace_preprocess_html(&$variables) {
  // For a revisioned version using the 1200px grid instead of 960px grid add '?bootstrap1200' to the URL.
  $params = drupal_get_query_parameters();
  if (isset($params['bootstrap1200'])) {
    drupal_add_css(drupal_get_path('theme', 'rackspace') . '/bootstrap/css/bootstrap.1200.min.css', array('group' => CSS_THEME));
  }

  // Add the fonts from Google & icons from FontAwesome.
  drupal_add_css('//fonts.googleapis.com/css?family=Open+Sans:700,300,600,800,400|Titillium+Web:300,600,400,700|Quicksand:400,300', array('type' => 'external'));
  drupal_add_css('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array('type' => 'external'));

  // Add a remote favicon
  $attributes = array(
    'href' => 'https://752f77aa107738c25d93-f083e9a6295a3f0714fa019ffdca65c3.ssl.cf1.rackcdn.com/icons/favicon.ico',
    'rel' => 'shortcut icon',
    'type' => 'image/ico',
  );
  drupal_add_html_head_link($attributes);
}

/**
 * Adds variable to the page.tpl.php file.
 *
 * @param $variables
 */
function rackspace_preprocess_page(&$variables) {
  // Add a fully expanded navigation tree as $primary_navigation
  $menu_tree = menu_tree_all_data('main-menu');
  $tree_output_prepare = menu_tree_output($menu_tree);
  _rackspace_add_depth_to_menu_tree($tree_output_prepare);
  $variables['primary_navigation'] = drupal_render($tree_output_prepare);
}


/**
 * Adds custom classes to navtrees.
 *
 * @param $variables
 * @return string
 */
function rackspace_menu_tree($variables) {
  return '<ul class="menu ' . $variables['theme_hook_original'] . '">' . $variables['tree'] . '</ul>';
}

/**
 * Adds bootstrap classes to the main menu.
 *
 * @param $variables
 */
function rackspace_menu_tree__main_menu($variables) {
  return '<ul class="nav navbar-nav ' . $variables['theme_hook_original'] . '">' . $variables['tree'] . '</ul>';
}


/**
 * Adds depth classes to menu items, so we can distinguish between menu levels.
 *
 * @param $tree_output_prepare
 */
function _rackspace_add_depth_to_menu_tree(&$tree_output_prepare, $depth = 1) {
  foreach ($tree_output_prepare as $idx => $branch) {
    if (preg_match('/^\d+$/', $idx)) {
      $tree_output_prepare[$idx]['#attributes']['class'][] = 'depth-' . $depth;
      if (!empty($tree_output_prepare[$idx]['#below'])) {
        _rackspace_add_depth_to_menu_tree($tree_output_prepare[$idx]['#below'], $depth + 1);
      }
    }
  }
}
