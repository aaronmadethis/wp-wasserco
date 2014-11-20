<?php $page_name = get_the_title(); ?>

<div class="page_layout layout_two_up col-xs-12 <?php echo $page_name; ?>">
	<?php if( have_rows('boxes') ): ?>
		<div class="cta-wrapper clearfix">
			<?php while( have_rows('boxes') ): the_row(); ?>
				<div class="cta clearfix">
					<div class="image-holder">
						<?php
							$img_size = 'full';
							$img_id = get_sub_field('image');
							$image = wp_get_attachment_image_src( $img_id, $img_size );
						?>
						<a href="<?php the_sub_field('image_link'); ?>" style="background-image: url(<?php echo $image[0]; ?>);" target="_blank"></a>						
					</div>
					<div class="content">
						<h5><?php the_sub_field('title'); ?></h5>
						
						<span class="wyswyg">
							<?php the_sub_field('text'); ?>
						</span>

						<?php if ( the_sub_field('link_url') ) : ?>
							<a class="button" href="<?php the_sub_field('link_url'); ?>" target="_blank"><span></span><?php the_sub_field('link_name'); ?></a>
						<?php endif; ?>

					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>