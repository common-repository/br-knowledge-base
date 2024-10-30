<?php
/**
 * Creates a homepage for Blue Rooster Knowledge Base Plugin.
 *
 * @link              blueroosterthemes.com
 * @since             1.0.0
 *
 * @package           BR_KNOWLEDGE_BASE
 * @subpackage 		  BR_KNOWLEDGE_BASE/includes
 * @author     		  zulmkodr
 */
 ?>

<?php include(plugin_dir_path(__DIR__) . 'partials/header.php'); ?>

<div class="entry-header-bluerooster">
	<div class="pull-left">
		<h3>All Articles</h3> 
	</div>
	
	<div class="pull-right">
		<form action="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/search-article" method="post">
			<div style="float:left">
				<input type="text" name="s"placeholder="Search Your Article">
			</div>

			<div style="float:right">
				<button type="submit"  value="Search">Search</button>
			</div>
		</form>
	</div>
</div>
	
<?php echo do_shortcode('[blue_rooster_article]'); ?>
		
<?php include(plugin_dir_path(__DIR__) . 'partials/footer.php'); ?>


