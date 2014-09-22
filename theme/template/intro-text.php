<div class="page_intro text_intro">
	<div class="container no-pad">
		<div class="page_top">
			<?php do_action('amt_create_breadcrumb', $post_ID); ?>
			<h1 class="title"><?php the_title(); ?></h1>
			<p>
				<?php the_sub_field('text'); ?>
			</p>
		</div>
	</div>
</div>