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
  $num_posts_to_show = 24; // number of posts to flow on page...
  // ea
  $cats = array(374 /* news*/, 896 /* life style */, 1404/* sports */); // news, lifestyle, sports
  $stickit_cat = 374;
  $stickit_id = 981;
  //testing
  $cats = array(2, 3, 4);
  $stickit_cat = 2;
  $stickit_tag = 10;
  // inits
  $p=0; // total posts shown
?>
<div class="prl-container">
<?php
    //<div class="prl-grid prl-grid-divider">
    if ( isset($prl_data['banner_top_cat']) && $prl_data['banner_top_cat']!='') {
        echo '<div class="prl-grid prl-grid-divider">';
        echo '<div id="archive-top-ad" class=prl-span-12> <div class="ads_top ad-container">'.stripslashes($prl_data['banner_top_cat']).'</div></div>';
        echo '</div>';
    }


    /* first section => slice2 ....
      featured post, 3 in a column +  sidebar (position2a)
      then row of 4 accross
      then ad position 2b */
    echo '<section id="eai-slice2" class="eai-home-slice">';

        // first breaking news...
        if (is_active_sidebar('breaking-news')) {
            echo '<div class="prl-grid">';
              echo '<div class="eai-breaking-news prl-span-12">';
              dynamic_sidebar( 'breaking-news' );
              echo '</div>'; // col
            echo '</div>'; // grid
        }

        echo '<div class="prl-grid">';
        // *** Now the featured post ***
        $feat_post = "";
        $stay_postq = new WP_Query(array(
                            'post_type' => 'post',
                            'posts_per_page' => 1,
                            'post__not_in' => get_option('sticky_posts'),
                            'no_found_rows' => TRUE,
                            'tax_query' => array(
                                'relation' => 'AND',
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
          //echo "<p>GOt featured ...<p> ";
            $feat_post = get_the_ID();
            //echo '<div class="prl-span-6">'; // span 9 or twelve
          echo eai_build_postcol(6 /* columns*/, ""/* column title */, true /* excerpt */, true /* meta */, true /* date only*/);
            //echo '<div class="prl-span-6">'; // span 9 or twelve
            $p++;
          endwhile;  /* */

        } else {
          //echo "<p>nada featured.</p>";
        }
        //echo "<hr>";
        wp_reset_query();
        $recent_posts = new WP_Query(array('post_type' => 'post',
                                          'posts_per_page'=> $num_post_to_get,
                                          'post__not_in' => get_option('sticky_posts'),
                                            'category__in' => $cats,
                                          'no_found_rows' => TRUE));

        // *** Now the column posts ***
        $pslice = 0; // posts in this slice
        $pslice_limit = 2;
        // list next to featured.
        echo '<div class="prl-span-3">' ;
          echo '<ul class="prl-list prl-list-line" style="list-style:none;" >';
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;
                  if (has_post_thumbnail()) {
                    echo eai_build_postli( false/* excerpt */, true /* date only*/);
                  } else {
                  echo eai_build_postli( true/* excerpt */, true /* date only*/);
                }
            }
          endwhile;
          echo '</ul>';
        echo '</div>'; // div for list col


        // **** now the sidebar....
        if (is_active_sidebar('position2a')) {
          echo '<aside class="eai-position2a prl-span-3">';
          dynamic_sidebar( 'position2a' );
          echo '</aside>';
        }
      echo '</div>'; // for grid


        // next row of posts...
        $pslice_limit = 4;
        $pslice = 0;
        echo '<div class="prl-grid">';
        //echo '<div class="prl-span-12">' ;
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;
                  // display the post here???
                //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";
                if (has_post_thumbnail()) {
                  echo eai_build_postcol(4 /* columns*/, ""/* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
                } else {
                  echo eai_build_postcol(4 /* columns*/, ""/* column title */, true/* excerpt */, true /* meta */, true /* date only*/);
                }
              }
          endwhile;
        //echo '</div>'; // div for columns
        echo '</div>'; // grid


          if (is_active_sidebar('position2b')) {
            echo '<div class="prl-grid">';
              echo '<div class="eai-position2b prl-span-12">';
                dynamic_sidebar( 'position2b' );
              echo '</div>'; // span.
            echo '</div>'; // grid
          }


        //echo '</div>'; // div for grid
    echo '</section>';

