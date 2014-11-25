<div class="page_layout layout_tabs col-xs-12">
	<?php if( have_rows('tabs') ): ?>
		
		<div class="tab_nav col-xs-12">

			<?php $loop_count = 1; ?>
			<?php while( have_rows('tabs') ): the_row(); ?>
			
				<span class="tab_menu <?php if($loop_count == 1 ) echo 'active'; ?>">
					<a href="#"><?php the_sub_field('tab_title') ?></a>
				</span>
				<?php $loop_count++; ?>
			
			<?php endwhile; ?>
			<span class="helper">Select a sector to learn more</span>
		</div>

		<div class="tabs-wrapper col-xs-12 transition-2">

			<div class="tabs clearfix transition-2">
				<?php $loop_count = 1; ?>
				<?php while( have_rows('tabs') ): the_row(); ?>
					
					<div class="single_tab clearfix <?php if($loop_count == 1 ) echo 'active'; ?>">
						<div class="tab_content col-xs-12 col-sm-8 col-md-9">
							<h3><?php the_sub_field('tab_title') ?></h3>
							<span class="wyswyg"><?php the_sub_field('tab_text') ?></span>
						</div>

						<?php if( have_rows('bullets') ): ?>
							<ul class="tab_bullets col-xs-12 col-sm-4 col-md-3">
								<?php while( have_rows('bullets') ): the_row(); ?>
									<li>
										<h4><?php the_sub_field('bullet_title') ?></h4>
										<p><?php the_sub_field('bullet_text') ?></p>
									</li>
								<?php endwhile; ?>
							</ul>
						<?php endif; ?>

					</div>
					<?php $loop_count++; ?>

				<?php endwhile; ?>
			</div>
		</div>

	<?php endif; ?>
</div>