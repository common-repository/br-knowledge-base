<?php
/**
 * Creates a search engine.
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

<style>

.just-padding {
  padding: 15px;
}

.list-group-bluerooster.list-group-bluerooster-root {
  padding: 0;
  overflow: hidden;
}

.list-group-bluerooster.list-group-bluerooster-root .list-group-bluerooster {
  margin-bottom: 0;
}

.list-group-bluerooster.list-group-bluerooster-root .list-group-bluerooster-item {
  border-radius: 0;
  border-width: 1px 0 0 0;
}

.list-group-bluerooster.list-group-bluerooster-root > .list-group-bluerooster-item:first-child {
  border-top-width: 0;
}

.list-group-bluerooster.list-group-bluerooster-root > .list-group-bluerooster > .list-group-bluerooster-item {
  padding-left: 30px;
}

.list-group-bluerooster.list-group-bluerooster-root > .list-group-bluerooster > .list-group-bluerooster > .list-group-bluerooster-item {
  padding-left: 45px;
}

.list-group-bluerooster a
{
	display: block;
	margin:5px;
	padding:5px;
}

</style>

<?php $option_url = get_option('bluerooster_url'); 

	if($option_url == '') {
		$option_url = 'bluerooster'; }
	
	$no_of_pages = $total_posts/$per_page;

?>

<div class="entry-header-bluerooster">
	<div class="pull-left">
		<h3>Search</h3> 
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
				
<span class="pull-left you-are-here"> You are here : <a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>">Home ></a>  Search</span>
						
<div class="clearfix"></div>
<div class="just-padding">
	<?php if(!empty($q)) { ?>
		<div class="list-group-bluerooster list-group-bluerooster-root">
			<?php foreach($q as $z) { ?>
				<a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/article&page=<?php echo $z->ID; ?>" class="list-group-bluerooster-item"> <i class="fa fa-caret-right"></i> <?php echo $z->post_title; ?></a>
				<?php if(!empty($z->childrens)) { ?>
					<div class="list-group-bluerooster">
						<?php foreach($z->childrens as $zchi) { ?>
							<a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/article&page=<?php echo $zchi->ID; ?>" class="list-group-bluerooster-item"><i class="fa fa-caret-right"></i> <?php echo $zchi->post_title; ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	<?php }?>  
</div>
	
<?php if($no_of_pages > 1) { ?>
	<nav aria-label="Page navigation example">
		<ul class="bluerooster-pagination">
			<?php for($i=0;$i<$no_of_pages;$i++) { ?>
				<li class="page-item <?php if($i == $paged) { ?>pagination-active <?php } ?>"><a class="page-link" href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/search-article&s=<?php echo $search; ?>&paged=<?php echo $i;  ?>"><?php echo $i + 1; ?></a></li>
			<?php } ?>
		</ul>
	</nav>
<?php } ?>
	
<?php include(plugin_dir_path(__DIR__) . 'partials/footer.php'); ?>