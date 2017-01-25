<?php  /* template mods:
  25Jan17 zig - move the date published to the bottom.
 */
?>
<?php get_header();?>
<div class="prl-container">
    <div class="prl-grid prl-grid-divider">
    	<?php /* if(isset($prl_data['banner_before_single_title']) && $prl_data['banner_before_single_title']!='') echo '<div id="single-top-ad" class="prl-span-12"> <div class="ads_top ad-container">'.stripslashes($prl_data['banner_before_single_title']).'</div></div>'; */ ?>
    	<?php if (is_active_sidebar('topbanner')) {
			dynamic_sidebar( 'topbanner' );
    	} ?>
        <section id="main" class="prl-span-9"> <!-- single ea_obit -->
        	<?php if (is_active_sidebar('breaking-news')) {
    		echo '<div class="eai-breaking-news prl-span-12">';
    		dynamic_sidebar( 'breaking-news' );
    		echo '</div>';
    	} else { /*  echo '<!-- no breaking news right now -->'; */ } ?>
		   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		   <article id="post-<?php the_ID(); ?>" <?php post_class('article-single'); ?>>
		   		<?php if ( has_post_thumbnail() ) { /* set meta image for google custom search */
		   			$gimgatts = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full-size');
		   			echo '<meta itemprop="image" content="'.$gimgatts[0].'"></meta>';
		   		} ?>
					<?php if( has_post_thumbnail() && get_post_meta($post->ID, 'pl_post_thumb', true)!='Disable') : ?>
						<div class="single-post-thumbnail">
							<?php
							/* the_post_thumbnail('ea_featuredimg');  */
							/* the_post_thumbnail('');  */
							/* post_thumb(get_the_ID(), 500); */
							the_post_thumbnail('ea_featuredimg');
							$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full-size'); // For pinterest sharing
							?>
						</div>
						<div class="single-post-thumbnail-caption space-bot">
							<?php cc_featured_image_caption(); ?>
						</div>
					<?php endif; ?>
			   <h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			   <hr class="prl-grid-divider">
				<div class ="single-meta">
			   		<?php ea_social_share();?>
				</div>
			   <hr class="prl-grid-divider">
			   <div class="prl-grid">
					<div class="prl-span-12 prl-span-flip">
						<div class="prl-entry-content clearfix">

						   <?php if($prl_data['show_excerpt']=='Enable') {?><strong><?php the_excerpt(); ?></strong><?php }?>
						   <?php  the_content();  ?>
						   <?php /* embed_related_content(); echo '<!-- content -->'.$content; */ ?>
						   <?php /* the_content(); */?>
               <div class ="single-meta meta-bottom">
                 <div class="prl-article-meta">
                   <?php /* post_meta(true, false, false , false, false  ) ;   */
                   // date, author, comments, cat, view, updated?
                    echo 'Published on: <span>'; the_time('F j, Y');  echo '</span>';
                    ?>
                  </div>
                  <hr class="prl-grid-divider">
               </div>
						   <?php wp_link_pages(array('before' => __('Pages','presslayer').': ', 'next_or_number' => 'number')); ?>
						   <?php edit_post_link(__('Edit','presslayer'),'<p>','</p>'); ?>

						   <?php if(isset($prl_data['banner_after_single_content']) && $prl_data['banner_after_single_content']!='') echo '<div class="hide-mobile"><center class="ad-container ad-in-content">'.stripslashes($prl_data['banner_after_single_content']).'</center></div>';?>

						</div>
					</div>

			   </div>

		   </article>

		   <?php endwhile; endif; ?>

		   <?php /* 11Feb15 zig NO comments OR author box for obits... */ ?>


			<?php
			$single_id = $post->ID;
			if(get_post_meta($post->ID, 'pl_related', true)=='default' or get_post_meta($post->ID, 'pl_related', true)==''){
				$related = $prl_data['related_post'];
			}else{
				$related = get_post_meta($post->ID, 'pl_related', true);
			}
			if($related!='Disable') get_template_part( 'related-post');
			?>
			<?php if (is_active_sidebar('biztoday')) { echo '<div class="biz-today horizontal">'; dynamic_sidebar('biztoday'); echo '</div>'; } ?>
        </section>

        <aside id="sidebar" class="prl-span-3">
            <?php if ( is_active_sidebar('obits' )) {
            	dynamic_sidebar('obits');
            } else {
            	get_sidebar('single');
            } ?>
        </aside>
    </div>
</div>


<?php get_footer();?>
