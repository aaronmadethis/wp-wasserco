<div class="page_layout layout_news_list col-xs-12">
	<?php
		$args = array( 'post_type' => 'wdo_news', 'posts_per_page' => 100 );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
	?>
		<div class="news-wrapper clearfix">
			<a href="<?php the_permalink(); ?>" class="icon col-xs-2"></a>
			<div class="content clearfix">
				<h4><?php the_date(); ?></h4>
				<h3><?php the_title(); ?></h3>
				<a class="button" href="<?php the_permalink(); ?>"><span></span>Read News</a>
			</div>
		</div>
	
	<?php endwhile;	?>
</div>
