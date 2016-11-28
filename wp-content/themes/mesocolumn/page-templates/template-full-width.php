<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

<?php do_action( 'bp_before_content' ); ?>
<!-- CONTENT START -->
<div class="content full-width">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ); ?>

<!-- POST ENTRY -->
<div id="post-entry">
<div class="post-entry-inner">
<?php do_action( 'bp_before_blog_entry' ); ?>

<?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>

<?php do_action( 'bp_before_blog_post' ); ?>
<article <?php post_class('post-single page-single'); ?> id="post-<?php the_ID(); ?>">
<h1 class="post-title entry-title"><?php the_title(); ?></h1>
<?php get_template_part( 'lib/templates/post-meta' ); ?>
<?php do_action( 'bp_before_post_content' ); ?>
<div class="post-content">
<div class="entry-content"><?php the_content( __('...Continue reading', 'mesocolumn') ); ?></div>
<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
</div><!-- POST CONTENT END -->
<?php do_action( 'bp_after_post_content' ); ?>
</article>
<?php do_action( 'bp_after_blog_post' ); ?>

<?php endwhile; ?>
<?php comments_template(); ?>
<?php else : ?>
<?php get_template_part( 'lib/templates/result' ); ?>
<?php endif; ?>

<?php do_action( 'bp_after_blog_entry' ); ?>
</div>
</div>
<!-- POST ENTRY END -->

<?php do_action( 'bp_after_blog_home' ); ?>

</div><!-- CONTENT INNER END -->
</div><!-- CONTENT END -->

<?php do_action( 'bp_after_content' ); ?>

<?php get_footer(); ?>