/* *** 2nd content section = slice 3 **** */
  echo '<section id="eai-slice3" class="eai-home-slice"><!-- 2nd section = slice 3 -->';
    echo '<div class="prl-grid">';
      // first side bar if there is one
      // **** now the sidebar....
      if (is_active_sidebar('position3a')) {
        echo '<aside class="eai-position3a prl-span-3">';
        dynamic_sidebar( 'position3a' );
        echo '</aside>';
        $pslice_limit = 3;
      } else {
        $pslice_limit = 4; // no sidebar, do for across....
      }
      // next row of posts...

      $pslice = 0;
      //echo '<div class="prl-span-12">' ;
        while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
            if ($feat_post != $post->ID) {
                $p++;
                $pslice++;
                // display the post here???
              //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";
              if (has_post_thumbnail()) {
                echo eai_build_postcol(4 /* columns*/, ""/* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
              } else {
                echo eai_build_postcol(4 /* columns*/, ""/* column title */, true/* excerpt */, true /* meta */, true /* date only*/);
              }
          }
        endwhile;
      echo "</div>"; // grid

      echo '<div class="prl-grid">';
        $pslice_limit = 4; // no sidebar, do for across....
        $pslice = 0;
        //echo '<div class="prl-span-12">' ;
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;
                  // display the post here???
                //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";
                if (has_post_thumbnail()) {
                  echo eai_build_postcol(4 /* columns*/, ""/* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
                } else {
                  echo eai_build_postcol(4 /* columns*/, ""/* column title */, true/* excerpt */, true /* meta */, true /* date only*/);
                }
            }
          endwhile;
        echo "</div>"; // grid

        // ad space across....
        if (is_active_sidebar('position3b')) {
          echo '<div class="prl-grid">';
            echo '<div class="eai-position3b prl-span-12">';
              dynamic_sidebar( 'position3b' );
            echo '</div>'; // span.
          echo '</div>'; // grid
        }
  echo '</section>';


  /* *** 3nd content section = slice 4 **** */
    echo '<section id="eai-slice4" class="eai-home-slice"><!-- 3nd section = slice 4 -->';
      echo '<div class="prl-grid">';
        // first side bar if there is one
        // **** now the sidebar....
        if (is_active_sidebar('position4a')) {
          $pslice_limit = 3;
        } else {
          $pslice_limit = 4; // no sidebar, do for across....
        }
        // next row of posts...

        $pslice = 0;
        //echo '<div class="prl-span-12">' ;
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                $p++;
                $pslice++;
                if (has_post_thumbnail()) {
                  echo eai_build_postcol(4 /* columns*/, ""/* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
                } else {
                  echo eai_build_postcol(4 /* columns*/, ""/* column title */, true/* excerpt */, true /* meta */, true /* date only*/);
                }
            }
          endwhile;

        if (is_active_sidebar('position4a')) {
          echo '<aside class="eai-position4a prl-span-3">';
          dynamic_sidebar( 'position4a' );
          echo '</aside>';
        }
        echo "</div>"; // grid

        echo '<div class="prl-grid">';
          $pslice_limit = 4; // no sidebar, do for across....
          $pslice = 0;
          //echo '<div class="prl-span-12">' ;
            while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
                if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;
                  if (has_post_thumbnail()) {
                    echo eai_build_postcol(4 /* columns*/, ""/* column title */, false/* excerpt */, true /* meta */, true /* date only*/);
                  } else {
                    echo eai_build_postcol(4 /* columns*/, ""/* column title */, true/* excerpt */, true /* meta */, true /* date only*/);
                  }
              }
            endwhile;
          echo "</div>"; // grid
          //echo "<p>p is: [".$p."]</p>";

          // ad space across....
          if (is_active_sidebar('position4b')) {
            echo '<div class="prl-grid">';
              echo '<div class="eai-position4b prl-span-12">';
                dynamic_sidebar( 'position4b' );
              echo '</div>'; // span.
            echo '</div>'; // grid
          }
    echo '</section>';
  ?>
    </div><!--.prl-grid-->
</div>
<?php get_footer();?>
