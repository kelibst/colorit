<?php
/**
 * The header for our theme
 */
?><!Doctype html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1.0, user-scalable=no" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<meta name="description" content="This is the official colorit site, we provide a range of services including, website designs, graphic designs and more. We aim to improve the gap that exist in the IT infrastructure Africa.">
	<?php wp_head(); ?>
</head>
<body class="grey lighten-5">
	<div id="up"></div>
	<div class="white-text">
		<nav class="teal darken-2">
			<div class="nav-wrapper container">


        <a class="brand-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?>      <?php 
$description = get_bloginfo( 'description', 'display' );?>
<?php if ( $description || is_customize_preview() ) : ?>
  <small class="hide-on-med-and-down" style="    position: relative;
    left:10px;
    font-size: 50%;
    font-family: Charmonman, cursive;
    float: right;"
  >
    <style>
    
    </style>
    
    <?php echo $description; ?></small>
<?php endif; ?></a>

        


				<a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
				<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_class'     => 'menu right',
							'menu_id' => 'mobile-nav',
							'items_wrap'     => '<ul id="%1$s" class="%2$s" tabindex="0">%3$s</ul>',
						)
					);
					?>
		</ul>

		<ul id="nav-mobile" class="sidenav">

					<?php
					wp_nav_menu(
						array(
							//fix dropdown menu issues by creating walker
							'theme_location' => 'menu-1',
							'menu_class'     => '',
							 'menu_id' => 'mobile-nav',
							'items_wrap'     => '<ul id="%1$s" class="%2$s" tabindex="0">%3$s</ul>',
						)
					);
					?>
			</ul>
				</div>
			</nav><!-- #site-navigation -->			


		</div>	
		<div class="clear"></div>

	<?php endif;?>
<?php if (is_front_page()):?>
	
<!-- slider insert -->

  <div class="slider">
    <ul class="slides">
      <li>
        <img src="<?php echo get_theme_mod('slider_img1', get_bloginfo('template_url').'/img/background1.jpg');?>"> <!-- random image -->
        <div class="caption center-align">
          <h3 class="big-tagline"><?php echo get_theme_mod('tagline1', 'This is our big Tagline!');?></h3>
          <h5 class="light grey-text text-lighten-3"><?php echo get_theme_mod('slogan1', 'Here\'s our small slogan!');?></h5>
        </div>
      </li>
      <li>
        <img src="<?php echo get_theme_mod('slider_img2', get_bloginfo('template_url').'/img/background2.jpg');?>"> <!-- random image -->
        <div class="caption left-align">
          <h3 class="big-tagline"><?php echo get_theme_mod('lalign', 'Left Aligned Caption');?></h3>
          <h5 class="light grey-text text-lighten-3"><?php echo get_theme_mod('slogan2', 'Here\'s our small slogan!');?></h5>
        </div>
      </li>
      <li>
        <img src="<?php echo get_theme_mod('slider_img3', get_bloginfo('template_url').'/img/background3.jpg');?>"> <!-- random image -->
        <div class="caption right-align">
          <h3 class="big-tagline"><?php echo get_theme_mod('ralign', 'Right Aligned Caption');?></h3>
          <h5 class="light grey-text text-lighten-3"><?php echo get_theme_mod('slogan3', 'Here\'s our small slogan!');?></h5>
        </div>
      </li>
      <li>
        <img src="<?php echo get_theme_mod('slider_img4', get_bloginfo('template_url').'/img/background5.jpg');?>"> <!-- random image -->
        <div class="caption center-align">
          <h3 class="big-tagline"><?php echo get_theme_mod('tagline2', 'This is our big Tagline!');?></h3>
          <h5 class="light grey-text text-lighten-3"><?php echo get_theme_mod('slogan4', 'Here\'s our small slogan!');?></h5>
        </div>
      </li>
    </ul>
  </div>

      <!--   Icon Section   -->
      <div class="row icon">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons"><?php echo get_theme_mod('icon1', 'flash_on');?></i></h2>
            <h5 class="center"><?php echo get_theme_mod('icon_head1', 'Speeds up development');?></h5>

            <p class="light"><?php echo get_theme_mod('icon_tarea1', 'Speeds up development');?></p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons"><?php echo get_theme_mod('icon2', 'group');?></i></h2>
            <h5 class="center"><h5 class="center"><?php echo get_theme_mod('icon_head2', 'User Experience Focused');?></h5>

            <p class="light"><?php echo get_theme_mod('icon_tarea2', 'Speeds up development');?></p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons"><?php echo get_theme_mod('icon3', 'settings');?>s</i></h2>
            <h5 class="center"><?php echo get_theme_mod('icon_head3', 'Easy to work with');?></h5>

            <p class="light"><?php echo get_theme_mod('icon_tarea3', 'Speeds up development');?></p>
          </div>
        </div>
      </div>

    </div>
  </div>
  <hr>

<div class="paddings container">
<?php else:?>


<!-- parallax side -->

<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container lighten-3 register">
        
        <br><br>
        <h1 class="header center teal-text text-lighten-2"><?php echo get_theme_mod('parahead1', 'Get online!!!');?></h1>
        <div class="row center">
          <h5 class="header col s12 "><?php echo get_theme_mod('parasubhead1', 'Let\'s get you online the professional way');?></h5>
        </div>
        
        <br><br>

      </div>
    </div>
    <div class="parallax"><img src="<?php echo get_theme_mod('parallax1', get_bloginfo('template_url').'/img/background5.jpg');?>" alt="Unsplashed background img 1"></div>
</div>

<div class="paddings container z-depth-2">
<?php endif; ?>



