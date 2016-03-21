<?php

/**
 * Prepares variables for html templates.
 *
 * Default template: html.tpl.php.
 *
 * @param array $variables
 * - $rdf_namespaces
 */
function rackspace_preprocess_html(&$variables) {
  // Override existing RDF namespaces to use RDFa 1.1 namespace prefix bindings.
  if (function_exists('rdf_get_namespaces')) {
    $rdf = array('prefix' => array());
    foreach (rdf_get_namespaces() as $prefix => $uri) {
      $rdf['prefix'][] = $prefix . ': ' . $uri;
    }
    if (!$rdf['prefix']) {
      $rdf = array();
    }
    $variables['rdf_namespaces'] = drupal_attributes($rdf);
  }

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
 * Prepares variables for page templates.
 *
 * Default template: html.tpl.php.
 *
 * @param array $variables
 * - $primary_navigation: The main menu of the site formatted with each <li>
 *   containing a css class indicative of it's depth relative to the root.
 *   (e.g. li.depth-1, li.depth-2, etc...)
 */
function rackspace_preprocess_page(&$variables) {
  // Add a fully expanded navigation tree as $primary_navigation
  $menu_tree = menu_tree_all_data('main-menu');
  $tree_output_prepare = menu_tree_output($menu_tree);
  _rackspace_add_depth_to_menu_tree($tree_output_prepare);
  $variables['primary_navigation'] = drupal_render($tree_output_prepare);
}

/**
 * Prepares variables for entity templates.
 */
function rackspace_preprocess_entity(&$variables) {
  $is_fci = $variables['entity_type'] == 'field_collection_item';
  $is_content_regions = isset($variables['field_collection_item']->field_name) && $variables['field_collection_item']->field_name == 'field_content_regions';
  if ($is_fci && $is_content_regions) {
    rackspace_preprocess_field_content_regions($variables);
  }
}

/**
 * Prepares variables for field_content_regions display.
 *
 * @param array $variables
 * - $bg_class: The CSS class to apply to the background container.
 * - $column_ct: The number of columns this content container is.
 * - $column_class_1: The CSS class of column 1
 * - $column_class_2: The CSS class of column 2 (if $column_ct > 1)
 * - $content_1: The content of column 1
 * - $content_2: The content of column 2 (if $column_ct > 1)
 * - $pre_column_content: Content that appears above the column section
 * - $region_css_class: CSS classes that apply to the entire content region
 */
function rackspace_preprocess_field_content_regions(&$variables) {
  // Retrieve column 1 variables.
  $variables['bg_class'] = isset($variables['field_background_color'][0]['value']) ? $variables['field_background_color'][0]['value'] : '';
  $variables['column_ct'] = isset($variables['field_columns'][0]['value']) ? $variables['field_columns'][0]['value'] : 0;
  $variables['column_class_1'] = isset($variables['field_column_1_class'][0]['safe_value']) ? $variables['field_column_1_class'][0]['safe_value'] : '';
  $variables['pre_column_content'] = isset($variables['field_introduction'][0]['safe_value']) ? $variables['field_introduction'][0]['safe_value'] : '';
  $variables['region_css_class'] = isset($variables['field_region_css_class'][0]['safe_value']) ? $variables['field_region_css_class'][0]['safe_value'] : '';
  $content_type_1 = isset($variables['field_column_1_type'][0]['value']) ? $variables['field_column_1_type'][0]['value'] : '';

  if ($content_type_1 == "block") {
    // Column 1 should be rendered as a block.
    $variables['content_1'] = drupal_render($variables['content']['field_content_1_block']);
  }
  else {
    // Column 1 should be rendered as plain content.
    $variables['content_1'] = drupal_render($variables['content']['field_column_1_content']);
  }

  // In the case of a single column, assign full width to it.
  if ($variables['column_ct'] < 2) {
    $variables['column_class_1'] .= ' col-xs-12';
  }
  // Otherwise, retrieve multi-column variables, and set column widths accordingly.
  else {
    dpm($variables);
    $column_xs = explode('/', $variables['field_xs_column_split'][0]['value']);
    $column_sm = explode('/', $variables['field_sm_column_split'][0]['value']);
    $column_md = explode('/', $variables['field_bootstrap_md_column_split'][0]['value']);
    $variables['column_class_2'] = $variables['field_column_2_class'][0]['safe_value'];
    $variables['column_class_1'] .= sprintf(' col-xs-%d col-sm-%d col-md-%d', $column_xs[0], $column_sm[0], $column_md[0]);
    $variables['column_class_2'] .= sprintf(' col-xs-%d col-sm-%d col-md-%d', $column_xs[1], $column_sm[1], $column_md[1]);
    $content_type_2 = $variables['field_column_2_type'][0]['value'];

    if ($content_type_2 == "block") {
      // Column 2 should be rendered as a block.
      $variables['content_2'] = drupal_render($variables['content']['field_content_2_block']);
    }
    else {
      // Column 2 should be rendered as plain content.
      $variables['content_2'] = drupal_render($variables['content']['field_column_2_content']);
    }
  }
}


/**
 * Implements theme_menu_tree().
 */
function rackspace_menu_tree($variables) {
  return '<ul class="menu ' . $variables['theme_hook_original'] . '">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_tree__MENU_NAME().
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
