
<?php get_header();
	
if(function_exists('futurio_generate_header'))
{
	futurio_generate_header( true, true, true, true, true, true );
}
?>



<div id="secondary"></div>

<div class="bluerooster" style="margin-top:20px">
	<div class="container_bluerooster">
		<div class="bluerooster_wrapper">
							
							<!-- <header class="entry-header">
								<h3>Welcome to Blue Rooster</h3>
								<hr/>
							</header> -->


	<?php

	$option_url = get_option('bluerooster_url');

	if($option_url == '')
	{
		$option_url = 'bluerooster';
	}

	$faqs = get_posts( 
						array(
							'post_type'=>'bluerooster_faq',
							'post_status' => 'publish',
							'post_parent' =>0,
							)
					);


	$page_groups  = get_terms( 
			array(
			    'taxonomy' => 'page_group',
			    'hide_empty' => true,
			   )
		);

	


		if(!empty($page_groups))
		{


			foreach($page_groups as $pg)
			{
				$t_id = $pg->term_id; // Get the ID of the term you're editing  
			    $pg->order = get_option( "taxonomy_term_$t_id")['order'];
			}

			//var_dump($page_groups);

			usort($page_groups, function($a, $b) {
		    	return $a->order - $b->order;
			});

			foreach($page_groups as $pg)
			{
				$pg->articles = get_posts( 
								array(
								
									'post_type'=>'bluerooster_article',
									'include_children' => true,
									'post_status' => 'publish',
									'post_parent' =>0,
									'tax_query' => array(
											array(
											'taxonomy' => 'page_group',
											'field' => 'slug',
											'terms' => $pg->slug
											)
										),
									'meta_query' => array(
									        array(
									            'key'       => 'show_on_menu',
									            'value'     => 'yes',
									            'compare'   => 'IN',
									        )
									    )
									)
							);

				if(!empty($pg->articles))
						{
							foreach($pg->articles as $pagar)
							{

								$args = array(
									'post_parent' => $pagar->ID,
									'post_type'   => 'any', 
									'numberposts' => -1,
									'post_status' => 'publish',
									'meta_query' => array(
									        array(
									            'key'       => 'show_on_menu',
									            'value'     => 'yes',
									            'compare'   => 'IN',
									        )
									    )
								);

								$pagar->childrens = get_children( $args );
							}

						}

			}
		}

	 ?>

<nav class="nav-bluerooster">
  <ul class="menu-bluerooster">
    <li class="menu-item-bluerooster"><a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>"><?php echo $option_url; ?></a></li>
    <?php foreach($page_groups as $pg) { ?>
	    <li class="menu-item-bluerooster has-children">
	    	<a href="#"><?php echo $pg->name; ?> <?php if(!empty($pg->articles)) { ?> <span class="fa fa-caret-right"></span> <?php } ?></a>
	    <?php if(!empty($pg->articles)) { ?>
	      <ul class="sub-menu-bluerooster">
	        <?php foreach($pg->articles as $pga) { ?>
	        			<?php 

			        		

			        			$url= get_site_url() .'/?pagename='. $option_url . '/article&page=' . $pga->ID;
			        		

			        	 ?>
		    	<li class="menu-item-bluerooster has-children">
			    	<a href="<?php echo $url; ?>"><?php echo $pga->post_title; ?> <?php if(!empty($pga->childrens)) { ?><span class="fa fa-caret-right"></span> <?php } ?></a>
			    	<?php if(!empty($pga->childrens)) { ?>
			      	<ul class="sub-menu-bluerooster">
			      		<?php foreach($pga->childrens as $pgac) { ?>

			        	<li class="menu-item-bluerooster"><a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/article&page=<?php echo $pgac->ID; ?>"><?php echo $pgac->post_title; ?></a></li>
			        	<?php } ?>
			      	</ul>
			     	 <?php } ?>
		    	</li>
	    	<?php } ?>
	      </ul>
	 	<?php } ?>
	    </li>
	<?php } ?>

	<li class="menu-item-bluerooster"><a href="<?php echo get_site_url(); ?>/?pagename=<?php echo $option_url; ?>/faq">
		FAQs</a>
	</li>	
  </ul>
</nav>

<br/>

<div class="clearfix"></div>
