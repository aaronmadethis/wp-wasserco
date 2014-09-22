<?php
	$post_id = get_the_ID();
?>

<?php
	$img_size = 'full';
	$img_id = get_field('intro_image');
	$hero = wp_get_attachment_image_src( $img_id, $img_size );
?>

<div class="hero">
	<div class="image" style="background-image: url(<?php echo $hero[0]; ?>);">
		<div class="triangle"></div>
	</div>
</div>
<div class="hero-cta">
	<h3><?php the_field('intro_text'); ?></h3>
	<a class="button" href="">
		<span></span>Learn about us
	</a>
</div>
<div class="gate clearfix">
	<div class="top"></div>
	<div class="container">
		<div class="cta-wrapper clearfix">
			<div class="cta">
				<div class="tree"></div>
				
				<h4>Wasserstein Partners</h4>
				<h3>Private Equity</h3>
				
				<a class="button" href="">
					<span></span>Learn More
				</a>
			</div>
			<div class="cta">
				<div class="tree"></div>
				
				<h4>Wasserstein Debt Opportunities</h4>
				<h3>Credit Fund</h3>
				
				<a class="button" href="">
					<span></span>Learn More
				</a>
			</div>
		</div>
		
	</div>
</div>