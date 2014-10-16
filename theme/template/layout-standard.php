<div class="page_layout layout_standard col-xs-12">
	<div class="col-xs-8 left_text">
		<?php the_sub_field('text'); ?>
	</div>
	<div class="col-xs-4 right_images">
		<?php
			$img_size = 'full';
			$h_img_id = get_sub_field('h_image');
			$h_image = wp_get_attachment_image_src( $h_img_id, $img_size );
			$v_img_id = get_sub_field('v_image');
			$v_image = wp_get_attachment_image_src( $v_img_id, $img_size );
		?>
		<div class="h_image" style="background-image: url(<?php echo $h_image[0]; ?>);"></div>
		<div class="v_image" style="background-image: url(<?php echo $v_image[0]; ?>);"></div>
		<div class="color_block"><span></span></div>
	</div>
</div>