<?php do_action( 'bp_before_commentpost' ); ?>

<div id="commentpost">

<?php if ( !comments_open() && !have_comments() ) : ?>
<?php else: ?>
<h4 id="comments"><span><?php comments_number(__('No Comments Yet', 'mesocolumn'), __('1 Comment Already', 'mesocolumn'), __('% Comments Already', 'mesocolumn')); ?></span></h4>
<?php endif; ?>

<?php $comsub = get_theme_mod('comment_subscribe');
if ( comments_open() && $comsub == 'enable') : ?>
<div class="post-nav-archive">
<div id="rssfeed" class="alignleft"><a title="<?php __('stay updated with', 'mesocolumn'); ?> <?php the_title_attribute(); ?>" href="<?php echo home_url() ?>/?feed=rss2&amp;p=<?php the_ID(); ?>"><?php _e('Subscribe to comments feed', 'mesocolumn'); ?></a></div>
</div>
<?php endif; ?>

<?php if ( have_comments() ) : ?>
<?php do_action( 'bp_before_blog_comment_list' ) ?>
<ol class="commentlist">
<?php wp_list_comments('type=comment&callback=dez_get_the_list_comments'); ?>
</ol>
<?php do_action( 'bp_after_blog_comment_list' ) ?>
<?php endif; ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
<div class="post-nav-archive">
<div class="alignright"><?php if(function_exists('paginate_comments_links')) {  paginate_comments_links(); } ?></div>
</div>
<?php endif; ?>

<?php do_action( 'bp_before_blog_ping_list' ); ?>
<?php if ( ! empty($comments_by_type['pings']) ) : ?>
<h4><span><?php echo dez_get_wp_comment_count('pings'); ?></span></h4>
<ol class="pinglist">
<?php wp_list_comments('type=pings&callback=dez_get_the_list_pings'); ?>
</ol>
<?php endif; ?>
<?php do_action( 'bp_after_blog_ping_list' ); ?>

<?php if ( comments_open() ) : ?>
<?php comment_form(); ?>
<?php else: $comment_notice = get_theme_mod('comment_notice'); if($comment_notice != 'disable'): ?>
<?php if( get_post_type() == 'post' || get_post_type() == 'page' ):
echo "<p class='theme-messages alert'>". __('Sorry, comments are closed for this post', 'mesocolumn') . "</p>";
endif;
endif;
endif;
?>

</div>
<?php do_action( 'bp_after_commentpost' ); ?>