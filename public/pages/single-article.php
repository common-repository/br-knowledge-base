<?php
/**
 * Creates a posts/article.
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
.article-footer-bluerooster
{
	margin-top:10px;
}
.bluerooster_thumb_up i:hover
{
	color: green;
}
.bluerooster_thumb_down i:hover
{
	color: red;
}

a.disabled
{
 pointer-events: none;
  cursor: default;
}
</style>
		

<div class="entry-header-bluerooster">
	<div class="pull-left">
		<h3><?php echo $query->post_title; ?></h3> 
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
	
<?php $post_type = get_the_terms($query,'page_group')[0]; ?>
	
<span class="pull-left you-are-here"> You are here: 
	<a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>">Home</a>
	<?php  if($post_type) { ?> > 
		<a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/page-group&page=<?php echo $post_type->term_id; ?>"><?php echo $post_type->name; ?></a>
	<?php } ?> 
	> 
	<?php echo $query->post_title; ?>
</span>
					
<div class="clearfix"></div>

<br/>

<div style="color:#000">
	<?php echo $query->post_content ?>
</div>

<div class="article-footer-bluerooster">
	<span class="pull-left">Published By: <?php echo the_author_meta( 'display_name', $query->post_author ); ?>(<?php echo date('l F j, Y',strtotime($query->post_date)); ?>)</span>
	
	<br/><br/>

	<?php $article_liked =  get_post_meta($query->ID,'article_user_id',false); 

							$user_liked = get_post_meta($query->ID,'user_thumbs_up',false);
							$user_disliked = get_post_meta($query->ID,'user_thumbs_down',false);

							$like_disabled = '';
							$dislike_disabled = '';

							if(is_user_logged_in()) {
								if(in_array( get_current_user_id(), $user_liked)) {
									$like_disabled = 'disabled'; }

								if(in_array( get_current_user_id(), $user_disliked)) {
									$dislike_disabled = 'disabled'; }

							}
							else {
								$like_disabled = 'disabled';
								$dislike_disabled = 'disabled';
							}

	?>

	<p>Was this Article helpful?</p>
	<a href="#" class="bluerooster_thumb_up <?php echo $like_disabled; ?>" thumb-data="up" post-id="<?php echo $query->ID; ?>" ><i class="fa fa-thumbs-up" ></i> 
		<span class="bluerooster-article-thumbs-up-count">
			<?php 
				$thumbs_up =  get_post_meta($query->ID,'thumbs_up',true); 
				if($thumbs_up == '') { echo 0; }
				else { echo $thumbs_up; } 
			?>
		</span>
	</a>
	
	&nbsp;&nbsp;&nbsp;&nbsp;
	
	<a href="#" class="bluerooster_thumb_down <?php echo $dislike_disabled; ?>" thumb-data="down" post-id="<?php echo $query->ID; ?>">
		<i class="fa fa-thumbs-down"></i> 
		<span class="bluerooster-article-thumbs-down-count">
			<?php $thumbs_down =  get_post_meta($query->ID,'thumbs_down',true);
				if($thumbs_down == '') { echo 0; }
				else { echo $thumbs_down; }
			?>
		</span>
	</a>
</div>				
	
<?php include(plugin_dir_path(__DIR__) . 'partials/footer.php'); ?>