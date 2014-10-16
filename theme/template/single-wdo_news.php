<?php /* ---- single news template ---- */  ?>

<div class="page_intro light_gray intro_basic">

	<div class="container no-pad">
		<div class="page_top">
			<?php do_action('amt_create_breadcrumb', $post_ID); ?>
			<h1 class="title"><?php the_title(); ?></h1>
		</div>
	</div>

</div>

<div class="single_news container no-pad">
	<div class="col-xs-12">
		<span class="wyswyg"><?php the_content(); ?></span>
	</div>
</div>
