<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link              blueroosterthemes.com
 * @since             1.0.0
 *
 * @package           BR_KNOWLEDGE_BASE
 * @subpackage 		  BR_KNOWLEDGE_BASE/includes
 * @author     		  zulmkodr
 */
class BR_KNOWLEDGE_BASE_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'init', array($this,'register_shortcodes' ));


		 add_action( 'wp_ajax_bluerooster_article_thumbs_ajax_request', array($this,'update_article_thumb' ));
  		 add_action( 'wp_ajax_nopriv_bluerooster_article_thumbs_ajax_request', array($this,'update_article_thumb' ));


	}

	public function update_article_thumb()
	{

		$thumbs	= isset($_POST['thumbs'])?sanitize_text_field($_POST['thumbs']):"";
	    $post_id = (int)$_POST['post_id'];


	    $count_thumbs_up = get_post_meta($post_id,'thumbs_up',true);
	    $count_thumbs_down = get_post_meta($post_id,'thumbs_down',true);

	    $user_id = get_current_user_id();

	    $article_user_liked  = get_post_meta($post_id,'article_user_id',false);


	    if($count_thumbs_up == '' || $count_thumbs_down == '')
	    {
	    	$count_thumbs_up = 0;
	    	$count_thumbs_down =0;
	    }


	    if($thumbs == 'up')
	    {
	    	$count_thumbs_up++;


	    	if(!in_array($user_id, $article_user_liked))
	    	{
	    		update_post_meta($post_id, 'thumbs_up', $count_thumbs_up);
	    		update_post_meta($post_id,'article_user_id',$user_id);
	    		update_post_meta($post_id,'user_thumbs_up',$user_id);
	    	}
	    	else
	    	{
	    		$user_liked = get_post_meta($post_id,'user_thumbs_up',false);

	    		if(!in_array($user_id, $user_liked))
	    		{	
	    			$down = get_post_meta($post_id,'thumbs_down',true);

	    			if($down == 0)
	    			{
	    				$down = 0;
	    			}
	    			else
	    			{
	    				$down = $down -1;
	    			}

	    			update_post_meta($post_id,'thumbs_down', $down);
	    			update_post_meta($post_id, 'thumbs_up', $count_thumbs_up);
	    			update_post_meta($post_id,'user_thumbs_up',$user_id);
	    			delete_post_meta($post_id, 'user_thumbs_down', $user_id);
	    		}
	    	}

	    }
	    else
	    {
	    	$count_thumbs_down++;
	    	if(!in_array($user_id, $article_user_liked))
	    	{
	    		update_post_meta($post_id,'thumbs_down', $count_thumbs_down);
	    		update_post_meta($post_id,'article_user_id',$user_id);
	    		update_post_meta($post_id,'user_thumbs_down',$user_id);
	    	}
	    	else
	    	{
	    		$user_disliked = get_post_meta($post_id,'user_thumbs_down',false);

	    		if(!in_array($user_id, $user_disliked))
	    		{	
	    			$down = get_post_meta($post_id,'thumbs_up',true);

	    			if($down == 0)
	    			{
	    				$down = 0;
	    			}
	    			else
	    			{
	    				$down = $down -1;
	    			}

	    			update_post_meta($post_id,'thumbs_up', $down);
	    			update_post_meta($post_id, 'thumbs_down', $count_thumbs_down);
	    			update_post_meta($post_id,'user_thumbs_down',$user_id);
	    			delete_post_meta($post_id, 'user_thumbs_up', $user_id);
	    		}

	    	}
	    

	    }


	    exit;
	}

	public function register_shortcodes()
	{
		add_shortcode( 'blue_rooster_article',  array($this,'blue_rooster_article' ));
		add_shortcode('blue_rooster_faq',array($this,'blue_rooster_faq'));

	}

	public function blue_rooster_faq()
	{
		ob_start();

		$args = array(

			'post_type' => 'bluerooster_faq',
			'order' => 'ASC'
			);

		$query = get_posts($args);

   		include('shortcodes/faq.php');
   		
    	return ob_get_clean();
	}

	public function blue_rooster_article()
	{	

		 ob_start();

			$args = array(
			        'orderby' => 'name',
			        'order' => 'ASC',
			        'hide_empty' => 1
			);
			$tags = get_terms( 'page_group', $args);


		

			if(!empty($tags))
			{


				foreach($tags as $pg)
				{
					$t_id = $pg->term_id; // Get the ID of the term you're editing  
				    $pg->order = get_option( "taxonomy_term_$t_id")['order'];
				}

				//var_dump($page_groups);

				usort($tags, function($a, $b) {
			    	return $a->order - $b->order;
				});

				foreach($tags as $tag)
				{	



					$tag->articles = get_posts( 
							array(
							
								'post_type'=>'bluerooster_article',
								'include_children' => true,
								'post_status' => 'publish',
								'post_parent' =>0,
								'tax_query' => array(
										array(
										'taxonomy' => 'page_group',
										'field' => 'slug',
										'terms' => $tag->slug
										)
									)
								)
						);


					if(!empty($tag->articles))
					{
						foreach($tag->articles as $tagar)
						{
							$args = array(
								'post_parent' => $tagar->ID,
								'post_type'   => 'any', 
								'numberposts' => -1,
								'post_status' => 'publish' 
							);

							$tagar->childrens = get_children( $args );
						}

					}
				}
			}

		
   		include('shortcodes/article.php');
   		
    	return ob_get_clean();
	
		
	}

	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in BR_KNOWLEDGE_BASE_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BR_KNOWLEDGE_BASE_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style('blue-rooster-main', plugin_dir_url( __FILE__ ) . 'css/main.css', array(), $this->version, 'all' );

		wp_enqueue_style('bluer-rooster-public', plugin_dir_url( __FILE__ ) . 'css/BR_KNOWLEDGE_BASE-public.css', array(), $this->version, 'all' );


		wp_enqueue_style('blue-rooster-font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.css', array(), $this->version, 'all' );

		


	}

	public function enqueue_scripts()
	{
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/BR_KNOWLEDGE_BASE-public.js', array( 'jquery' ), $this->version, false );

	}

}
