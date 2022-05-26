<?php
/*
Template Name: Page - YellowPages
		20May2022 - zig create.
*/

get_header();?>
<div class="ea-YellowPages">
    <div class="prl-grid prl-grid-divider">
		<section id="main" class="prl-span-12">
		   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		   <article id="post-<?php the_ID(); ?>" <?php post_class('article-single clearfix'); ?>>
			   <?php if ( has_post_thumbnail()&& (get_post_meta($post->ID, 'pl_post_thumb', true)!='disable')):?>
				<div class="space-bot">
				  <?php the_post_thumbnail(''); ?>
				</div>
				<?php endif; ?>
				<?php if(get_post_meta($post->ID, 'pl_page_title', true)=='enable'){?>
				<h1 class="ea-page-title"><?php the_title(); ?></h1><?php } ?>
				<div class="prl-entry-content clearfix">
			   <?php the_content(); ?>
			   <?php wp_link_pages(array('before' => __('Pages','presslayer').': ', 'next_or_number' => 'number')); ?>
			   <?php edit_post_link(__('Edit','presslayer'),'<p>','</p>'); ?>
			   </div>
		   </article>
		   <?php endwhile; endif; ?>
        </section>
    </div>
</div>
<?php get_footer();?>
