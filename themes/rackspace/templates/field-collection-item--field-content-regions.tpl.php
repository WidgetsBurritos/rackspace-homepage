<?php


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

