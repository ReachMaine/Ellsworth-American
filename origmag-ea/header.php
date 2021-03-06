<?php /*
	Mods:
  4Dec2020 - removed ancient history
	         - put technavia login back on homepage
*/
global $theme_url, $prl_data; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home('', 'https') || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'PressLayer' ), max( $paged, $page ) );
	?></title>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php if($prl_data['site_fav']!='') {?>
	<link rel="shortcut icon" href="<?php echo trim($prl_data['site_fav']);?>">
	<?php } ?>

<?php/* link href="https://fonts.googleapis.com/css?family=Vollkorn:400,400i,700,700i" rel="stylesheet"> */ ?>
<link href="https://fonts.googleapis.com/css?family=Archivo+Narrow|Vollkorn:400,700&display=swap" rel="stylesheet">
<script data-cfasync="false" type="text/javascript" src="//cdn.broadstreetads.com/init.js"></script>
<?php
	if (!is_singular('post') ) { 	?>
		<script data-cfasync="false" type="text/javascript" >var ta_cat = "not_post"; </script>
	<?php }  ?>
	<?php /* only add  paywall scripts on single posts  */
	if ( is_singular('post') && !is_user_logged_in()  ) { ?>
   <script data-cfasync="false" type="text/javascript" src="//ellsworthamerican-me-pw.newsmemory.com/?meter&amp;service=onstop&amp;v=0"></script>
 <?php } ?>

<?php wp_head();?>
	<?php if ( is_home() || is_front_page() )  { ?>
    	<meta http-equiv='Cache-Control' content='no-cache'>
    <?php }  ?>
	<?php /* zig 17Mar15 trying to add meta name=thumbnail to post */
		if (is_single() || is_page() ) {
			global $post;
			$image_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
			echo '<!-- is single -->';
			if ($image_thumbnail) {
				echo '<meta name="thumbnail" content="'.$image_thumbnail[0].'">';
			} else {
				echo '<meta name="thumbnail" content="https://www.ellsworthamerican.com/wp-content/themes/origmag-ea/images/ogi-ea.jpg">';
				echo '<meta property="og:image" content="https://www.ellsworthamerican.com/wp-content/themes/origmag-ea/images/ogi-ea.jpg">';
			}
		}
	?>

</head>
<?php
$body_class = array('Boxed'=>'site-boxed', 'Wide'=>'site-wide');
?>
<body <?php body_class($body_class[$prl_data['site_style']]); ?>>
<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
<?php /* 29Aug16 zig - put technavia script here....*/
 			/* 28Aug19 zig - but only if single post */
			/* 4Dec20 zig - put back on */
			if ( !is_user_logged_in() ) { ?>
				<script data-cfasync="false" type="text/javascript" src="//ellsworthamerican-me-pw.newsmemory.com/?meter&amp;v=0"></script>
			<?php } ?>
