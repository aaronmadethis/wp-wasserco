<div class="page_layout layout_history clearfix">
	<div class="col-xs-4 col-sm-3 col-md-2 left_image">
		<?php
			$img_size = 'full';
			$img_id = get_sub_field('image');
			$h_image = wp_get_attachment_image_src( $img_id, $img_size );
		?>
		<div class="image" style="background-image: url(<?php echo $h_image[0]; ?>);"></div>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-10 right_text">
		<h2><?php the_sub_field('title'); ?></h2>
		<div class="column">
			<?php the_sub_field('c_one'); ?>
		</div>
		<div class="column">
			<?php the_sub_field('c_two'); ?>
		</div>
	</div>
</div>