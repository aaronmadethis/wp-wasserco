<footer>

	<?php if(is_front_page() || is_home() ): ?>

	<?php else : ?>
		<section class="container">
			<div class="row mega-menu">
				<div class="logo-wrapper col-xs-4">
					<a href="<?php echo home_url(); ?>"><div class="logo"></div></a>
				</div>
				<div class="col-xs-5 wasserco_p">
					<div class="inside">
						<h1>Wasserstein Partners</h1>
						<ul>
							<?php
									$args = array(
									'include'     => 10,
									'depth'        => 0,
									'echo'         => 1,
									'post_type'    => 'page',
									'post_status'  => 'publish',
									'sort_column'  => 'menu_order, post_title',
								    'sort_order'   => '',
								    'title_li'     => __(''), 
								);
								wp_list_pages( $args );
							?>
							<?php
								$args = array(
									'child_of'     => 10,
									'depth'        => 0,
									'echo'         => 1,
									'post_type'    => 'page',
									'post_status'  => 'publish',
									'sort_column'  => 'menu_order, post_title',
								    'sort_order'   => '',
								    'title_li'     => __(''), 
								);
								wp_list_pages( $args );
							?>
						</ul>
					</div>
				</div>

				<div class="col-xs-3 wasserco_do">
					<div class="inside">
						<h1>Wasserstein Debt Opportunities</h1>
						<ul>
							<?php
									$args = array(
									'include'     => 28,
									'depth'        => 0,
									'echo'         => 1,
									'post_type'    => 'page',
									'post_status'  => 'publish',
									'sort_column'  => 'menu_order, post_title',
								    'sort_order'   => '',
								    'title_li'     => __(''), 
								);
								wp_list_pages( $args );
							?>
							<?php
								$args = array(
									'child_of'     => 28,
									'depth'        => 0,
									'echo'         => 1,
									'post_type'    => 'page',
									'post_status'  => 'publish',
									'sort_column'  => 'menu_order, post_title',
								    'sort_order'   => '',
								    'title_li'     => __(''), 
								);
								wp_list_pages( $args );
							?>
						</ul>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>


	<div class="copyright">
		<div class="container no-pad">
			<?php the_field('copyright', 'option'); ?>&nbsp; | &nbsp;<span><a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Disclaimer' ) ) ); ?>">Terms of Use</a></span>
		</div>
	</div>

</footer>

<?php if($GLOBALS['include_overlay']): ?>
	<div id="overlay-wrapper" class="myinvisible">
		<div class="overlay-fill"></div>
		<div class="preloader_png"></div>
		<div id="overlay-container" class="myhide container">
			<div class="bg-white col-xs-12">
				<div class="close-wrapper">
					<div class="overlay-close"><a href="">CLOSE<span></span></a></div>
				</div>
				<div class="content-wrapper">
					<div class="images">
						<div class="logo-wrapper"><div class="logo"></div></div>
						<div class="secondary"></div>
						<div class="primary"></div>
					</div>
					<div class="content">
						<h3 class="title"></h3>
						<div class="text wyswyg"></div>
						<a class="button" href="" target="_blank"><span></span>Learn More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

</div> <!-- end of all-wrapper -->
<?php wp_footer();?>
</body>
</html>