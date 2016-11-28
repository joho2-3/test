<?php get_header(); ?>

<?php do_action( 'bp_before_content' ); ?>

<!-- CONTENT START -->
<div class="content search-post">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ); ?>

<!-- POST ENTRY START -->
<div id="post-entry">
<div class="post-entry-inner">

<?php do_action( 'bp_before_blog_entry' ); ?>

<?php do_action( 'bp_before_post_query' ); ?>

<?php get_template_part( 'content' ); ?>

<?php do_action( 'bp_after_post_query' ); ?>

<?php get_template_part( 'lib/templates/paginate' ); ?>

<?php do_action( 'bp_after_blog_entry' ); ?>

</div>
</div>
<!-- POST ENTRY END -->

<?php do_action( 'bp_after_blog_home' ); ?>

</div><!-- CONTENT INNER END -->
</div><!-- CONTENT END -->

<?php do_action( 'bp_after_content' ); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>