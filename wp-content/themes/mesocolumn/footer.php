</div><!-- CONTAINER WRAP END -->
<?php do_action( 'bp_after_container_wrap' ); ?>

</div><!-- CONTAINER END -->
<?php do_action( 'bp_after_container' ); ?>

</div><!-- BODYCONTENT END -->
<?php do_action( 'bp_after_bodycontent' ); ?>

</div><!-- INNERWRAP BODYWRAP END -->
<?php do_action( 'bp_after_bodywrap' ); ?>

</div><!-- WRAPPER MAIN END -->
<?php do_action( 'bp_after_wrapper_main' ); ?>

</div><!-- WRAPPER END -->
<?php do_action( 'bp_after_wrapper' ); ?>

<?php do_action( 'bp_before_footer_bottom' ); ?>

<footer class="footer-bottom"<?php do_action('bp_section_footer'); ?>>
<div class="innerwrap">
<div class="fbottom">
<div class="footer-left">
<?php do_action( 'bp_footer_left' ); ?>
</div>
<div class="footer-right">
<?php do_action( 'bp_footer_right' ); ?>
</div>
</div>
</div>
</footer>
<!-- FOOTER BOTTOM END -->

<?php do_action( 'bp_after_footer_bottom' ); ?>

</div>
<!-- SECBODY END -->

<?php wp_footer(); ?>

</body>

</html>