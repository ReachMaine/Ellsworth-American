<?php 
/* template mods:
special archive display for the living category s.t. we can
* 25Mar15 - had wrong category id for _stickit search, now use slug.
* 21Aug15 zig - change spec_cat2 to dvd reviews (was blogs)
*/
	global $pl_data, $theme_url;

	if (have_posts()) :?>	 	
		<h3 class="prl-archive-title"><?php single_cat_title(); ?></h3>

		<?php 
		// get current page we are on. If not set we can assume we are on page 1.
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		// are we on page one?
		if(1 == $paged) {
			/* on the first page use special styling for living */
			$displayed = array();
			$catobj = get_category_by_slug('living');
			$category = $catobj->term_id;  // living category
			/* $category = 94;     // living category */
			$spec_cat1 = 431;   // weddings & engagements;
			/* $spec_cat2 = 376;  // blogs */
			$spec_cat2 = 1012;  // dvd reviews 
			$spec_cat3 = 418;    // auto revies
			$nopost_cat = 1013;  // tvlistings 

			/* build the special category blocks the ids of the special category */
			$recent_post1 = new WP_Query(array('post_type' => 'post','showposts' => 1,'post__not_in' => get_option('sticky_posts'),'cat' => $spec_cat1));
			while($recent_post1->have_posts()): $recent_post1->the_post(); 
				$cat1_out = eai_build_postcol(3, get_cat_name( $spec_cat1 )/* column title */, false/* excerpt */,true /* meta */, true /* date only*/);
				$displayed[] = get_the_ID();
			endwhile; 
			wp_reset_query();
			
			$recent_post2 = new WP_Query(array('post_type' => 'post','showposts' => 1,'post__not_in' => get_option('sticky_posts'),'cat' => $spec_cat2));
			while($recent_post2->have_posts()): $recent_post2->the_post(); 
				$cat2_out = eai_build_postcol(3, get_cat_name( $spec_cat2 )/* column title */, false/* excerpt */, true /* meta */, true /* date only*/ );
				$displayed[] = get_the_ID();
			endwhile; 
			wp_reset_query(); 

			$recent_post3 = new WP_Query(array('post_type' => 'post','showposts' => 1,'post__not_in' => get_option('sticky_posts'),'cat' => $spec_cat3));
			while($recent_post3->have_posts()): $recent_post3->the_post(); 
				$cat3_out = eai_build_postcol(3, get_cat_name( $spec_cat3 )/* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
				$displayed[] = get_the_ID();
			endwhile; 
			wp_reset_query();    
			
 			echo '<div class="prl-grid prl-grid-divider eacat-living">';
			/* get most recent post tagged with '_stickit' in given category */
			$p = 0;
			$stay_post = new WP_Query(array('post_type' => 'post','showposts' => 1,'post__not_in' => get_option('sticky_posts'), 'cat' => $category, 'tag' => '_stickit'));  		
			$gotone = false;
			while($stay_post->have_posts()): $stay_post->the_post();
				$displayed[] =  get_the_ID();
				$gotone=true;
				eai_do_feat(false/*meta*/, true /*excerpt*/); ?>
			<?php endwhile;  /* */

			wp_reset_postdata();
			/*wp_reset_query(); */

			if (!$gotone) {
				/* find the first one with a thumnail */
				while (have_posts()) : the_post(); 
					$this_id = get_the_ID();
					if ( (!$gotone) && has_post_thumbnail($this_id) ) {
						 /* echo '<p>post '.get_the_ID().' has a thumbnail gotit. </p>';  */
						if ( in_category('arts-a-living', $this_id)/*440 arts*/ || in_category('living-food', $this_id)/*food 416*/ || in_category('living-entertainment', $this_id) /*444 entertainment*/ ) {
							$gotone = true;
							eai_do_feat(false/*meta*/, true /*excerpt*/);
							$displayed[]= $this_id;
						}
					} 
				endwhile;
			} 

			wp_reset_postdata();
			/* do the next 3, the rest of the top box */
			if (have_posts()) {
				echo '<div class="prl-span-3"><ul class="prl-list prl-list-line" >';
				while  (have_posts() && ($p < 3))  : the_post();

					 if ( !in_array(get_the_ID(), $displayed) && !(in_category($nopost_cat)) )  { 
						/* <li style="list-style-type:none"><h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo post_thumb(get_the_ID(),150, 0, true);?></a><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> <?php echo get_label_format(get_the_ID());?> <?php echo get_label_meta(get_the_ID());?></h4></li><?php */
						echo '<li style="list-style-type:none">';
						echo eai_build_post(false /* excerpt */,'',true/*meta*/, true /* date only*/);
						echo '</li>';
					    $p++; 
					 } 
		        endwhile; 
		        echo ' </ul></div>';
	        }
	        // wp_reset_query(); 
	        echo '</div>';
	        echo '<hr/>'; /* end of top block*/

	        /* do the next three as columns */ 
	        if (have_posts()) {

	        	echo '<div class="prl-span-12">';
	        	echo '<div class="prl-grid prl-grid-divider">';
	        	 $p = 0; 
		    	while  (have_posts() && ($p < 3))  : the_post();
		    		if ( !in_array(get_the_ID(), $displayed) && !(in_category($nopost_cat)) )  { 
		    				echo eai_build_postcol(3 /* columns*/, ''/* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
						    $p++; 
					 } 
				endwhile; 
				echo '</div>';
				echo '</div>';
	        }
	       
	        /* do the 3 'special' categories */

	        echo '<hr/>';
	        echo '<div class="prl-grid prl-grid-divider">';
	        echo $cat1_out;
	        echo $cat2_out;
	        echo $cat3_out;
	        echo '</div>';  
	       	echo '<hr/>';

	        /* do any remaining post as list */
	        if (have_posts()) {
	        	echo '<h2 class="eai_more_in_cat">More in '.single_cat_title('', false).'</h3>';
	        	echo '<hr/>';
	        	echo '<ul class="prl-list-category">';
	        	while  (have_posts() )  : the_post();
		    		if ( !in_array(get_the_ID(), $displayed) && !(in_category($nopost_cat)) )  { 
		    				echo eai_build_postli(true/* excerpt */, 'list-thumbnail' /*image class */, true /* date only */);
						    $p++; 
					 } 
				endwhile; 
				echo '<hr/>';
	        }
	        if ( function_exists( 'page_navi' ) ) page_navi( 'items=5&amp;show_num=1&amp;num_position=after' );   	
		} else {   ?>
		     <ul class="prl-list-category">
			<?php 
			$i=0;
			while (have_posts()) : the_post();
			$i++;
			?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
				<article class="prl-article">
					<?php if( has_post_thumbnail()):?>
					<div class="list-thumbnail"><?php echo post_thumb(get_the_ID(),520, 360, true);?></div>
					<?php endif;?>
					<div class="prl-article-entry">
						<h2 class="prl-article-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php echo get_label_format(get_the_ID());?> <?php echo get_label_meta(get_the_ID()); ?></h2> 
						<?php if (is_category('Obituaries')) { post_meta(true, false, false, false, false); } else  { post_meta(true, true, true, true, false); } ?>
						<?php the_excerpt();?>
					</div>
				</article>
			</li>

			<?php endwhile; ?>
			
			</ul>
			<?php if ( function_exists( 'page_navi' ) ) page_navi( 'items=5&amp;show_num=1&amp;num_position=after' ); ?>

	<?php  } /* end of page > 1 */
	else : /* dont have posts */ ?> 
	<?php get_search_form(); ?>
<?php endif; ?>  