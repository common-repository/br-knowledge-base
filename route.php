<?php

add_action( 'init', 'my_rewrite' );

/*function reset_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%postname%/' );
}
add_action( 'init', 'reset_permalinks' );*/


add_action( 'parse_request', 'wpse6891_parse_request' );

function my_rewrite() {
    global $wp_rewrite;


    $url_option = get_option('bluerooster_url');

   if($url_option == '')
    {
            $url_option = 'bluerooster';
    }

    add_rewrite_rule($url_option . '/search-article/$','index.php?pagename=$url_option/search-article?s=$matches[1]&paged=$matches[2]', 'top');

    add_rewrite_rule($url_option . '/page-group/$','index.php?pagename=$url_option/page-group?page=$matches[1]&paged=$matches[2]', 'top');

    add_rewrite_rule($url_option . '/article/$','index.php?pagename=$url_option/article?page=$matches[1]', 'top');

    add_rewrite_rule($url_option . '/faq','index.php?pagename=$url_option/faq', 'top');

    add_rewrite_rule($url_option . '/$','index.php?pagename=$url_option', 'top');

    $wp_rewrite->flush_rules(true);  // This should really be done in a plugin activation
}
	

	function wpse6891_parse_request( &$wp )
	{

        $url_option = get_option('bluerooster_url');

        if($url_option == '')
        {
            $url_option = 'bluerooster';
        }

		$pagename = $wp->query_vars['pagename'];


		if($pagename == $url_option)
		{
			ob_start();

			$pageid = $wp->query_vars['page'];

       		include( dirname( __FILE__ ) . '/public/pages/homepage.php' );

			die();
		}


    	if($pagename == $url_option . '/article')
    	{	

            ob_start();
			$pageid = $wp->query_vars['page'];

			$query = get_post($pageid);

       		include( dirname( __FILE__ ) . '/public/pages/single-article.php' );
			die();
    	}

    	if($pagename == $url_option . '/faq')
    	{
    		ob_start();
			$pageid = $wp->query_vars['page'];

       		include( dirname( __FILE__ ) . '/public/pages/faq.php' );

			die();

    	}

        if($pagename == $url_option . '/page-group')
        {
         
            ob_start();

            $pageid = $wp->query_vars['page'];

            $paged = $wp->query_vars['paged'];

            $term = get_term($pageid);

            $per_page = 10;

            $args_total = [
                    'post_type'=> 'bluerooster_article',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'page_group',
                            'field' => 'slug',
                            'terms' => $term->slug
                        )
                    ),
                  
                ];

            $total_posts = count(get_posts( $args_total ));

            $offset = $per_page * $paged;

            $args = [
                    'post_type'=> 'bluerooster_article',
                    'posts_per_page' => $per_page,
                    'offset' => $offset,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'page_group',
                            'field' => 'slug',
                            'terms' => $term->slug
                        )
                    ),
                  
                ];
            $q = get_posts( $args );

            if(!empty($q))
            {

                foreach($q as $tagar)
                {

                                $args = array(
                                    'post_parent' => $tagar->ID,
                                    'post_type'   => 'bluerooster_article', 
                                    'numberposts' => -1,
                                    'post_status' => 'publish' 
                                );

                                $tagar->childrens = get_children( $args );
                }
            }



            include( dirname( __FILE__ ) . '/public/pages/page-group.php' );

            die();
        }


        if($pagename == $url_option . '/search-article')
        {
            ob_start();

            $page = $wp->query_vars['page'];
            $paged = $wp->query_vars['paged'];

            $search = $wp->query_vars['s'];


            $per_page = 10;

            $args_total = [
                    'post_type'=> 'bluerooster_article',
                    'posts_per_page' => -1,
                     's' => $search,
                     'post_status' => 'publish' 
                ];

            $total_posts = count(get_posts( $args_total ));

            $offset = $per_page * $paged;

            $args = [
                    'post_type'=> 'bluerooster_article',
                    'posts_per_page' => $per_page,
                    's' => $search,
                    'offset' => $offset,
                   'post_status' => 'publish' 
                  
                ];
            $q = get_posts( $args );

            if(!empty($q))
            {

                foreach($q as $tagar)
                {

                                $args = array(
                                    'post_parent' => $tagar->ID,
                                    'post_type'   => 'bluerooster_article', 
                                    'numberposts' => -1,
                                    'post_status' => 'publish' 
                                );

                                $tagar->childrens = get_children( $args );
                }
            }


            include( dirname( __FILE__ ) . '/public/pages/search.php' );

            die();

        }
       
    }


?>
