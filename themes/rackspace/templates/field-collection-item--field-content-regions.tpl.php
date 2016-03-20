<?php
/**
 * @file
 * Displays the basic page structure of the site.
 *
 * Available variables:
 * - $bg_class: The CSS class to apply to the background container.
 * - $column_ct: The number of columns this content container is.
 * - $column_class_1: The CSS class of column 1
 * - $column_class_2: The CSS class of column 2 (if $column_ct > 1)
 * - $content_1: The content of column 1
 * - $content_2: The content of column 2 (if $column_ct > 1)
 * - $pre_column_content: Content that appears above the column section
 * - $region_css_class: CSS classes that apply to the entire content region
 *
 * @see rackspace_preprocess_field_content_regions()
 * @see rackspace_preprocess_entity
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */
?>
<div class="content-region <?php print $bg_class; ?> <?php print $region_css_class; ?>">
  <div class="container">
    <div class="row clearfix">
      <?php print $pre_column_content; ?>
      <div class="<?php print $column_class_1; ?>">
        <?php print $content_1; ?>
      </div>
      <?php if ($column_ct > 1) : ?>
        <div class="<?php print $column_class_2; ?>">
          <?php print $content_2; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

