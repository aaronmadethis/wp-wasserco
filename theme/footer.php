<footer>

	<div class="copyright">
		<div class="container no-pad">
			<?php the_field('copyright', 'option'); ?>
		</div>
	</div>

</footer>

<?php if($GLOBALS['include_overlay']): ?>
	<div id="overlay-wrapper" class="myinvisible">
		<div class="overlay-fill"></div>
		<div class="preloader_png"></div>
		<div id="overlay-container" class="myhide container">
			<div class="bg-white col-xs-12">
				<div class="close-wrapper">
					<div class="overlay-close"><a href="">CLOSE<span></span></a></div>
				</div>
				<div class="content-wrapper">
					<div class="images">
						<div class="logo-wrapper"><div class="logo"></div></div>
						<div class="secondary"></div>
						<div class="primary"></div>
					</div>
					<div class="content">
						<h3 class="title"></h3>
						<div class="text wyswyg"></div>
						<a class="button" href="" target="_blank"><span></span>Learn More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

</div> <!-- end of all-wrapper -->
<?php wp_footer();?>
</body>
</html>