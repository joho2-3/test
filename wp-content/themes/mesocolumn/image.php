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

<div class="post-nav-archive post-nav-image" id="post-navigator-single">
<div class="alignleft"><?php previous_image_link( false, __( '&larr; Previous', 'mesocolumn' ) ); ?></div>
<div class="alignright"><?php next_image_link( false, __( 'Next &rarr;', 'mesocolumn' ) ); ?></div>
</div>

<?php do_action( 'bp_before_blog_post' ); ?>

<!-- POST START -->
<article <?php post_class('post-single image-attachment'); ?> id="post-<?php the_ID(); ?>">

<div class="post-top">
<h1 class="post-title entry-title"><?php the_title(); ?></h1>

<?php
$metadata = wp_get_attachment_metadata();
printf( __( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'mesocolumn' ),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height'],
									esc_url( get_permalink( $post->post_parent ) ),
									esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
									get_the_title( $post->post_parent )
								);
							?>
		  <?php edit_post_link( __( 'Edit', 'mesocolumn' ), '<span class="edit-link">', '</span>' ); ?>


</div>

<?php do_action( 'bp_before_post_content' ); ?>
<div class="post-content entry-content">

<?php
/**
 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
 */
$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
foreach ( $attachments as $k => $attachment ) :
	if ( $attachment->ID == $post->ID )
		break;
endforeach;

$k++;
// If there is more than 1 attachment in a gallery
if ( count( $attachments ) > 1 ) :
	if ( isset( $attachments[ $k ] ) ) :
		// get the URL of the next image attachment
		$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	else :
		// or get the URL of the first image attachment
		$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	endif;
else :
	// or, if there's only 1 image, get the URL of the image
	$next_attachment_url = wp_get_attachment_url();
endif;
?>
								<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'mesocolumn_attachment_size', array( 960, 960 ) );
								echo wp_get_attachment_image( $post->ID, $attachment_size );
								?></a>

								<?php if ( ! empty( $post->post_excerpt ) ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
								<?php endif; ?>



<?php the_content(); ?>
<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>

</div>
<?php do_action( 'bp_after_post_content' ); ?>

</article>
<!-- POST END -->

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
<?php get_sidebar(); ?>
<?php get_footer(); ?>