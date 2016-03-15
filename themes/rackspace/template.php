<?php

/**
 * Implements template_preprocess_html().
 *
 * @param $vars
 * @param $hook
 */
function rackspace_preprocess_html(&$variables, $hook) {
  // Add the fonts from google webfonts.
  drupal_add_css('http://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:700,300,600,800,400|Titillium+Web:300,600,400,700|Quicksand:400,300', array('type' => 'external'));

  // Add a remote favicon
  $attributes = array(
    'href' => 'https://752f77aa107738c25d93-f083e9a6295a3f0714fa019ffdca65c3.ssl.cf1.rackcdn.com/icons/favicon.ico',
    'rel' => 'shortcut icon',
    'type' => 'image/ico',
  );
  drupal_add_html_head_link($attributes);
}

