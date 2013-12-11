<!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.5, minimum-scale=0.5">
		<title><?php wp_title( 'by', true, 'right' ); bloginfo( 'name' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php echo get_bloginfo('template_directory'); ?>/images/favicon.ico" />
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php

			wp_enqueue_script('jquery');

			if ( is_singular() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			$options = get_option ( 'svbtle_options' ); 

			echo $options['google_analytics'];
 
			if( isset( $options['color'] ) && '' != $options['color'] )
				$color = $options['color'];
			else 
				$color = "#ff0000";
	
      wp_head();  
?>
	</head>
	<body <?php body_class(); ?>>



<div class="pure-g-r" id="layout">
    <div class="sidebar pure-u">
        <header class="header">
            <hgroup>
               <!-- <h2><a href="<?php echo home_url( '/' ); ?>"><?php echo $options['theme_username'] ?></a></h2> -->
                <h1 class="brand-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
                <h2 class="brand-tagline"><?php bloginfo( 'description' ); ?></h2>
            </hgroup>

            <nav class="nav">
                <ul class="nav-list">
            
            <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
          
            <?php if ($options['rss-link']): ?>
              <li class="link feed">
                  <a href="<?php bloginfo('rss_url'); ?>">feed</a>
              </li>		
            <?php endif ?>		

                    <li class="nav-item">
                        <a class="pure-button" href="http://purecss.io">Pure</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" href="http://yuilibrary.com">YUI Library</a>
                    </li>
                </ul>
            </nav>
        </header>
    </div>
    <div class="pure-u-1">
        <div class="content">
        
