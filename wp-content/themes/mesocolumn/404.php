<?php get_header(); ?>
<?php do_action( 'bp_before_content' ) ?>
<!-- CONTENT START -->
<div class="content full-width">
<div class="content-inner">
<?php do_action( 'bp_before_blog_home' ) ?>
<!-- POST ENTRY -->
<div id="post-entry">
<div class="post-entry-inner">
<?php do_action( 'bp_before_blog_entry' ); ?>
<?php do_action( 'bp_before_blog_post' ) ?>
<article class="post-single page-single 404-page">
<h1 class="post-title"><?php _e('Error 404', 'mesocolumn'); ?></h1>
<?php do_action( 'bp_before_post_content' ); ?>
<div class="post-content">
<h3><?php _e('The page you requested cannot be found!', 'mesocolumn'); ?></h3>
<p><?php _e('Perhaps you are here because:', 'mesocolumn'); ?></p>
<ul>
<li><?php _e('The page has moved', 'mesocolumn'); ?></li>
<li><?php _e('The page url has been change', 'mesocolumn'); ?></li>
<li><?php _e('The page no longer exist', 'mesocolumn'); ?></li>
</ul>
<p><strong><?php printf(__("Don't worry, we are still here, just <a href='%s'>click here</a> to go back to civilization.", 'mesocolumn'), home_url() ); ?></strong></p>
</div>
<!-- POST CONTENT END -->
<?php do_action( 'bp_after_post_content' ); ?>
</article>
<?php do_action( 'bp_after_blog_post' ) ?>
<?php do_action( 'bp_after_blog_entry' ); ?>
</div>
</div>
<!-- POST ENTRY END -->
<?php do_action( 'bp_after_blog_home' ) ?>
</div><!-- CONTENT INNER END -->
</div><!-- CONTENT END -->
<?php do_action( 'bp_after_content' ) ?>
<?php get_footer(); ?>