<?php /* ---- page template ---- */ ?>
<?php get_header(); ?>

<section class="content-wrapper clearfix">

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			if( have_rows('intro') ):

				// loop through the rows of data
				while ( have_rows('intro') ) : the_row();
					$layout = get_row_layout();
					amt_get_template_part('intro', $layout);
				endwhile;

			else :

				amt_get_template_part('intro', 'basic');

			endif;
			?>


			<article <?php post_class("container footer-spacing no-pad"); ?> >
				<?php
				// check if the flexible content field has rows of data
				if( have_rows('layout') ):
				 
					// loop through the rows of data
					while ( have_rows('layout') ) : the_row();
						$layout = get_row_layout();
						echo '<div class="layout-container row">';
						amt_get_template_part('layout', $layout);
						echo '</div>';
					endwhile;
				
				else :

					amt_get_template_part('layout', 'basic');	

				endif;
				?>
			</article>
		<?php endwhile; ?>
	<?php endif; /*have_posts*/ ?>
	

</section>

<?php get_footer(); ?>