<div id="topbar"><?php if ( is_active_sidebar( 'topbar') ) { 	dynamic_sidebar( 'topbar' );	}  ?></div>
<div class="site-wrapper">
    <!--<div class="prl-container">-->

		<header id="masthead" class="clearfix">
			<div class="prl-container">
				<?php /* search box moved to top  hidden at tablet size*/ ?>
				<?php if($prl_data['header_search_btn']!='Disable'):?>
				<div class="prl-nav-flip-top hidden-tablet">
					<?php /*  <div class="right"><a href="#" id="search_btn" class="prl-nav-toggle prl-nav-toggle-search search_zoom" title="Search"></a></div> */ ?>

					<div id="search_form-top" class="nav_search">
						<form class="prl-search" action="<?php echo home_url(''/* , 'https' */);?>">
							<input type="text" id="s" name="s" value="" placeholder="&#xF002;" class="nav_search_input" />
							<?php /* <input type="text" id="s" name="s" value="" placeholder="<?php _e('Search ...','presslayer');?>" class="nav_search_input" /> */ ?>
						</form>
					</div>

				</div>
				<?php endif;?>
				<?php /* add top nav menu  - added by zig */ ?>
				<nav id="topnav" class="hidden-tablet">
					<div class="nav-wrapper clearfix">
					<?php if ( has_nav_menu( 'top_nav' ) ) :
						wp_nav_menu( array (
							'theme_location' => 'top_nav',
							'container' => false,
							'menu_class' => 'sf-menu eai-menu',
							'menu_id' => 'top-menu',
							'depth' => 2,
							'fallback_cb' => false) );
					endif; ?>
					</div>
				</nav>

			</div> <?php /* end pr1-container for top menu & search */ ?>
			<div class="prl-container top-header">
				<div class="masthead-bg clearfix">
				<div class="prl-header-logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo sitelogo();?>" alt="<?php bloginfo('name'); ?>" /></a>
				</div>
				<div class="prl-header-mid">
					<?php  if($prl_data['header_custom_text']!=''){?>
					<span class="prl-header-custom-text"><?php echo trim($prl_data['header_custom_text']);?></span>
					<?php  } if($prl_data['header_time']!='Disable'){   ?>
					<span class="prl-header-time"><a href="https://www.downeastmaine.com/calendar/events/today/"><i class="fa fa-calendar"></i><?php echo date('l');?> - <?php echo date('M d, Y');?></a></span>
					<?php } ?>
					<?php  echo eai_technav_loginmenu();   ?>
				</div>
				<div class="prl-header-social">
					<?php if($prl_data['header_facebook']!=''){?><a href="<?php echo $prl_data['header_facebook'];?>" class="fa fa-facebook" title="Facebook" target="_blank"></a><?php }?>
					<?php if($prl_data['header_twitter']!=''){?><a href="https://twitter.com/<?php echo $prl_data['header_twitter'];?>" class="fa fa-twitter" title="Twitter" target="_blank"></a><?php }?>
					<?php if($prl_data['header_pinterest']!=''){?><a href="https://www.pinterest.com/<?php echo $prl_data['header_pinterest'];?>" class="fa fa-pinterest" title="Pinterest" target="_blank"></a><?php }?>
					<?php if($prl_data['header_google_plus']!=''){?><a href="<?php echo $prl_data['header_google_plus'];?>" class="fa fa-google-plus" title="Google plus"></a><?php }?>
					<?php if($prl_data['header_linkedin']!=''){?><a href="<?php echo $prl_data['header_linkedin'];?>" class="fa fa-linkedin" title="LinkedIn"></a><?php }?>
                    <?php if($prl_data['header_instagram']!=''){?><a href="<?php echo $prl_data['header_instagram'];?>" class="fa fa-instagram" title="Instagram"></a><?php }?>
                    <?php if($prl_data['header_youtube']!=''){?><a href="<?php echo $prl_data['header_youtube'];?>" class="youtube-pic" title="Youtube"><img src="<?php echo get_stylesheet_directory_uri().'/images/youtube.jpg'; ?>"></a><?php }?>
				</div><!-- end of header social -->
			 </div>
			</div>
		</header>
		<nav id="nav" class="prl-navbar" role="navigation">
			<div class="prl-container">
				<div class="nav-wrapper clearfix centered-menu">
				<?php
				// Main Menu
				if ( has_nav_menu( 'main_nav' ) ) :

					$args = array (
						'theme_location' => 'main_nav',
						'container' => false,
						'container_class' => 'prl-navbar',
						'menu_class' => 'sf-menu',
						'menu_id' => 'sf-menu',
						'depth' => 4,
						'fallback_cb' => false

					 );
					if($prl_data['megamenu']!='Disable'):
						$mega = array ('walker' => new TMMenu());
						$args = array_merge($mega, $args);
					endif;
					wp_nav_menu($args);
				 else:
					echo '<div class="message warning"><i class="icon-warning-sign"></i>' . __( 'Define your site main menu', 'presslayer' ) . '</div>';
				 endif;

				?>

				<div class="nav_menu_control"><a href="#" data-prl-offcanvas="{target:'#offcanvas'}"><span class="prl-nav-toggle prl-nav-menu"></span><span class="nav_menu_control_text"><?php _e('','presslayer');?></span></a>
				</div>
				<?php if($prl_data['header_search_btn']!='Disable'):?>
				<div class="prl-nav-flip show-tablet">
					<?php /*  <div class="right"><a href="#" id="search_btn" class="prl-nav-toggle prl-nav-toggle-search search_zoom" title="Search"></a></div> */ ?>

					<div id="search_form" class="nav_search show-tablet">
						<form class="prl-search" action="<?php echo home_url(''/*, 'https'*/);?>">
							<input type="text" id="s" name="s" value="" placeholder="&#xF002;" class="nav_search_input" />
							<?php /* <input type="text" id="s" name="s" value="" placeholder="<?php _e('Search ...','presslayer');?>" class="nav_search_input" /> */ ?>
						</form>
					</div>

				</div>
				<?php endif;?>

				</div>
			</div>
		</nav>

		<script>
			var $ = jQuery.noConflict();
			$(document).ready(function() {
				var example = $('#sf-menu').superfish({
					delay:       100,
					animation:   {opacity:'show',height:'show'},
					dropShadows: false,
					autoArrows:  false
				});
			});

		</script>

    <!--</div>-->
	<?php $offstr = get_template_directory().'/offcanvas.php'; require_once ($offstr);?>
