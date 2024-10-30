<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link              blueroosterthemes.com
 * @since             1.0.0
 *
 * @package           BR_KNOWLEDGE_BASE
 * @subpackage 		  BR_KNOWLEDGE_BASE/includes
 * @author     		  zulmkodr
 */
class Class_menu_page {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {

		/*add_action('admin_menu', array($this,'add_menu_page'));*/
		/*add_action('admin_menu', array($this,'register_menu_page'));*/
		add_action( 'init', array($this,'create_post_type_article' ));
		add_action( 'init', array($this,'create_bluerooster_article_taxonomy'),30);

		add_action( 'add_meta_boxes', array($this,'add_show_on_menu_metaboxes_article') );

		add_action( 'save_post', array($this,'save_show_on_menu_meta_article'), 1, 2 );

		add_filter( 'manage_bluerooster_article_posts_columns', array($this,'set_custom_edit_article_columns' ));

		add_action( 'manage_bluerooster_article_posts_custom_column' , array($this,'custom_article_column'), 10, 2 );

		add_action('admin_menu', array($this,'my_menu'));

		add_action('admin_init', array($this,'RegisterSettings'));

		add_action( 'load-tools_page_bluerooster-setting', array($this,'bluerooster_setting_save_options' ));

		add_filter('post_type_link',array($this,'custom_link_add_link_preview'),10,2);

		add_action( 'page_group_edit_form_fields', array($this,'page_group_taxonomy_custom_fields'), 10, 2 );   

		add_action( 'edited_page_group', array($this,'save_taxonomy_custom_fields'), 10, 2 ); 
		add_action( 'create_page_group', array($this,'save_taxonomy_custom_fields'), 10, 2 );
		add_action('page_group_add_form_fields',array($this,'page_group_taxonomy_custom_fields')); 
		
		add_filter('manage_edit-page_group_columns', array($this,'add_page_group_columns'));
		add_action('manage_page_group_custom_column',array($this,'manage_page_group_custom_fields'),10,3);
	}

	public function RegisterSettings()
	{
		add_option("bluerooster_url","");
   
	    // Register settings that this form is allowed to update
	    register_setting('bluerooster_settings', 'bluerooster_url');
   
	}

	public function bluerooster_setting_save_options()
	{
		$action       = 'bluerooster-setting-save';
		$nonce        = 'bluerooster-setting-save-nonce';
		
		/* Here is where you update your options. Depending on what you've implemented,
		   the code may vary, but it will generally follow something like this: */
		 
		   if ( isset( $_POST['bluerooster-setting'] ) ) {

		   	$setting_name =  sanitize_text_field($_POST['bluerooster-setting-name']);

				update_option( 'bluerooster_url',$setting_name );
			
			} else {
				
				delete_option( 'bluerooster_url' );
				
			}
			
	}

	public function my_menu()
	{
		add_submenu_page('edit.php?post_type=bluerooster_article','BR Settings','BR Settings','manage_options','bluerooster-setting',array($this,'option_page'));
	}

	public function option_page()
	{
		$url = get_option('bluerooster_url');
		
		include('partials/option_page.php');
   		
	}


/*	public function register_menu_page()
	{
		add_plugins_page('My Plugin Page', 'My Plugin', 'read', 'content_management', array($this,'main_menu_page'));
	}

	public function add_menu_page()
	{
		add_menu_page('Content Management', 'Content Management', 'manage_options', 'content_management', '');
		  
	}*/

