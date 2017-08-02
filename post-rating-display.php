<?php

$rating_img_name = get_option('rating_img_name');
$google_rich = get_option('google_rich');
$total_rating = (int) get_option('total_rating');
$postratings_allow_to = get_option('postratings_allow_to');
$postratings_user_type	= get_option('postratings_user_type');
$rating_restric_day	= get_option('rating_restric_day');
$custom_css = get_option('AOI_custom_css');
$aio_rating_loader	= get_option('aio_rating_loader');

/**
 * get rating imges here
*/

// If Global $id is 0, Get The Loop Post ID
if(empty($ratings_post_id)) {
	global $post , $id, $cat, $tag_id;
	
	if(is_single()){			
		$ratings_post_id = $post->ID;		
	}else{
		if(!empty($cat)) {
			$ratings_post_id = $cat;
			
		}else if(!empty($tag_id)){
			
			$ratings_post_id = $tag_id;
		}else{
			
			$ratings_post_id = $post->ID;
		}
	}
	
}

if(!empty($custom_css)) echo '<style type="text/css"> '.$custom_css.' </style>';

if('on' == $google_rich) {
$itemtype_of_content = apply_filters('wp_postratings_schema_itemtype', 'itemscope itemtype="http://schema.org/Article"');
$itemtype_of_content .= "data-nonce=\"".wp_create_nonce('aio_postratings_'.$ratings_post_id.'-nonce').'"';
}else{
	$itemtype_of_content = '';
}

echo "<div class='all-in-one-rating-wrapper'>";
echo "<div id='all-in-one-rating' ".$itemtype_of_content.">";	
	
	if(!wp_is_post_revision($post)){
		
		$img_path = plugins_url('/images/rating/', __FILE__ ).$rating_img_name.'/';
				
		if('custom' == get_option('rating_img_name') ){
	 		$rating_none_img = get_option('rating_none');	
			$rating_full_img = get_option('rating_full');
			$rating_avg_img = get_option('rating_avg');
			$rating_hover_img = get_option('rating_hover');
			
	 	}else{		
			$rating_none_img = $img_path.'rating_none.png';	
			$rating_full_img = $img_path.'rating_full.png';
			$rating_avg_img = $img_path.'rating_avg.png';
			$rating_hover_img = $img_path.'rating_hover.png';
	 	}
		
		$allready_rate = get_post_meta($ratings_post_id, 'aio_rating_count',true);
		
		if(!empty($allready_rate) && $allready_rate > 0){
			
			aoi_post_rating_result($ratings_post_id, $total_rating, $rating_none_img, $rating_full_img, $rating_avg_img,$rating_hover_img);
			
		}else{
			aoi_post_rating_none($ratings_post_id, $total_rating, $rating_none_img, $rating_full_img, $rating_avg_img, $rating_hover_img);		
		}
		if(empty($aio_rating_loader)){
			echo '<div id="aio-rating-loader" class="aio-default-loader">Loading..</div>';
		}else {
			echo '<div id="aio-rating-loader" class="aio-rating-custom-loader"><img src="'.$aio_rating_loader.'" alt="Loading.."></div>';
		}
		
	}else{		
		printf(__('Invalid Post Ratting.', 'all-in-one-rating'));
	}
echo '</div>';

if('on' == $google_rich) {
	
	if( (is_tag() || is_category() ) ){
		if(is_category()){
			$p_title =  get_cat_name($ratings_post_id);
			$p_link = get_category_link( $ratings_post_id );
			$p_description = category_description( $ratings_post_id );
		}elseif (is_tag()){
			$tag_ojb = get_tag($ratings_post_id);					 
			$p_title =  $tag_ojb->name;
			$p_link = get_tag_link( $ratings_post_id );
			$p_description = tag_description( $ratings_post_id );
		}
		
		$post_meta = '<meta itemprop="name" content="'.esc_attr($p_title).'" />';
		$post_meta .='<meta itemprop="description" content="'.wp_kses($p_description, array()).'" />';
		$post_meta .='<meta itemprop="url" content="'.$p_link.'" />';
		
	}else{
		$post = get_post($ratings_post_id);
		$post_link = get_the_permalink($ratings_post_id);
		if(empty($post->post_excerpt)){
			$post_post_content = wp_trim_words( $post->post_content, 20, $more = null );
		}else{
			$post_post_content = $post->post_excerpt;
		}
		$post_meta = '<meta itemprop="name" content="'.esc_attr($post->post_title).'" /><meta itemprop="description" content="'.wp_kses($post_post_content, array()).'" /><meta itemprop="url" content="'.$post_link.'" />';
	}
	echo $post_meta;
				
		$aio_ratings_meta = '<div style="display: none;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
		$aio_ratings_meta .= '<meta itemprop="bestRating" content="'.$total_rating.'" />';
		$aio_ratings_meta .= '<meta itemprop="ratingValue" content="'.get_post_meta($ratings_post_id,'aio_average_rating',true).'" />';
		$aio_ratings_meta .= '<meta itemprop="ratingCount" content="'.get_post_meta($ratings_post_id,'aio_rating_count',true).'" />';
		$aio_ratings_meta .='<meta itemprop="worstRating" content="1">';
		$aio_ratings_meta .= '</div>';
		echo $aio_ratings_meta;
}
echo '</div>';
?>