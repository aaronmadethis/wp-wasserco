<?php
	/* ----- Navigation Template ----- */
	$theme_dir_path = get_stylesheet_directory_uri();
?>
<header class="col-xs-12">
	<div class="container">

		<a href="<?php echo home_url(); ?>"><div class="logo"></div></a>

		<nav class="desktop">
			<?php
				$defaults = array(
					'depth'       => 2,
					'menu_class'  => 'menu',
					'include'     => '',
					'exclude'     => '',
					'echo'        => true,
					'link_before' => '<span>',
					'link_after'  => '</span>' 
				);

			 	wp_nav_menu( $defaults );
			?>
		</nav>

		<a href="#" class="open-nav-menu">Menu</a>

		<a href="https://investor.wasserco.com/EPrivateEquityPEO-Wasserco/Utility/EWebLPLogin.aspx" target="_blank"><div class="login">INVESTOR LOGIN</div></a>
	</div>
</header>

<nav class="mobile transition-2">
	<a href="#" class="close-nav-menu">CLOSE</a>
	<?php
		$defaults = array(
			'depth'       => 2,
			'menu_class'  => 'menu',
			'include'     => '',
			'exclude'     => '',
			'echo'        => true,
			'link_before' => '<span>',
			'link_after'  => '</span>' 
		);

	 	wp_nav_menu( $defaults );
	?>
</nav>