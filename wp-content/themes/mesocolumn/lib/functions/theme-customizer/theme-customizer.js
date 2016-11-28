/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	//Update site background color...
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {

        $('body').css('background-color', newval );

        $('.container-wrap').css({'float':'left','margin':'0','padding':'2% 2% 0 2%','width':'96%','background-color':'white' });

            $('footer .ftop').css({'float':'left','margin':'0','padding':'2% 2% 0 2%','width':'96%','background-color':'white' });
              $('#header').css('background-color','white');
              $('#siteinfo').css('margin', '0 0 0 1.6em');

          $('footer.footer-bottom').css('background-color', 'transparent');

        $('#custom .fbottom').css({ 'background-color':'#52C0D4','color':'#fff','width':'96%','margin':'0','padding': '0.6em 2%' });


		} );
	} );


  	//Update site global fonts in real time...
	wp.customize( 'body_font', function( value ) {
		value.bind( function( newval ) {

var val_strip = newval.replace(/ /g,"+");
var oLink = document.getElementById('google_body');
var gLink = '//fonts.googleapis.com/css?family='+ val_strip +'';
oLink.href = gLink;
       $('body').css('font-family', newval );
		} );
	} );


	wp.customize( 'body_font_weight', function( value ) {
		value.bind( function( newval ) {
       $('body').css('font-weight', newval );

		} );
	} );


  	wp.customize( 'headline_font', function( value ) {
		value.bind( function( newval ) {

       var val_strip = newval.replace(/ /g,"+");
var oLink = document.getElementById('google_headline');
var gLink = '//fonts.googleapis.com/css?family='+ val_strip +'';
oLink.href = gLink;

       $('h1,h2,h3,h4,h5,h6,.header-title,#main-navigation, #featured #featured-title, #cf .tinput, #wp-calendar caption,.flex-caption h1,#portfolio-filter li,.nivo-caption a.read-more,.form-submit #submit,.fbottom,ol.commentlist li div.comment-post-meta, .home-post span.post-category a,ul.tabbernav li a').css('font-family', newval );

		} );
	} );


	wp.customize( 'headline_font_weight', function( value ) {
		value.bind( function( newval ) {
       $('h1,h2,h3,h4,h5,h6,.header-title,#main-navigation, #featured #featured-title, #cf .tinput, #wp-calendar caption,.flex-caption h1,#portfolio-filter li,.nivo-caption a.read-more,.form-submit #submit,.fbottom,ol.commentlist li div.comment-post-meta, .home-post span.post-category a,ul.tabbernav li a').css('font-weight', newval );

		} );
       	} );

   	wp.customize( 'navigation_font', function( value ) {
		value.bind( function( newval ) {

    var val_strip = newval.replace(/ /g,"+");
var oLink = document.getElementById('google_nav');
var gLink = '//fonts.googleapis.com/css?family='+ val_strip +'';
oLink.href = gLink;

       $('#main-navigation a, .sf-menu li a').css('font-family', newval );

		} );
	} );

	wp.customize( 'navigation_font_weight', function( value ) {
		value.bind( function( newval ) {
       $('#main-navigation a, .sf-menu li a').css('font-weight', newval );

		} );
	} );

} )( jQuery );