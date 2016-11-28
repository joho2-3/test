<?php get_header();
$cat_id = get_queried_object()->term_id;
?>

<?php do_action( 'bp_before_content' ) ?>

<!-- CONTENT START -->
<div class="content">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ) ?>

<!-- POST ENTRY START -->
<div id="post-entry" class="archive_tn_cat_color_<?php echo $cat_id; ?>">
<div class="post-entry-inner">

<?php do_action( 'bp_before_blog_entry' ); ?>

<?php get_template_part( 'content' ); ?>

<?php get_template_part( 'lib/templates/paginate' ); ?>

<?php do_action( 'bp_after_blog_entry' ); ?>

</div>
</div>
<!-- POST ENTRY END -->

<?php do_action( 'bp_after_blog_home' ) ?>

</div><!-- CONTENT INNER END -->
</div><!-- CONTENT END -->

<?php do_action( 'bp_after_content' ) ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>