<!DOCTYPE html>
<!--[if lt IE 7 ]>	<html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>		<html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>		<html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>		<html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) { echo '<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">'; } ?>

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes">
<meta name="HandheldFriendly" content="true">

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> id="custom">

<div class="product-with-desc secbody"<?php if( function_exists('is_in_woocommerce_page') && is_in_woocommerce_page() ) { ?><?php echo ' id="woo-wrapper"'; ?><?php } ?>>

<?php do_action( 'bp_before_wrapper' ); ?>
<div id="wrapper">

<?php do_action( 'bp_before_wrapper_main' ); ?>
<div id="wrapper-main">

<?php do_action( 'bp_before_bodywrap' ); ?>
<div id="bodywrap" class="innerwrap">

<?php do_action( 'bp_before_bodycontent' ); ?>
<div id="bodycontent">

<?php do_action( 'bp_before_container' ); ?>
<div id="container">

<?php do_action( 'bp_before_container_wrap' ); ?>
<div class="container-wrap">

<?php do_action( 'bp_inside_container_wrap' ); ?>