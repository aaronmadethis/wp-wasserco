<div class="page_layout layout_team_module col-xs-12">
	<div class="team_menu col-xs-3 col-md-3 col-lg-3">
		<h4>Select a Team Member</h4>
	<?php
		$team = get_sub_field('select_team');

		$members = array();

		$cat_args = array(
			'orderby'                  => 'term_order',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'taxonomy'                 => 'position'
			); 
		$cats = get_categories( $cat_args );
		//print_r($cats);

		echo "<ul>";
		$active = 1;
		foreach ($cats as $key => $category) {
		$args = array(
				'posts_per_page'   => -1,
				'tax_query' => array(
				        array(
				        'taxonomy' => 'position',
				        'field' => 'cat_ID',
				        'terms' => $category->term_id
				        )
					),
				'meta_key' => 'last_name',
				'orderby'          => 'meta_value',
				'order'            => 'ASC',
				'post_type'        => 'wsc_team',
				'post_status'      => 'publish',
				'suppress_filters' => true
				);

			$posts_array = get_posts( $args );
			
			if($posts_array){
				$loop_count = 1;
				foreach ($posts_array as $key => $member) {
					$group = get_field('group', $member->ID);
					if($team == $group){
						if($loop_count == 1) echo "<li class='position'>" . $category->description . "</li>";
						if($active == 9999){
							$active = 'active';
						}else{
							$active = ' ';
						}

						$members[] = $member;
						echo "<li class='member_name member_" . $member->ID . " " . $active . "' data-id='member_" . $member->ID . "' ><a href='#'>" . $member->post_title . "</a></li>";
						$loop_count++;
					}
				 }
			}
		}
		echo "</ul>";
	?>
	</div>
	<div class="team_members col-xs-9 col-md-9 col-lg-9">
		<ul class="members-wrap">
			<?php $loop_count = 1; ?>
			<?php foreach ($members as $key => $member):  setup_postdata( $GLOBALS['post'] =& $member );	?>

				<li class="single-member member_<?php the_ID(); if($loop_count == 9999){ echo ' active';}?>">
					<?php
					$img_size = 'team_bio';
					$img_id = get_field('portrait');
					$image = wp_get_attachment_image_src( $img_id, $img_size );
					?>
					<img src="<?php echo $image[0]; ?>">
					<h1 class="name"><?php the_title(); ?></h1><br>
					<h2 class="position">
						<?php
						$terms = get_terms('position', array('include' => get_field('position')) );
						echo $terms[0]->name;
						?>
					</h2><br>
					<span class="wyswyg"><?php the_field('bio'); ?></span>
				</li>
				<?php $loop_count++; ?>
			<?php endforeach;
			wp_reset_postdata(); ?>
		</ul>
	</div>

</div>