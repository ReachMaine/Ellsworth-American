<?php
/*
Template Name: Page - EAHomeFlow
*/?>
<?php
/* mods:
  1Oct19 zig - new homepage page template.
    idea:
     slice1:  top banner ad
     slice2:  featured post + stack of 3 in one col, position 2a sidebar
              row of 4 across
              position 2b

    slice3:  position 3a + 3 accross
            4 accross.
            position 3b

    slice4:  3 accross + position 4a
            4 accross
            position 4b

Notes from Meeting with Chris & Cyndi
- positions 2b & 3b not go all the way accross
- need some type of styling that sets ads apart from file_get_contents
- may need to label posts in Sports & Living with subcat.
*/
get_header();?>
<?php /* some inputs */
  $num_post_to_get = '40';
  $num_posts_to_show = 21; // number of posts to flow on page...
  $cats = array(374 /* news*/, 896 /* life style */, 1404/* sports */);
  $stickit_cat = 374;
  $stickit_id = 981;
  //testing
  $cats = array(2, 3, 4);
  $stickit_cat = 2;
  $stickit_tag = 10;
  $p=0; // total posts shown
?>
<div class="prl-container">
    <div class="prl-grid prl-grid-divider">
      <?php if (isset($prl_data['banner_top_cat']) && $prl_data['banner_top_cat']!='')
          echo '<div id="archive-top-ad" class=prl-span-12> <div class="ads_top ad-container">'.stripslashes($prl_data['banner_top_cat']).'</div></div>';
      ?>

      <?php
      /* first section = slice2 .... featured post, 3 in a column +  sidebar (position2a) */
      echo '<section id="eai-slice2" class="eai-home-slice">';
        // first breaking news...
        if (is_active_sidebar('breaking-news')) {
            echo '<div class="eai-breaking-news prl-span-12">';
            dynamic_sidebar( 'breaking-news' );
            echo '</div>';
        }
        $have_sidebar = true;
        $slice_content_span = 9;
        if (!is_active_sidebar('position2a')) {
          // no sidebar
          $slice_content_span = 12;
          $have_sidebar = false;
        }

        // span for content
        echo '<div class="prl-span-'.$slice_content_span.'">';
        // now the featured post
        $feat_post = "";
        $stay_postq = new WP_Query(array(
                            'post_type' => 'post',
                            'posts_per_page' => 1,
                            'post__not_in' => get_option('sticky_posts'),
                            'no_found_rows' => TRUE,
                            'tax_query' => array(
                                'relation' => 'OR',
                                array(
                                    'taxonomy' => 'category',
                                    'field' => 'id',
                                    'terms' => array($stickit_cat),
                                    'include_children' => true,
                                    'operator' => 'AND'
                                ),
                                array(
                                    'taxonomy' => 'post_tag',
                                    'field' => 'id',
                                    'terms' => array($stickit_tag),
                                    'operator' => 'AND',
                                )
                              ) // tax array
                            ));
        //echo '<pre>'.$stay_postq->request."</pre>";
        if ($stay_postq->have_posts()) {
          //echo "<p>Past the if ... </p>";
          //while($recent_posts->have_posts()): $recent_posts->the_post();
          while ($stay_postq->have_posts()) : $stay_postq->the_post();
          //echo "<p>GOt one...<p> ";
            $feat_post = get_the_ID();
            echo eai_build_postcol(6 /* columns*/, "FEATURED: ".$post->ID/* column title */, true/* excerpt */, true /* meta */, true /* date only*/);
            $p++;
          endwhile;  /* */

        } else {
          //echo "<p>nada.</p>";
        }
        //echo "<hr>";
        wp_reset_query();
        $recent_posts = new WP_Query(array('post_type' => 'post',
                                          'posts_per_page'=> $num_post_to_get,
                                          'post__not_in' => get_option('sticky_posts'),
                                            'category__in' => $cats,
                                          'no_found_rows' => TRUE));

        //echo '<pre>'.$recent_posts->request."</pre>";
        if ( $recent_posts->have_posts() ) {

        }

            // echo '<div class="prl-grid prl-grid-divider">';

          $pslice = 0; // posts in this slice
          $pslice_limit = 3;

          echo '<div class="prl-span-3">' ;
          echo '<ul class="prl-list prl-list-line">';
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;
                  // display the post here???
                //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";

              echo eai_build_postli( false/* excerpt */, true /* date only*/);
            }
          endwhile;
          echo '</ul>';
          echo '</div>'; // div for columns
          echo '<hr>';
          // next row of posts...
          $pslice_limit = 3;
          $pslice = 0;
          if (!$have_sidebar) {
            $pslice_limit = 4;
          }
          echo '</div class="prl-span-12">' ;
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;
                  // display the post here???
                //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";

                echo eai_build_postcol(4 /* columns*/, $post->ID /* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
            }
          endwhile;
          echo '</div>'; // div for columns
          if (is_active_sidebar('position2b')) {

              echo '<div class="eai-position2b prl-span-12">';
                echo '<div class="prl-grid prl-grid-divider">';
                dynamic_sidebar( 'position2b' );
                echo '</div>';
              echo '</div>';
          }

        if (is_active_sidebar('position2a')) {
          echo '<aside class="eai-position2a prl-span-3">';
          dynamic_sidebar( 'position2a' );
          echo '</aside>';
        }
        echo '</div>'; // div for grid
    echo '</section>';

/* *** 2nd content section = slice 3 **** */
/*
      $have_sidebar = true;
      is_active_sidebar('position3a') {

        $slice_span = 9;
        $pslice_limit = 3;
      } else {
        $slice_span = 12;
        $have_sidebar = false;
        $pslice_limit = 4;
      }
      echo '<section id="eai-slice3" >';
        echo 'div class="prl-span-'.$slice_span.' eai-home-slice">';
        $p=0;
        $num_post_to_show = 3;
        while($recent_posts->have_posts()  && ($p <= $num_post_to_show) ): $recent_posts->the_post();
            if ($feat_post != $post->ID) {
                $p++;
                // display the post here???
              //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";
            echo eai_build_postcol(4 , $post->ID , false, true , true );
          }
        endwhile;
        ?>
      </section>
      */ ?>
    </div><!--.prl-grid-->
</div>
<?php get_footer();?>
