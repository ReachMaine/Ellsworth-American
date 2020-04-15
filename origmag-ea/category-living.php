<?php  /* template mods:
  9April2020 - category living templates
 */

  // inits
  $p=0; // total posts shown
  $feat_post = 0;

get_header();

echo '<div class="prl-container">';

    if (is_active_sidebar('topbanner')) {
      dynamic_sidebar( 'topbanner' );
    }
    echo '<section id="eai-slice2" class="eai-home-slice">';

      // first breaking news...
      if (is_active_sidebar('breaking-news')) {
          echo '<div class="prl-grid">';
            echo '<div class="eai-breaking-news prl-span-12">';
            dynamic_sidebar( 'breaking-news' );
            echo '</div>'; // col
          echo '</div>'; // grid
      }
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // what page are we on?


    echo '<div class="prl-grid">'; // whole thing
      echo '<div class="prl-span-9 ">' ; // content section
        echo '<div class="prl-grid eai-content-row">'; // content columns
          $pslice = 0;
          $skip_count = 0;
          if (1 == $paged) {
            // featured = first one with a featured image \
            $pslice_limit = 1;
            while (have_posts()  && ($pslice < $pslice_limit)) : the_post();
              if (has_post_thumbnail() ) {
                $feat_post = $post->ID;
                echo eaihome_build_postcol(8 /* columns*/,  ""/* column title */, true, true /* date */);
                $p++;
                $pslice++;
              } else {
                $skip_count++;
              }
            endwhile;
            if ($skip_count > 0) { // had to skip some without images.  reset the loop
              rewind_posts();
            }
            // now the list next to the big image....
            echo '<div class="prl-span-4">' ;
              echo '<ul class="prl-list" style="list-style:none;" >';
                $pslice = 0;
                $pslice_limit = 2;
                while (have_posts()  && ($pslice < $pslice_limit)) : the_post();
                  if ($feat_post  != $post->ID) {
                    $pslice++;
                    $p++;
                    echo '<li id="post-'.get_the_ID().'" class="'.implode(' ', get_post_class('clearfix')). '" >';
                    echo eaihome_build_post(false, false);
                    echo '</li>';
                  }
                endwhile;
              echo "</ul>";
            echo "</div>"; // span 4
        } else {
          $pslice_limit=3;
          $pslice = 0;
          while (have_posts()  && ($pslice < $pslice_limit)) : the_post();
                  $p++;
                  $pslice++;
                  echo eaihome_build_postcol(3 /* columns*/, ""/* column title */, false /* excerpt*/, false /* date */);
          endwhile;
        }
      echo '</div><!-- end grid 1st content row -->'; // for grid
      if (true) { //  2nd content row side 1st section
          echo '<div class="prl-grid eia-content-row"><!-- start grid 2nd content row -->';
            // next row of posts...
            $pslice_limit = 3;
            $pslice = 0;

            while (have_posts()  && ($pslice < $pslice_limit)) : the_post();
              if ($feat_post  != $post->ID) {
                    $p++;
                    $pslice++;
                    echo eaihome_build_postcol(3 /* columns*/, ""/* column title */, false /* excerpt*/, false /* date */);
              }
            endwhile;
          echo '</div><!-- end grid 2nd content row -->'; // content columns
      } // 2nd row of content
    echo '</div><!-- end of span 9-->';      // **** now the sidebar....
    if (is_active_sidebar('eaihome_side1')) {
      echo '<aside class="eaihome_side1 prl-span-3">';
      dynamic_sidebar( 'eaihome_side1' );
      echo '</aside>';
    } else {
      // not sure what to do if there isnt a sidebar....
    }
    echo '</div><!--  grid for whole thing -->';

  echo '</section>';
  echo '</div><!-- container -->';

  // for ads across row...
  if (is_active_sidebar('eaihome_across1')) {
    echo '<div class="prl-container ea-float">';
      echo '<div class="prl-grid">';
        echo '<div class="eaihome_across1 prl-span-12" style="margin-top: 10px;" >';
          dynamic_sidebar( 'eaihome_across1' );
        echo '</div>'; // span.
      echo '</div>'; // grid
    echo '</div><!-- container -->';
  }

  // now for the second section.....
  if (true) { // second section
    echo '<div class="prl-container">';
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
          $pslice = 0;
          while (have_posts()  && ($pslice < $pslice_limit)) : the_post();
            if ($feat_post  != $post->ID) {
                  $p++;
                  $pslice++;
                  echo eaihome_build_postcol(3 /* columns*/, ""/* column title */, false /* excerpt*/, false /* date */);
            }
          endwhile;
          echo "</div><!-- end content row -->"; // grid

          echo '<div class="prl-grid eia-content-row">';
            $pslice = 0;
            while (have_posts()  && ($pslice < $pslice_limit)) : the_post();
              if ($feat_post  != $post->ID) {
                    $p++;
                    $pslice++;
                    echo eaihome_build_postcol(3 /* columns*/, ""/* column title */, false /* excerpt*/, false /* date */);
              }
            endwhile;
          echo "</div><!-- content row -->"; // grid

        echo "</div><!-- content span -->";

        echo "</div><!-- content grid -->";
      echo '</section>';
    echo '</div><!-- container -->';
      // ad space across....
    if (is_active_sidebar('eaihome_across2')) {
        echo '<div class="prl-container ea-float" >';
          echo '<div class="prl-grid">';
            echo '<div class="eaihome_across2 prl-span-12" style="margin-top: 10px;" >';
              dynamic_sidebar( 'eaihome_across2' );
            echo '</div>'; // span 12
          echo '</div>'; // grid
        echo '</div><!-- container -->';
    }
  } // second section.
echo '</div><!-- container -->'; // overarching container.
 get_footer();?>
