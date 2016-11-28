<?php
$feat_thumb = dez_get_featured_post_image('<div class="feat-thumb"><a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">','</a></div>',120, 120, 'alignleft','thumbnail',dez_get_image_alt_text(),the_title_attribute('echo=0'), false);
$feat_post_thumb = apply_filters('meso_bottom_feat_thumb',$feat_thumb);
?>

<?php echo $feat_post_thumb; ?>

<div class="feat-right">
<h2 class="entry-title feat-title"><a rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo the_title(); ?></a></h2>

<?php do_action('bp_before_feat_meta'); ?>
<div class="feat-meta"><span class="feat_author vcard"><?php the_author_posts_link(); ?></span>
<span class="feat_time entry-date"><abbr class="published" title="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo the_time( get_option( 'date_format' ) ); ?></abbr></span>
<span class="feat_comment"><?php comments_popup_link(__('No Comment','mesocolumn'), __('1 Comment','mesocolumn'), __('% Comments','mesocolumn') ); ?></span><?php $getmodtime = get_the_modified_time(); if( !$getmodtime ) {$modtime = '<span class="date updated meta-no-display">'. get_the_time('c') . '</span>';} else {$modtime = '<span class="date updated meta-no-display">'. get_the_modified_time('c') . '</span>';} echo $modtime; ?></div>
<?php do_action('bp_after_feat_meta'); ?>

<?php
$post_custom_excerpt = get_theme_mod('feat_text_count');
if($post_custom_excerpt == '0') { } else { ?><div class="entry-content feat-content"><?php echo dez_get_custom_the_excerpt($post_custom_excerpt,''); ?></div><?php } ?>
</div>