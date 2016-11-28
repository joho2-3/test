<?php get_header();
$featcat1 = get_theme_mod('side_feat_cat1');
$featcat2 = get_theme_mod('side_feat_cat2');
$featcat3 = get_theme_mod('side_feat_cat3');
$featcat4 = get_theme_mod('side_feat_cat4');
$featcat5 = get_theme_mod('side_feat_cat5');
$featcat6 = get_theme_mod('side_feat_cat6');
$featcat7 = get_theme_mod('side_feat_cat7');
$featcat8 = get_theme_mod('side_feat_cat8');
$featcat9 = get_theme_mod('side_feat_cat9');
$featcat10 = get_theme_mod('side_feat_cat10');
?>

<?php do_action( 'bp_before_content' ); ?>

<!-- CONTENT START -->
<div class="content">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ); ?>

<!-- POST ENTRY START -->
<div id="post-entry">

<div class="post-entry-inner">

<?php do_action( 'bp_before_blog_entry' ); ?>

<?php if( ($featcat1 == '' && $featcat2 == '' && $featcat3 == '' && $featcat4 == '' && $featcat5 == '' && $featcat6 == '' && $featcat7 == '' && $featcat8 == '' && $featcat9 == '' && $featcat10 == '') || ($featcat1 == 'Choose a category' && $featcat2 == 'Choose a category' && $featcat3 == 'Choose a category' && $featcat4 == 'Choose a category' && $featcat5 == 'Choose a category' && $featcat6 == 'Choose a category' && $featcat7 == 'Choose a category' && $featcat8 == 'Choose a category' && $featcat9 == 'Choose a category' && $featcat10 == 'Choose a category') ): ?>

<?php do_action( 'bp_before_post_query' ); ?>

<?php get_template_part( 'content' ); ?>

<?php do_action( 'bp_after_post_query' ); ?>

<?php get_template_part( 'lib/templates/paginate' ); ?>

<?php else: // if homepage featured category active ?>

<?php get_template_part( 'lib/templates/home-feat-cat' ); ?>

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