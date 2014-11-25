<div class="page_layout layout_standard_image col-xs-12">
	<div class="col-xs-8 image">
		<?php
			$img_size = 'full';
			$img_id = get_sub_field('h_image');
			$image = wp_get_attachment_image_src( $t_img_id, 'standard_lg' );
		?>
		<div class="full_w full_image" style="background-image: url(<?php echo $t_image[0]; ?>);"></div>
	</div>
	<div class="col-xs-4 "></div>
</div>