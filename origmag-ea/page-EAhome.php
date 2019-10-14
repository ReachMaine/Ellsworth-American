<?php
/*
Template Name: Page - EAHome
<?php
/* mods:

*/
get_header();?>
<?php /* some inputs */
  $num_post_to_get = '40';
  $num_posts_to_show = 24; // number of posts to flow on page...
  // ea
  $cats = array(374 /* news*/, 896 /* life style */, 1404/* sports */); // news, lifestyle, sports
  $stickit_cat = 374;
  $stickit_tag = 981;
  //testing
  /* $cats = array(2, 3, 4);
  $stickit_cat = 2;
  $stickit_tag = 10; */
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
        /* $cats_str = get_post_meta(get_the_id(), 'eai-page-cats', true);
        if ($cats_str) { // not working yet, since it a page not a post s.t. doesnt show post_meta box
          $cats = explode($cats_str);
          $stickit_cat = $cat[0]; // first one is stickit category
        } */
        //echo "<pre>"; var_dump($cats); echo "</pre>";
        //echo "<hr><p>stickit_cat is [".$stickit_cat."].";
        //echo "<hr><p>stickit_tag is [".$stickit_tag."].";


        echo '<div class="prl-grid">'; // whole thing
        echo '<div class="prl-span-9 ">' ; // content section
        echo '<div class="prl-grid eai-content-row">'; // content columns
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
                                    'include_children' => false,
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
              echo eaihome_build_postcol(8 /* columns*/,  ""/* column title */, true, true /* date */);
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
          //echo '<pre>'.$recent_posts->request."</pre>";
          // *** Now the column posts ***
          $pslice = 0; // posts in this slice
          $pslice_limit = 2;
          // list next to featured.
          echo '<div class="prl-span-4">' ;
            echo '<ul class="prl-list" style="list-style:none;" >';
            while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
                if ($feat_post != $post->ID) {
                    $p++;
                    $pslice++;
                    echo '<li id="post-'.get_the_ID().'" class="'.implode(' ', get_post_class('clearfix')). '" >';
                    echo eaihome_build_post(false, false);
                    echo '</li>';
              }
            endwhile;
            echo '</ul>';
          echo '</div>'; // div for list col



        echo '</div><!-- end grid 1st content row -->'; // for grid
        echo '<div class="prl-grid eia-content-row"><!-- start grid 2nd content row -->';
        // next row of posts...
        $pslice_limit = 3;
        $pslice = 0;

        //echo '<div class="prl-span-12">' ;
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;

                echo eaihome_build_postcol(3 /* columns*/, ""/* column title */, false /* excerpt*/, false /* date */);
              }
          endwhile;

          echo '</div><!-- end grid 2nd content row -->'; // content columns

          echo '</div><!-- end grid for content  -->'; // div for columns
          // **** now the sidebar....
          if (is_active_sidebar('eaihome_side1')) {
            echo '<aside class="eaihome_side1 prl-span-3">';
            dynamic_sidebar( 'eaihome_side1' );
            echo '</aside>';
          } else {

          }
        echo '</div><!--  grid for whole thing -->';

    echo '</section>';
echo '</div><!-- container -->';
echo '<div class="prl-container ea-float">';
    if (is_active_sidebar('eaihome_across1')) {
      echo '<div class="prl-grid">';
        echo '<div class="eaihome_across1 prl-span-12" style="margin-top: 10px;" >';
          dynamic_sidebar( 'eaihome_across1' );
        echo '</div>'; // span.
      echo '</div>'; // grid
    }
