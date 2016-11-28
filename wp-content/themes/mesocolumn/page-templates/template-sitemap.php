<?php
/*
Template Name: Sitemap
*/
?>

<?php get_header(); ?>

<?php do_action( 'bp_before_content' ); ?>
<!-- CONTENT START -->
<div class="content">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ); ?>

 <!-- POST ENTRY START -->

<div id="post-entry">
<div class="post-entry-inner">
<?php do_action( 'bp_before_blog_entry' ); ?>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<?php do_action( 'bp_before_blog_post' ); ?>

<article <?php post_class('post-single page-single'); ?> id="post-<?php the_ID(); ?>">

<h1 class="post-title entry-title"><?php the_title(); ?></h1>
<?php get_template_part( 'lib/templates/post-meta' ); ?>

<?php do_action( 'bp_before_post_content' ); ?>
<div class="post-content entry-content">
<?php the_content(); ?>
<h4><?php _e('Archives by Month:', 'mesocolumn'); ?></h4>
<ul class="the-icons"><?php wp_get_archives('before=<i class="fa fa-table"></i>&type=monthly&limit=12&show_post_count=1'); ?></ul>
<h4><?php _e('Archives by Category:', 'mesocolumn'); ?></h4>
<ul class="the-icons">
<?php
  $categories = get_categories();
  foreach ($categories as $cat) {
  echo '<li><i class="fa fa-file"></i><a href="'.site_url().'/'.get_option('category_base').'/'.$cat->category_nicename.'/"><span>'.$cat->cat_name.'</a></li>';
  }
?>
</ul>
<h4><?php _e('Browse Last 50 Posts:', 'mesocolumn'); ?></h4>
<ul class="the-icons"><?php wp_get_archives('before=<i class="fa fa-bookmark"></i>&type=postbypost&limit=50'); ?> </ul>
</div>
<?php do_action( 'bp_after_post_content' ); ?>

</article>

<?php do_action( 'bp_after_blog_post' ); ?>

<?php endwhile; ?>

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

<?php get_sidebar(); ?>

<?php get_footer(); ?>