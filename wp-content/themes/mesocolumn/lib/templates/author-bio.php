<?php if ( get_the_author_meta( 'description' ) ) : ?>
<div id="author-bio">
<div id="author-avatar">
<?php echo get_avatar( get_the_author_meta( 'user_email' ), 68 ); ?>
</div><!-- #author-avatar -->
<div id="author-description">
<h2><?php printf( __( 'About %s', 'mesocolumn' ), get_the_author() ); ?></h2>
<?php the_author_meta( 'description' ); ?>
<div id="author-link">
<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'mesocolumn' ), get_the_author() ); ?>
</a>
</div><!-- #author-link	-->
</div><!-- #author-description -->
</div><!-- #author-info -->
<?php endif; ?>