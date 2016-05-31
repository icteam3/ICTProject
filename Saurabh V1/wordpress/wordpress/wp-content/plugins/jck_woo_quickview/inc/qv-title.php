<?php do_action($this->slug.'-before-title'); ?>

<?php echo '<h1>'.get_the_title($_REQUEST['pid']).'</h1>'; ?>

<?php do_action($this->slug.'-after-title'); ?>