<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link              blueroosterthemes.com
 * @since             1.0.0
 *
 * @package           BR_KNOWLEDGE_BASE
 * @subpackage 		  BR_KNOWLEDGE_BASE/includes
 * @author     		  zulmkodr
 */
?>

<?php 
$option_url = get_option('bluerooster_url');
if($option_url == '')
{
	$option_url ='bluerooster';
}
?>


<div class="wrap">

	<h1>Blue Rooster Settings</h1>
	<p class="description">
		You currently call your Blue Rooster Knowledge Base <b style="border:1px #ddd solid;font-size:16px"><?php echo $option_url; ?></b>
	</p>
	<hr/>
	<form action="options.php" method="post">
		<?php settings_fields('bluerooster_settings'); ?>

		<label><b>What would you like to call your Blue Rooster Knowledge Base?</b></label>
			<input type="text" name="bluerooster_url" placeholder="Eg. bluerooster-article" style="width:30%" value="<?php echo $url; ?>">

	  	<br/><br/>
		
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Save">&nbsp;
		<?php if($url == '') { $url = $option_url;} ?>
	  	<a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $url; ?>" class="button button-primary" style="margin-left:5px" target="_blank" style="float:left">Go to Homepage</a>
		<!-- The set of option elements, such as checkboxes, would go here -->
		<?php wp_nonce_field( 'bluerooster-setting-save', 'bluerooster-setting-save-nonce' ); ?>

	</form>

</div><!-- .wrap -->