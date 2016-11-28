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

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php do_action( 'bp_before_blog_post' ); ?>

<!-- POST START -->
<article <?php post_class('post-single'); ?> id="post-<?php the_ID(); ?>" <?php do_action('bp_article_start'); ?>>

<div class="post-top">
<h1 class="post-title entry-title" <?php do_action('bp_article_post_title'); ?>><?php the_title(); ?></h1>
<?php get_template_part( 'lib/templates/post-meta' ); ?>
</div>

<?php do_action( 'bp_before_post_content' ); ?>

<div class="post-content">

<?php $get_ads_single_top = get_theme_mod('ads_single_top'); if($get_ads_single_top != '') { ?>
<div class="adsense-single adtop"><?php echo stripcslashes(do_shortcode($get_ads_single_top)); ?></div>
<?php } ?>

<div class="entry-content" <?php do_action('bp_article_post_content'); ?>>
<?php the_content( __('...more &raquo;','mesocolumn') ); ?>
</div>
<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>

<?php $get_ads_single_bottom = get_theme_mod('ads_single_bottom'); if($get_ads_single_bottom != '') { ?>
<div class="adsense-single adbottom"><?php echo stripcslashes(do_shortcode($get_ads_single_bottom)); ?></div>
<?php } ?>

</div>

<?php do_action( 'bp_after_post_content' ); ?>

<?php get_template_part( 'lib/templates/post-meta', 'bottom' ); ?>

<?php $get_related = get_theme_mod('related_on'); if($get_related == 'enable'):
get_template_part( 'lib/templates/related' );
endif
?>

</article>
<!-- POST END -->

<?php do_action( 'bp_after_blog_post' ); ?>

<?php if( function_exists('dez_set_wp_post_view') ){ dez_set_wp_post_view( get_the_ID() ); } ?>

<?php endwhile; ?>

<?php
$get_author_bio = get_theme_mod('author_bio_on'); if($get_author_bio == 'enable'):
get_template_part( 'lib/templates/author-bio' );
endif
?>

<?php comments_template(); ?>

<?php else : ?>

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