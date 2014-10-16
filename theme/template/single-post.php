<?php /* ---- single post template ---- */  ?>

<div class="single_post">
	<?php //** Do Hook Single content
		do_action('amt_interface_single_content'); 
		echo get_post_type( $post->ID );
	?>
</div>