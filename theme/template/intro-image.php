<?php
	$post_id = get_the_ID();
?>

<?php
	$img_size = 'full';
	$img_id = get_sub_field('image');
	$hero = wp_get_attachment_image_src( $img_id, $img_size );
?>

<div class="page_intro image_intro">
	<div class="container no-pad">
		<div class="page_top">
			<?php do_action('amt_create_breadcrumb', $post_ID); ?>
			<h1 class="title"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="top_image" style="background-image: url(<?php echo $hero[0]; ?>);"></div>

</div>