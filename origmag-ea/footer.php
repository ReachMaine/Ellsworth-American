<?php /*
	modifications:
		10Oct14 - zig - modify copyright to
		24Dec14 - zig - add broadstreet popup script
		31jan16 - zig - add technavia script at bottom of page
		29Aug16 - zig - xout technavia script.  put into header.
*/ ?>
<?php global $theme_url, $prl_data;?>

	<footer id="footer">
		<?php
			if (is_active_sidebar('over_footer')) {
				echo '<div id="over_footer_wrap" class="prl-container">';
				dynamic_sidebar('over_footer');
				echo '</div>';
			}
		?>
		<?php if($prl_data['footer_widget']!='Disable'):?>
		<div class="footer-widget">
			<div class="prl-container">
				<div class="prl-grid prl-grid-divider">
					<?php for($i=1;$i<=4;$i++){?>
					<div class="prl-span-3">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_'.$i) ) : ?><?php endif; ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php endif;?>
		<div class="copyright">
			<div class="prl-container">
				<div class="left">
					&copy; <?php echo date('Y');?> <?php _e('by','presslayer');?> <a href="<?php echo home_url();?>"><?php bloginfo('name');?></a> -  All rights reserved. | <a href='http://www.ellsworthamericaninc.com/privacy-policy/'>Privacy Policy</a> | <a href='http://www.ellsworthamericaninc.com/terms-of-use/'>Terms Of Use</a>
				</div>
				<div class="right"><?php echo trim($prl_data['footer_text']);?></div>
			</div>
		</div><!-- .copyright -->

	</footer><!-- #footer -->

</div><!-- .site-wrapper -->
	<?php if($prl_data['switcher']=='Enable') include ('_switcher/index.php');?>
	<a id="toTop" href="#"><i class="fa fa-long-arrow-up"></i></a>

	<?php /* 29Aug16 zig try moving to after body tag -<script data-cfasync="false" type="text/javascript" src="http://ellsworthamerican.me.pw.newsmemory.com/include.php"></script> */ ?>
	<?php /* technavia footer script */ ?>

	<?php wp_footer();?>
	<?php echo stripslashes($prl_data['google_analytics']); ?>
	<?php /* <script defer=defer type="text/javascript">broadstreet.zone(39775);</script> */ ?>

	</body>
</html>
