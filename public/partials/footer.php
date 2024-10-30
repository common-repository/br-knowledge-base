
	</div>
	</div>
	</div>
	<div style="margin-bottom:40px"></div>		

<?php if(is_user_logged_in()) {  ?> 
<script>
$=jQuery;
$(function()
{
	var ajax_url = "<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php";
	$('.article-footer-bluerooster a').click(function(e)
	{	
		var thumbs_count = parseInt($(this).find('span').html());

		var thumbs = $(this).attr('thumb-data');
			
		$(this).find('span').html(thumbs_count + 1);

		if(thumbs == 'up')
		{

			var dislikes = parseInt($('.bluerooster_thumb_down').find('span').html()) || 0;
			if(dislikes > 0)
			{
				$('.bluerooster_thumb_down').find('span').html(dislikes - 1);
			}
		}
		else
		{
			var likes = parseInt($('.bluerooster_thumb_up').find('span').html()) || 0;
			if(likes > 0)
			{
				$('.bluerooster_thumb_up').find('span').html(likes - 1);
			}
		}

		var z  = $(this);


		var post_id = $(this).attr('post-id');

	 	$.ajax({
        url: ajax_url,
        type: 'POST',
        data: {
            'action':'bluerooster_article_thumbs_ajax_request',
            'thumbs' : thumbs,
            'post_id' : post_id
        },
        success:function(data) {
            // This outputs the result of the ajax request
            $(z).parents('div').find('a').removeClass('disabled');
            $(z).addClass('disabled');
            //$(z).closest('a').removeClass('disabled');
           
        },
        error: function(errorThrown){
            alert(errorThrown);
            console.log(errorThrown);
        }
    }); 

	  e.preventDefault();

	});

})

</script>

<?php } ?>

<?php

get_footer();
wp_footer();

?>



