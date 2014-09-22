<?php
	/* ----- Navigation Template ----- */
	$theme_dir_path = get_stylesheet_directory_uri();
?>
<header class="col-xs-12">
	<div class="container">

		<a href="<?php echo home_url(); ?>"><div class="logo"></div></a>

		<nav class="desktop">
			<?php
				$args = array(
					'depth'       => 2,
					'sort_column' => 'menu_order, post_title',
					'menu_class'  => 'menu',
					'include'     => '',
					'exclude'     => '',
					'echo'        => true,
					'show_home'   => false,

					'link_before' => '<span>',
					'link_after'  => '</span>' 
				);

			 	wp_page_menu( $args );
			?>
		</nav>

		<a href=""><div class="login">INVESTOR LOGIN</div></a>
	</div>
</header>


