<?php
global $postcount;        

$post_custom_excerpt = get_theme_mod('post_custom_excerpt');
$post_excerpt_moretext = get_theme_mod('post_excerpt_moretext');
$post_blog_style_check = get_theme_mod('blogpost_style');


$archive_excerpt = empty($post_custom_excerpt) ? '30' : $post_custom_excerpt;
$excerpt_moretext = empty($post_excerpt_moretext) ? 'Continue Reading' : $post_excerpt_moretext;
$post_blog_style = empty($post_blog_style_check) ? 'default' : $post_blog_style_check;

$oddpost = 'alt-post'; $postcount = 1;

$feat_size_check = get_theme_mod('feat_img_size');
$feat_size = !empty($feat_size_check) ? $feat_size_check : 'thumbnail';
$feat_size = apply_filters('meso_thumb_size', $feat_size);

$thumb_w = get_option($feat_size.'_size_w');
$thumb_h = get_option($feat_size.'_size_h');

if (have_posts()) : while (have_posts()) :  the_post();
$thepostlink = '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
?>

<?php do_action( 'bp_before_blog_post' ); ?>

<!-- POST START -->
<article <?php post_class($oddpost . ' feat-' . $feat_size . ' post-style-'. $post_blog_style); ?> id="post-<?php the_ID(); ?>">
<?php do_action( 'bp_before_post_title' ); ?>

<?php
echo dez_get_featured_post_image("<div class='post-thumb in-archive size-$feat_size'>".$thepostlink, "</a></div>", $thumb_w, $thumb_h, "alignleft img-is-". $feat_size, $feat_size, dez_get_singular_cat('false'), the_title_attribute('echo=0'), false);
?>

<div class="post-right">
<h2 class="post-title entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<?php get_template_part( 'lib/templates/post-meta' ); ?>
<?php do_action( 'bp_before_post_content' ); ?>
<div class="post-content">
<div class="entry-content"><?php echo dez_get_custom_the_excerpt($archive_excerpt); ?></div>
<?php if($excerpt_moretext == 'disable' || $excerpt_moretext == '') { ?>
<?php } else { ?>
<div class="post-more"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo stripcslashes($excerpt_moretext); ?></a></div>
<?php } ?>
</div>
<?php do_action( 'bp_after_post_content' ); ?>
</div>

</article>
<!-- POST END -->

<?php do_action( 'bp_after_blog_post' ); ?>

<?php ($oddpost == "alt-post") ? $oddpost="" : $oddpost="alt-post"; $postcount++; ?>

<?php endwhile; ?>

<?php else: ?>

<?php get_template_part( 'lib/templates/result' ); ?>

<?php endif; ?>