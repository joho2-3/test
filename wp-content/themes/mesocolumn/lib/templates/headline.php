<?php
do_action('bp_before_headline');
global $page, $paged;
$cat_id = get_queried_object()->term_id;;
$cat_name = get_queried_object()->name;;
if( is_home() || is_page_template('page-templates/template-blog.php') ) { ?>

<h2 class="inblog effect-1 header-title"><?php _e('Latest News From The', 'mesocolumn'); ?> <span><?php _e('Blog', 'mesocolumn'); ?></span><?php if ( $paged >= 2 || $page >= 2 ) { ?> - <?php _e('Page', 'mesocolumn'); ?> <?php echo $paged; ?><?php } ?><?php do_action('bp_inside_headline'); ?></h2>

<?php } else if ( is_category() ) { ?>

<h2 class="incat effect-1 header-title feat_tn_cat_color_<?php echo $cat_id; ?>"><?php _e('Archives for', 'mesocolumn'); ?> <?php single_cat_title(); ?><?php if ( $paged >= 2 || $page >= 2 ) { ?> - <?php _e('Page', 'mesocolumn'); ?> <?php echo $paged; ?><?php } ?><?php do_action('bp_inside_headline'); ?></h2>

<?php } else if ( is_tag() ) { ?>

<h2 class="intag effect-1 header-title"><?php _e('Tag archives for', 'mesocolumn'); ?> <?php single_cat_title(); ?><?php if ( $paged >= 2 || $page >= 2 ) { ?> - <?php _e('Page', 'mesocolumn'); ?> <?php echo $paged; ?><?php } ?><?php do_action('bp_inside_headline'); ?></h2>

<?php } else if (is_author()) { ?>

<h2 class="inauthor effect-1 header-title">
<?php if ( have_posts() ) : the_post(); ?>
<?php printf( __( 'Author Archives: %s', 'mesocolumn' ), '<span class="vcard"><a class="url fn" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?><?php if ( $paged >= 2 || $page >= 2 ) { ?> - <?php _e('Page', 'mesocolumn'); ?> <?php echo $paged; ?><?php } ?><?php rewind_posts(); endif; ?><?php do_action('bp_inside_headline'); ?></h2>

<?php } else if ( is_archive() && get_post_type() == 'post' ) { ?>

<h2 class="inarchive effect-1 header-title">
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_day()) { ?>
<?php _e('Archives for', 'mesocolumn'); ?> <?php echo the_time( get_option( 'date_format' ) ); ?>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<?php _e('Archives for', 'mesocolumn'); ?> <?php echo the_time('F, Y'); ?>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<?php _e('Archives for', 'mesocolumn'); ?> <?php echo the_time('Y'); ?>
<?php } ?><?php if ( $paged >= 2 || $page >= 2 ) { ?> - <?php _e('Page', 'mesocolumn'); ?> <?php echo $paged; ?><?php } ?><?php do_action('bp_inside_headline'); ?></h2>

<?php } else if (is_single()) { ?>

<?php } else if (is_search()) { ?>

<h2 class="insearch effect-1 header-title"><?php _e('Search result for &quot;', 'mesocolumn'); ?> <?php the_search_query(); ?> <?php _e('&quot;', 'mesocolumn'); ?><?php if ( $paged >= 2 || $page >= 2 ) { ?> - <?php _e('Page', 'mesocolumn'); ?> <?php echo $paged; ?><?php } ?><?php do_action('bp_inside_headline'); ?></h2>

<?php } else { ?>

<h2 class="inposttype effect-1 header-title feat_tn_cat_color_<?php echo $cat_id; ?>"><?php _e('Archive for', 'mesocolumn'); ?> <?php echo $cat_name; ?><?php do_action('bp_inside_headline'); ?></h2>

<?php }
do_action('bp_after_headline');
?>