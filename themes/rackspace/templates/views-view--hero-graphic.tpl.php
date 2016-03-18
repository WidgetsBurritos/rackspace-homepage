<?php
/**
 * @file
 *
 * Adds a custom wrapper around the hero graphic view, including a background
 * image if specified by the user.
 *
 * @ingroup themeable
 */


if (!empty($view->result)):
  $background_image = $view->result[0]->field_field_background_image_url[0]['raw']['value'];
  if (!empty($background_image)) {
    $div_attr = sprintf(' style="background-image: url(%s);"', $background_image);
  }
  else {
    $div_attr = '';
  }
  ?>

  <div class="background"<?php echo $div_attr; ?>>
    <div class="container">
      <?php echo $rows; ?>
    </div>
  </div>


<?php endif; ?>