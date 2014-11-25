<?php /* ---- front-page template ---- */ ?>
<?php get_header(); ?>

<section class="content-wrapper clearfix">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			
			<article <?php post_class("clearfix footer-spacing"); ?> >
				<?php amt_get_template_part('page', 'home'); ?>
			</article>

		<?php endwhile; ?>
	<?php endif; /*have_posts*/ ?>
</section>

<?php get_footer(); ?>