	public function create_post_type_article() {

		$labels = array(
        'name' => __('Blue Rooster', 'post type general name'),
        'all_items' => 'Articles',
        'singular_name' => __('Article', 'post type singular name'),
        'add_new' => __('Add New Article', 'Knowledge Base item'),
        'add_new_item' => __('Add New Article'),
        'edit_item' => __('Edit Article'),
        'new_item' => __('New Article'),
        'view_item' => __('View Article'),
        'search_items' => __('Search Articles'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => 'Blue Rooster'
    		);

		  register_post_type( 'bluerooster_article',
		    array(
		      'labels' => $labels,
		      'public' => true,
		      'has_archive' => true,
		      'show_in_rest' => true,
		      'hierarchical' =>true,
		      'menu_icon' => 'dashicons-welcome-write-blog',
		      'supports' => array(
		            'page-attributes' /* This will show the post parent field */,
		            'title',
		            'editor',
		            'something-else',
		            'author'
		        ),
		    )
		  );

		  $labels1 = array(
	        'name' => __('FAQs', 'post type general name'),
	        'singular_name' => __('FAQs', 'post type singular name'),
	        'add_new' => __('Add New FAQ', 'Knowledge Base item'),
	        'add_new_item' => __('Add New FAQ'),
	        'edit_item' => __('Edit FAQ'),
	        'new_item' => __('New FAQ'),
	        'view_item' => __('View FAQs'),
	        'search_items' => __('Search FAQs'),
	        'not_found' =>  __('Nothing found'),
	        'not_found_in_trash' => __('Nothing found in Trash'),
	        'parent_item_colon' => ''
    		);


		  register_post_type( 'bluerooster_faq',
			    array(
			    'labels' => $labels1,
			    'public' => true,
			    'has_archive' => true,
			    'show_in_menu' => 'edit.php?post_type=bluerooster_article',
			    'show_in_rest' => true,
			      'hierarchical' =>true,
			      'supports' => array(
			            'page-attributes' /* This will show the post parent field */,
			            'title',
			            'editor',
			            'something-else',
			        ),
			    )
			);

	}

	public function create_bluerooster_article_taxonomy() {
 
	// Add new taxonomy, make it hierarchical like categories
	//first do the translations part for GUI
	 
	  $labels = array(
	    'name' => _x( 'Page Group', 'taxonomy general name' ),
	    'singular_name' => _x( 'Page Group', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search Page Group' ),
	    'all_items' => __( 'All Page Groups' ),
	    'parent_item' => __( 'Parent Page Group' ),
	    'parent_item_colon' => __( 'Parent Page Group:' ),
	    'edit_item' => __( 'Edit Page Group' ), 
	    'update_item' => __( 'Update Page Group' ),
	    'add_new_item' => __( 'Add New Page Group' ),
	    'new_item_name' => __( 'New Page Group Name' ),
	    'menu_name' => __( 'Page Group' ),

	  );    
	 
	// Now register the taxonomy
	 
	  register_taxonomy('page_group',array('bluerooster_article'), array(
	    'labels' => $labels,
	    'show_ui' => true,
	    'show_admin_column' => true,
	    'query_var' => true,
	    'show_in_rest'  => true,
	    'rewrite' => array( 'slug' => 'bluerooster_article' ),
	    'public' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'show_ui' => true,
		'hierarchical' => false
	  ));
	}


	/**
	* Adds a metabox to the right side of the screen under the â€œPublishâ€ box
	*/
	public function add_show_on_menu_metaboxes_article() {
		add_meta_box(
			'show_on_menu',
			'Show on Menu',
			array($this,'show_on_menu_article'),
			'bluerooster_article',
			'side',
			'default'
		);
	}
	 
	public	function show_on_menu_article() {
		global $post;
	
		// Get the location data if it's already been entered
		$show_on_menu = get_post_meta( $post->ID, 'show_on_menu', true );
		// Output the field

		?>
		<div>
		 <input type="radio" name="show_on_menu" value="yes" <?php if($show_on_menu == 'yes') { echo 'checked=checked'; } ?> />Yes
		 	 &nbsp;&nbsp;
		 	 |  &nbsp;&nbsp;
         <input type="radio" name="show_on_menu" value="no" <?php if($show_on_menu == 'no') { echo 'checked=checked'; } ?> />No
     	</div>
		<?php

	}

	public function save_show_on_menu_meta_article( $post_id, $post ) {
	// Return if the user doesn't have edit permissions.
		
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['show_on_menu'] ) ) {
		return $post_id;
	}
	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
	$events_meta['show_on_menu'] = esc_textarea( $_POST['show_on_menu'] );
	// Cycle through the $events_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.

	foreach ( $events_meta as $key => $value ) :
		// Don't store custom data twice
		
		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}
		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}
    endforeach;
   }

   public function set_custom_edit_article_columns($columns) {

	    
	    $columns['thumbs_up'] = __( 'Likes', 'your_text_domain' );
	    $columns['thumbs_down'] = __( 'Dislikes', 'your_text_domain' );

	    return $columns;
	}

	public function custom_article_column($column, $post_id)
	{
		switch ( $column ) {

			case 'thumbs_up' :
			
				$terms = get_post_meta( $post_id , 'thumbs_up' ,true);
            
				if($terms) { 
					echo $terms; }
				else { 
					echo 0; }
            
				break;

			case 'thumbs_down' :
			
				$terms = get_post_meta( $post_id , 'thumbs_down' ,true);
				if($terms)	{
				  echo $terms; }
				else {
					echo 0; }
				break;

		}
	}


	public function custom_link_add_link_preview($permalink, $post)
	{

		$url_option = get_option('bluerooster_url');

		if($url_option == '')
		{$url_option = 'bluerooster'; }


		if( $post->post_type == 'bluerooster_article' ) { // assuming the post type is video
        	$permalink = home_url( $url_option . "?pagename=$url_option/article&page=".$post->ID ); }

	    if( $post->post_type == 'bluerooster_faq' ) { // assuming the post type is video
        	$permalink = home_url( $url_option . "?pagename=$url_option/faq" ); }
	    return $permalink;
	}


	public function page_group_taxonomy_custom_fields($tag) {  
	   // Check for existing taxonomy meta for the term you're editing  
	    $t_id = $tag->term_id; // Get the ID of the term you're editing  
	    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check  


		?>  
		  
		<tr class="form-field">  
		    <th scope="row" valign="top">  
		        <label for="order"><?php _e('Page Group Order'); ?></label>  
		    </th>  
		    <td>  
		        <input type="number" name="term_meta[order]" id="term_meta[order]" size="25" style="width:95%;" value="<?php echo $term_meta['order']; ?>"><br />  
		          
		    </td>  
		</tr>  

		<br/>
		  
		<?php  
	}

	// A callback function to save our extra taxonomy field(s)  
	public function save_taxonomy_custom_fields( $term_id ) {  
		    if ( isset( $_POST['term_meta'] ) ) {  
		        $t_id = $term_id;  
		        $term_meta = get_option( "taxonomy_term_$t_id" );  
		        $cat_keys = array_keys( $_POST['term_meta'] );  
		            foreach ( $cat_keys as $key ){  
		            if ( isset( $_POST['term_meta'][$key] ) ){  
		                $term_meta[$key] = sanitize_text_field($_POST['term_meta'][$key]);  
		            }  
		        }  
		        //save the option array  
		        update_option( "taxonomy_term_$t_id", $term_meta );  
		    }  
	}


	public function add_page_group_columns($columns)
	{
		$columns['order'] = 'Order';

    	return $columns;
	}    

	public function manage_page_group_custom_fields($deprecated,$column_name,$term_id){


	     if ($column_name == 'order') {
	       $t_id = $term_id;
	       $cat_meta = get_option( "taxonomy_term_$t_id");
	       echo $cat_meta['order'];

	     }
    }

}
	

new Class_menu_page();
