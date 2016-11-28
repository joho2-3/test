<?php if ( is_single() ) { ?>

<div class="post-nav-archive" id="post-navigator-single">
<div class="alignleft"><?php previous_post_link('&laquo;&nbsp;%link') ?></div>
<div class="alignright"><?php next_post_link('%link&nbsp;&raquo;') ?></div>
</div>

<?php } else { ?>

<div id="post-navigator">
<?php if( function_exists('dez_custom_kriesi_pagination') ) : ?>
<?php echo dez_custom_kriesi_pagination(); ?>
<?php else: ?>
<div class="wp-pagenavi">
<div class="alignright"><?php next_posts_link(__('Older Entries &raquo;', 'mesocolumn') ); ?></div>
<div class="alignleft"><?php previous_posts_link(__('&laquo; Newer Entries', 'mesocolumn') ); ?></div>
</div>
<?php endif; ?>
</div>

<?php } ?>