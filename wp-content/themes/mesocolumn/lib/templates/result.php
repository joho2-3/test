<h2 class="effect-1 header-title"><?php _e('No Result Found!', 'mesocolumn'); ?></h2>
<p class="result-notice"><?php if (is_category()) { ?>
<?php _e("Sorry, we can't find the category you're looking for at this URL. Please try selecting a menu item from above or to the side of this message to get where you'd like to go.", 'mesocolumn'); ?>
<?php } else if (is_archive()) { ?>
<?php _e("Sorry, we can't find the archive you're looking for at this URL. Please try selecting a menu item from above or to the side of this message to get where you'd like to go.", 'mesocolumn'); ?>
<?php } else if (is_search()) { ?>
<?php _e("Sorry, we can't find the search keyword you're looking for. Please try selecting a menu item from above or to the side of this message to get where you'd like to go.", 'mesocolumn'); ?>
<?php } else if (is_author()) { ?>
<?php _e("Sorry, we can't find the author you're looking for at this URL. Please try selecting a menu item from above or to the side of this message to get where you'd like to go.", 'mesocolumn'); ?>
<?php } else if (is_single()) { ?>
<?php _e("Sorry, we can't find the post you're looking for at this URL. Please try selecting a menu item from above or to the side of this message to get where you'd like to go.", 'mesocolumn'); ?>
<?php } else if (is_home()) { ?>
<?php _e("Sorry, we can't find the content you're looking for at this URL. Please try selecting a menu item from above or to the side of this message to get where you'd like to go.", 'mesocolumn'); ?>
<?php } else if (is_404()) { ?>
<?php _e("Sorry, we can't find the content you're looking for at this URL. Please try selecting a menu item from above or to the side of this message to get where you'd like to go.", 'mesocolumn'); ?>
<?php } ?></p>