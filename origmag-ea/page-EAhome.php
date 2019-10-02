<?php
/*
Template Name: Page - EAHomeFlow
*/?>
<?php
/* mods:
  1Oct19 zig - new homepage page template.
    idea:  get n lastest posts, find the _stickit.
    display the rest as stream with ads intersperced.
*/
get_header();?>
<?php /* */
  $num_post_to_show = 21;
?>
<div class="prl-container">
    <div class="prl-grid prl-grid-divider">
      <?php if (isset($prl_data['banner_top_cat']) && $prl_data['banner_top_cat']!='')
          echo '<div id="archive-top-ad" class=prl-span-12> <div class="ads_top ad-container">'.stripslashes($prl_data['banner_top_cat']).'</div></div>';
      ?>

      <?php // get n (40) number of posts.
        $feat_post = "";
        $cats = array(374 /* news*/, 896 /* life style */, 1404/* sports */);
        $recent_posts = new WP_Query(array('post_type' => 'post',
                                          'posts_per_page'=> '40',
                                          'post__not_in' => get_option('sticky_posts'),
                                          /* 'cat' => $category,*/
                                          'category__in' => $cats,
                                          'no_found_rows' => TRUE));

        //echo '<pre>'.$recent_posts->request."</pre>";

      ?>
		<section id="main" class="prl-span-12">
		<?php if (is_active_sidebar('breaking-news')) {
    		echo '<div class="eai-breaking-news prl-span-12">';
    		dynamic_sidebar( 'breaking-news' );
    		echo '</div>';
    	}  ?>

      <div class="prl-grid prl-grid-divider">
        <?php
          // loop til we find the featured post.
          $p=0;
          while($recent_posts->have_posts() && !$feat_post): $recent_posts->the_post();
              if (has_tag('_stickit')) {
                  $feat_post = $post->ID;
                echo eai_build_postcol(6 /* columns*/, "FEATURED: ".$post->ID/* column title */, true/* excerpt */, true /* meta */, true /* date only*/);
              //eai_do_feat(false/*meta*/, true /*excerpt*/);
                  // display the post here???
              }

            $p++;
          endwhile;
          wp_reset_query();

      // display featured post here..

      // loop through the reset of post and display as columns until
      $p=0;
      while($recent_posts->have_posts()  && ($p <= $num_post_to_show) ): $recent_posts->the_post();
          if ($feat_post != $post->ID) {
              $p++;
              // display the post here???
            //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";
          echo eai_build_postcol(4 /* columns*/, ''/*$post->ID column title */, false/* excerpt */, true /* meta */, true /* date only*/);
        }
      endwhile;
      wp_reset_query();
      ?>
      </div>
		</section>
    </div><!--.prl-grid-->
</div>
<?php get_footer();?>
