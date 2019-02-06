<?php
/* created 31jan19 by zig to display recipe archive.

*/
get_header();?>
<div class="prl-container archive ea-recipe">
    <div class="prl-grid prl-grid-divider">

    	<?php if (is_active_sidebar('topbanner')) {
			dynamic_sidebar( 'topbanner' );
    	} ?>
		<section id="main" class="prl-span-9">
		<?php if (is_active_sidebar('breaking-news')) {
    		echo '<div class="eai-breaking-news prl-span-12">';
    		dynamic_sidebar( 'breaking-news' );
    		echo '</div>';
    	}  ?>

		<?php

    $content = 'content-archive-grid';
		get_template_part($content,'index');
?>
  <?php if(is_category() && isset($prl_data['banner_bot_cat']) && $prl_data['banner_bot_cat']!='')
    echo '<div class="ads_bottom prl-panel hide-tablet"><div class="ad-container ad-in-content">'.stripslashes($prl_data['banner_bot_cat']).'</div></div>';?>
		</section>
        <aside id="sidebar" class="prl-span-3">
            <?php get_sidebar();?>
        </aside>
    </div><!--.prl-grid-->
</div>
<?php get_footer();?>
