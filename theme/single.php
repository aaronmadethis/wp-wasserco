<?php /* ---- single page template ---- */ ?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class("clearfix footer-spacing"); ?>>

			<?php
				amt_get_template_part( 'single', get_post_type( $post->ID ) );
			?>

		</article>
	<?php endwhile; ?>
<?php endif; /*have_posts*/ ?>

<?php get_footer(); ?>