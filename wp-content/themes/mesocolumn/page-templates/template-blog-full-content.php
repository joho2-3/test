<?php
/*
Template Name: Blog Full Content
*/
?>

<?php get_header(); ?>

<?php do_action( 'bp_before_content' ); ?>
<!-- CONTENT START -->
<div class="content blog-full-content">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ); ?>

<!-- POST ENTRY START -->
<div id="post-entry">
<div class="post-entry-inner">

<?php do_action( 'bp_before_blog_entry' ); ?>

<?php
global $page,$paged,$more; $more = 0;
$max_num_post = get_option('posts_per_page');

if('page' == get_option( 'show_on_front' )) {
$page = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

query_posts("posts_per_page=$max_num_post&paged=$page");
$oddpost = 'alt-post'; $postcount = 1;
if (have_posts()) : while ( have_posts() ) : the_post(); ?>

<?php do_action( 'bp_before_blog_post' ); ?>

<!-- POST START -->
<article <?php post_class($oddpost); ?> id="post-<?php the_ID(); ?>">

<h2 class="post-title entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<?php get_template_part( 'lib/templates/post-meta' ); ?>

<?php do_action( 'bp_before_post_content' ); ?>
<div class="post-content">
<div class="entry-content"><?php the_content( __('...Continue reading', 'mesocolumn') ); ?></div>
</div>
<?php do_action( 'bp_after_post_content' ); ?>

</article>
<!-- POST END -->

<?php do_action( 'bp_after_blog_post' ); ?>

<?php ($oddpost == "alt-post") ? $oddpost="" : $oddpost="alt-post"; $postcount++; ?>

<?php endwhile; ?>

<?php else: ?>

<?php get_template_part( 'lib/templates/result' ); ?>

<?php endif; ?>

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