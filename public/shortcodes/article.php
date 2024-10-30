<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link              blueroosterthemes.com
 * @since             1.0.0
 *
 * @package           BR_KNOWLEDGE_BASE
 * @subpackage 		  BR_KNOWLEDGE_BASE/includes
 * @author     		  zulmkodr
 */
?>

<style>
.bluerooster-article
{
	/*margin:0 20% 0 20%;*/
}

.bluerooster-article ul
{
	list-style-type: none;
}

.bluerooster-article-main
{
	background: #efefef;
	margin:5px;
	padding:5px;
	border-radius: 5px;
	min-height: 500px;
	position: relative;
	margin-bottom: 20px;
}

.main-li-blue
{
	border-bottom:1px #ddd solid;
	margin-bottom:5px;
}

.main-li-blue:last-child
{
	border-bottom: none;
}



.view-all-article
{
	text-align: center;
}
</style>

<?php
$option_url  = get_option('bluerooster_url');

if($option_url == '')
{
	$option_url = 'bluerooster';
}

?>

<div class="bluerooster-article">
	<div class="clearfix"></div>
	<br/>
	
	<?php foreach($tags as $key=>$tag) { 
		$i = 0;
	?>
	<div class="blurooster-4">
	<div class="bluerooster-article-main">

	<h4 class="text-center"><i class="fa fa-book"></i> <a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/page-group&page=<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?>(<?php echo count($tag->articles); ?>)</a></h4>
	<hr/>
	<?php if(!empty($tag->articles)) { ?>
		<div style="height:390px;overflow-y: scroll">
			<ul>
				<?php foreach($tag->articles as $article) { 
					if($i == 7)
					{
						break;
					}
					$i++;
					?>

						<li class="main-li-blue"> <i class="fa fa-caret-right"></i>
							<?php if(count($article->childrens) > 0) { ?>
								<a href="#"><?php echo $article->post_title; ?></a>
							<?php } else {?>
								<a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/article&page=<?php echo $article->ID; ?>"><?php echo $article->post_title; ?></a>
							<?php } ?>


						<?php if(!empty($article->childrens)) { ?>

							<ul>
							<?php foreach($article->childrens as $acd) {

								if($i == 7)
								{	
									break;
								}
								$i++;
							 ?>
								<li><i class="fa fa-caret-right"></i> <a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/article&page=<?php echo $acd->ID; ?>"><?php echo $acd->post_title; ?></a></li>

							<?php } ?>
							</ul>

						<?php } ?>

					</li>

				<?php } ?>
			</ul>
		</div>
			<!-- <a href="<?php echo get_site_url(); ?>/<?php echo $option_url; ?>/page-group/<?php echo $tag->term_id; ?>" class="view-all-article label label-primary pull-right" style="padding:5px;">View all</a> -->
			<?php if($i > 6 ) { ?>
			
			<div style="color:#000;bottom: 0px;position: absolute;padding:5px;border-top:1px #ddd solid;font-size:13px">There are more articles under this section. <a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/page-group&page=<?php echo $tag->term_id; ?>" style="color:#00aff2;"><b>Click here </b></a>to view them all.</div>
			<?php } ?>
		<?php } ?>
		</div>
	</div>

	<?php } ?>
</div>