echo '</div><!-- container -->';
echo '<div class="prl-container">';
/* *** 2nd content section = slice 3 **** */
  echo '<section id="eai-slice3" class="eai-home-slice"><!-- 2nd section = slice 3 -->';
    echo '<div class="prl-grid">'; // whole slice
      // first side bar if there is one
      // **** now the sidebar....
      if (is_active_sidebar('eaihome_side2')) {
        echo '<aside class="eaihome_side2 prl-span-3">';
        dynamic_sidebar( 'eaihome_side2' );
        echo '</aside>';
        $pslice_limit = 3;
        echo '<div class="prl-span-9 ea-content-grid">' ; // content section
        echo '<div class="prl-grid eia-content-row">'; // content columns
      } else {
        $pslice_limit = 4; // no sidebar, do for across....
        echo '<div class="prl-span-12">' ; // content section
        echo '<div class="prl-grid eia-content-row">'; // content columns
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
            echo eaihome_build_postcol($pslice_limit /* columns*/, ""/* column title */, false, false /* date */);
          }
        endwhile;
        echo "</div><!-- end content1 -->"; // grid

        echo '<div class="prl-grid eia-content-row">';

        $pslice = 0;
        //echo '<div class="prl-span-12">' ;
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;
                  // display the post here???
                //  echo "<p> post #: ".$p." display post ID: ".$post->ID." - </p>";

              echo eaihome_build_postcol($pslice_limit /* columns*/, ""/* column title */, false, false /* date */);

            }
          endwhile;
        echo "</div><!-- content2 -->"; // grid

        echo "</div><!-- content span -->";
        echo "</div><!-- whole slice -->";
        // ad space across....

  echo '</section>';
  echo '</div><!-- container -->';
  echo '<div class="prl-container ea-float" >';
              if (is_active_sidebar('eaihome_across2')) {
            echo '<div class="prl-grid">';
              echo '<div class="eaihome_across2 prl-span-12" style="margin-top: 10px;" >';
                dynamic_sidebar( 'eaihome_across2' );
              echo '</div>'; // span.
            echo '</div>'; // grid
          }
  echo '</div><!-- container -->';
  echo '<div class="prl-container">';

  /* *** 3nd content section = slice 4 **** */
    echo '<section id="eai-slice4" class="eai-home-slice"><!-- 3nd section = slice 4 -->';
      echo '<div class="prl-grid"><!-- begin grid for whole slice-->'; // whole slice
        // first side bar if there is one
        // **** now the sidebar....
        if (is_active_sidebar('position4a')) {
          $pslice_limit = 3;
          echo '<div class="prl-span-9 eai-content"><!-- content section start -->' ; // content section
          echo '<div class="prl-grid eai-content-row">'; // content columns
        } else {
          $pslice_limit = 4; // no sidebar, do for across....
          echo '<div class="prl-span-12 eai-content"><!-- content section start -->' ; // content section
          echo '<div class="prl-grid eai-content-row">'; // content columns
        }
        // next row of posts...

        $pslice = 0;
        //echo '<div class="prl-span-12">' ;
          while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
              if ($feat_post != $post->ID) {
                $p++;
                $pslice++;

              echo eaihome_build_postcol($pslice_limit /* columns*/,  ""/* column title */, false, false /* date */);

            }
          endwhile;


        echo "</div><!-- end content row1 -->"; // grid

        echo '<div class="prl-grid eai-content-row">';
          $pslice = 0;
          //echo '<div class="prl-span-12">' ;
            while ( $recent_posts->have_posts()  && ($p < $num_posts_to_show) && ($pslice < $pslice_limit) ): $recent_posts->the_post();
                if ($feat_post != $post->ID) {
                  $p++;
                  $pslice++;

                echo eaihome_build_postcol($pslice_limit /* columns*/, ""/* column title */, false, false /* date */);

              }
            endwhile;
          echo "</div><!--end content row2 -->"; // grid

        echo "</div><!-- content section end -->"; // grid
          if (is_active_sidebar('position4a')) {
            echo '<aside class="eai-position4a prl-span-3">';
            dynamic_sidebar( 'position4a' );
            echo '</aside>';
          }

        echo "</div>"; // grid  for whole thing

    echo '</section>';
    echo '</div><!-- container -->';
echo '<div class="prl-container ea-float" >';
 // ad space across....
        if (is_active_sidebar('position4b')) {
          echo '<div class="prl-grid">';
            echo '<div class="eai-position4b prl-span-12" style="margin-top: 10px;">';
              dynamic_sidebar( 'position4b' );
            echo '</div>'; // span.
          echo '</div>'; // grid
        }
echo '</div><!-- container -->';
echo '<div class="prl-container">';
  ?>
    </div><!--.prl-grid-->
</div>
<?php get_footer();?>
