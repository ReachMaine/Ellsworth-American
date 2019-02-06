<?php
/* created 31jan18 zig
	for recipes to dislay in a pinterest style grid
*/
	global $pl_data, $theme_url;
	if (have_posts()) :?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php if (is_category()) { /* If this is a category archive */ ?>
			<h3 class="prl-archive-title"><?php single_cat_title(); ?></h3>
			<?php echo category_description();  ?>
 	  <?php } elseif( is_tag() ) { /* If this is a tag archive */  ?>
		<h3 class="prl-archive-title"><?php _e('Posts Tagged','presslayer');?>: <?php single_tag_title(); ?></h3>
	 <?php /* If this is a author archive */ } elseif( is_author() ) { $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));?>
		<h3 class="prl-archive-title ">Articles by: <?php echo $curauth->display_name; ?> </h3>
		 <?php echo ts_fab_show_bio('archive', $curauth->ID); ?>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h3 class="prl-archive-title"><?php _e('Archive for','presslayer');?> <?php the_time('F jS, Y'); ?></h3>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h3 class="prl-archive-title"><?php _e('Archive for','presslayer');?> <?php the_time('F, Y'); ?></h3>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h3 class="prl-archive-title"><?php _e('Archive for','presslayer');?> <?php the_time('Y'); ?></h3>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h3 class="prl-archive-title "><?php _e('Blog Archives','presslayer');?></h3>
 	  <?php } elseif (is_search()){ ?>
	  	<h3 class="prl-archive-title"><?php _e('Search Results','presslayer');?></h3>
	  <?php  } elseif ( is_post_type_archive( )) {?>
			<h3 class="prl-archive-title"><?php _e(post_type_archive_title(),'presslayer');?></h3>
		<?php } ?>

		<div class="eai-grid-wrapper">
     <ul class="prl-list-category eai-archive-grid">
			<?php
			$i=0;
			while (have_posts()) : the_post();
			$i++;
			?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('eai-grid-item clearfixx'); ?>>
				<article class="prl-article">

					<div class="eai-grid-list-thumbnail">
							<?php if( has_post_thumbnail()){
									echo post_thumb(get_the_ID(),150, 150, true);
								} else { ?>
									<div class="eai-grid-thumb-placeholder">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/grid-placeholder.jpg">
									</div>
								<?php } ?>
					</div>

					<div class="eai-grid-article-entry">
						<h3 class="eai-grid-title">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
									<?php the_title(); ?>
								</a>
						</h3>

					</div>
				</article>
			</li>

			<?php endwhile; ?>

			</ul>
	</div> <!-- grid wrapper -->
	<?php if ( function_exists( 'page_navi' ) ) {
		page_navi( 'items=5&amp;show_num=1&amp;num_position=after' ); }
	else {
		echo '<div class="navigation">';
		echo '<div class="alignleft">';
			previous_posts_link( '&laquo; Previous ' );
		echo '</div>';
		echo '<div class="alignright">';
			next_posts_link( 'Next &raquo;', '' );
		echo '</div>';
	}
	?>


<?php else : ?>
	<?php get_search_form(); ?>
<?php endif; ?>
