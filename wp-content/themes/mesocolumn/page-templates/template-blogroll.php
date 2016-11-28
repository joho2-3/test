<?php
/*
Template Name: Blogroll
*/
?>

<?php get_header(); ?>

<?php do_action( 'bp_before_content' ); ?>
<!-- CONTENT START -->
<div class="content">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ); ?>

<div id="post-entry">
<div class="post-entry-inner">
<?php do_action( 'bp_before_blog_entry' ); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php do_action( 'bp_before_blog_post' ); ?>
<!-- POST START -->
<article <?php post_class('post-single page-single'); ?> id="post-<?php the_ID(); ?>">
<h1 class="post-title entry-title"><?php the_title(); ?></h1>
<?php do_action( 'bp_before_post_content' ); ?>
<div class="post-content entry-content">
<?php the_content(); ?>
<h2><?php _e('Useful Resources:', 'mesocolumn'); ?></h2>
<ul><?php wp_list_bookmarks('title_li=&categorize=0'); ?></ul>
</div>
<?php do_action( 'bp_after_post_content' ); ?>
</article>
<!-- POST END -->
<?php do_action( 'bp_after_blog_post' ); ?>
<?php endwhile; endif; ?>

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