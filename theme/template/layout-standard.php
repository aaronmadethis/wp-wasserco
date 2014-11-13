<div class="page_layout layout_standard col-xs-12">
	<div class="col-xs-8 left_text">
		<?php the_sub_field('text'); ?>
	</div>
	<div class="col-xs-4 right_images">
		<?php
			$img_size = 'full';
			$t_img_id = get_sub_field('h_image');
			$t_image = wp_get_attachment_image_src( $t_img_id, 'standard_lg' );
			$t_data = get_media_attachment($t_img_id);
			$b_img_id = get_sub_field('v_image');
			$b_image = wp_get_attachment_image_src( $b_img_id, 'standard_lg' );
			$b_data = get_media_attachment($b_img_id);
		?>
		<div class="cap_box clearfix box1">

			<div class="h_image" style="background-image: url(<?php echo $t_image[0]; ?>);">
				<?php if($t_data['caption']) : ?>
					<div class="h_caption caption"><?php echo $t_data['caption']; ?></div>
				<?php endif; ?>
			</div>

			<div class="color_block"><span></span></div>

		</div>
		<div class="cap_box clearfix box2">

			<div class="color_block"><span></span></div>

			<div class="h_image" style="background-image: url(<?php echo $b_image[0]; ?>);">
				<?php if($b_data['caption']) : ?>
					<div class="h_caption caption"><?php echo $b_data['caption']; ?></div>
				<?php endif; ?>
			</div>
			
		</div>
	</div>
</div>