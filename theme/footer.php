<footer>

	<section class="container">
		<div class="logo-wrapper clearfix">
			<a href="<?php echo home_url(); ?>"><div class="logo"></div></a>
		</div>

		<div class="col-xs-5 no-pad">
			<?php if(get_field('ny-address', 'option')): ?>
				<?php while(has_sub_field('ny-address', 'option')): ?>
					
					<div class="address" itemscope itemtype="http://schema.org/Organization">
						<p>
							<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress ">
								<span itemprop="streetAddress">
									<?php the_sub_field('street'); ?><br>
									<?php the_sub_field('floor'); ?><br>
								</span>
								<span itemprop="addressLocality"><?php the_sub_field('city'); ?></span> <span itemprop="addressRegion"><?php the_sub_field('state'); ?></span> <span itemprop="postalCode"><?php the_sub_field('zip-code'); ?></span>
							</span>
						</p>
						<p>
							Phone <span itemprop="telephone"><?php the_sub_field('phone'); ?></span><br>
							Fax <span itemprop="faxNumber"><?php the_sub_field('fax'); ?></span>
						</p>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php if(get_field('la-address', 'option')): ?>
				<?php while(has_sub_field('la-address', 'option')): ?>
					
					<div class="address" itemscope itemtype="http://schema.org/Organization">
						<p>
							<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress ">
								<span itemprop="streetAddress">
									<?php the_sub_field('street'); ?><br>
									<?php the_sub_field('floor'); ?><br>
								</span>
								<span itemprop="addressLocality"><?php the_sub_field('city'); ?></span> <span itemprop="addressRegion"><?php the_sub_field('state'); ?></span> <span itemprop="postalCode"><?php the_sub_field('zip-code'); ?></span>
							</span>
						</p>
						<p>
							Phone <span itemprop="telephone"><?php the_sub_field('phone'); ?></span><br>
							Fax <span itemprop="faxNumber"><?php the_sub_field('fax'); ?></span>
						</p>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>

		<div class="col-xs-7 mega-menu">
			<div class="column">
				<?php
				$args = array(
					'depth'       => 1,
					'sort_column' => 'menu_order, post_title',
					'menu_class'  => 'menu',
					'include'     => '5,7,34',
					'echo'        => true,
					'show_home'   => false,
				);

			 	wp_page_menu( $args );
			?>
			</div>
			<div class="column">
				<ul>
				<?php
					$args = array(
						'child_of'     => 24,
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
			<div class="column">
				<ul>
				<?php
					$args = array(
						'child_of'     => 26,
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

				<a href=""><div class="login">INVESTOR LOGIN</div></a>
			</div>
		</div>

	</section>

	<div class="copyright">
		<div class="container no-pad">
			<?php the_field('copyright', 'option'); ?>
		</div>
	</div>

</footer>

</div> <!-- end of all-wrapper -->
<?php wp_footer();?>
</body>
</html>