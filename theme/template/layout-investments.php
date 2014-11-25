<div class="page_layout layout_investments col-xs-12">


	<?php
		$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'menu_order',
			'order'            => 'ASC',
			'post_type'        => 'wsc_investments',
			'post_status'      => 'publish',
			'suppress_filters' => true
			);
		$investments = get_posts( $args );
	?>


	<div class="current_investments clearfix">
		<h1 class="title">Current Investments</h1>

		<?php foreach ($investments as $key => $investment):  setup_postdata( $GLOBALS['post'] =& $investment );	?>
			<?php 
			$current = get_field('current');
			if($current == 'current'): ?>
				<div class="investment_box current_investment investment_<?php the_ID(); ?> <?php echo $investment->post_name; ?>">
					<div class="inside">
						<?php
						$img_size = 'investment_logo';
						$img_id = get_field('logo');
						$image = wp_get_attachment_image_src( $img_id, $img_size );
						?>
						<div class="logo"><span style="background-image:url(<?php echo $image[0]; ?>);"></span></div>
						<div class="content">
							<h3 class="title"><?php the_title(); ?></h3>
							<?php if(get_field('fund')): ?>
								<h5><?php the_field('fund'); ?></h5>
							<?php endif; ?>
							<?php if(get_field('initial_investment')): ?>
								<h5>Initial Investment: <?php the_field('initial_investment'); ?></h5>
							<?php endif; ?>
							<?php if(get_field('exit')): ?>
								<h5>Exit: <?php the_field('exit'); ?></h5>
							<?php endif; ?>
							<p><?php the_field('intro'); ?></p>
							<a class="button open_overlay" href="#" data-post-id="<?php the_ID(); ?>"><span></span>Learn More</a>
						</div>
					</div>
				</div>
			<?php endif; ?>
 		<?php endforeach;
		wp_reset_postdata(); ?>
	</div>
	<div class="past_investments clearfix">
		<h1 class="title">Past Investments</h1>
		<p>A selection of past investments</p>

		<?php foreach ($investments as $key => $past):  setup_postdata( $GLOBALS['post'] =& $past );	?>
			<?php 
			$current = get_field('current');
			if($current == 'past'): ?>
				<div class="investment_box past_investment investment_<?php the_ID(); ?> <?php echo $past->post_name; ?>">
					<div class="inside">
						<?php
						$img_size = 'investment_logo';
						$img_id = get_field('logo');
						$image = wp_get_attachment_image_src( $img_id, $img_size );
						?>
						<a class="open_overlay" href="#" data-post-id="<?php the_ID(); ?>">
							<div class="logo"><span style="background-image:url(<?php echo $image[0]; ?>);"></span></div>
							<h3 class="title"><?php the_title(); ?></h3>
						</a>
						<?php if(get_field('initial_investment')): ?>
							<h5>Initial Investment: <?php the_field('initial_investment'); ?></h5>
						<?php endif; ?>
						<?php if(get_field('exit')): ?>
							<h5>Exit: <?php the_field('exit'); ?></h5>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
 		<?php endforeach;
		wp_reset_postdata(); ?>
	</div>
</div>