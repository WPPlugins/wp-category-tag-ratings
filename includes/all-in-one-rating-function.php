<?php

// User given rating to post
function user_given_rating_to_post(){
	
	if(!empty($_POST['post_id']) && !empty($_POST['user_rat']) && !empty($_POST['action'])){
		
		global $wpdb, $user_identity, $user_ID;
		$master_api_return_value = '';
		$user_given_post_rat = intval($_POST['user_rat']);
		$post_ID = intval($_POST['post_id']);
		$total_ratings = (int) get_option('total_rating');
		
		
		if($user_given_post_rat > 0 && $post_ID > 0 ){
			$Allow_To_Rate = Allow_To_Rate($user_ID);
			// check post type here 
			if(!empty($Allow_To_Rate)){
				
				$user_Rating_Restriction = Rating_Restriction_to_user($post_ID);
				if(!empty($user_Rating_Restriction)){					
					
					// Check For Ratings Lesser Than 1 And Greater Than $ratings_max
					if($user_given_post_rat < 1 || $user_given_post_rat > $total_ratings) {
						$user_given_post_rat = 0;
					}
					
					$aio_rating_count = get_post_meta($post_ID,'aio_rating_count',true);
					$aio_rating_count = ($aio_rating_count+1);
					$aio_total_rating = get_post_meta($post_ID,'aio_total_rating',true);
					$aio_total_rating = ($aio_total_rating+intval($user_given_post_rat));
					$aio_average_post_rating = round($aio_total_rating/$aio_rating_count,2);
					
									
					update_post_meta($post_ID, 'aio_rating_count', $aio_rating_count);
					update_post_meta($post_ID, 'aio_total_rating', $aio_total_rating);
					update_post_meta($post_ID, 'aio_average_rating', $aio_average_post_rating);
					
					// Add Log
					if(!empty($user_identity)) {
						$post_rating_user = addslashes($user_identity);
					} else {
						//$rate_user = __('Guest user', 'all-in-one-post-rating');
						$post_rating_user = __('Guest user', 'all-in-one-post-rating');
					}
					$current_userid = intval($user_ID);
					// Only Create Cookie If User Choose Logging Method 1 Or 3
					$table_name = $wpdb->prefix . "all_in_one_post_ratings";
					//$wpdb->query( $wpdb->prepare( "INSERT INTO $table_name VALUES (%d, %d, %s )", 0, $post_ID,  $user_given_post_rat, date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'],  gethostbyaddr($_SERVER['REMOTE_ADDR']), $post_rating_user, $current_userid ) );
					
					$wpdb->insert($table_name ,array('postid'=>$post_ID,
					'rating' => $user_given_post_rat,
					'timestamp' => date('Y-m-d H:i:s'),
					'ip' => users_ipaddress(), 
					'host' => users_ipaddress('host'), 
					'username' => $post_rating_user, 
					'userid' =>$current_userid ));
					
					echo $after_rating_template = sucessfully_rating($post_ID, $aio_average_post_rating, $aio_total_rating, $aio_rating_count);
					exit();
				}else{
					printf(__('you have already rated this post .', 'all-in-one-postraing'));
				exit();
				}
				
			}else{
				printf(__('Not authorised to Rating this post.', 'all-in-one-postraing'));
				exit();
			}
		}else{
			printf(__('Invalid Post Ratting.', 'all-in-one-postraing'));
			exit();
		}
	}else{
		printf(__('Invalid Post Ratting.', 'all-in-one-postraing'));
		exit();
	}
	
}

/**
 *  Post rating time get user ip address 
 *
 * @param we have get host name on function parameter if we hav't get any parameter than we have decault get id adress
 * @return user ip address if not recevied host value but we have get host value on paramter than we have return host name
 */
	
 function  users_ipaddress($host = '') {
		if(!empty($host)){
			$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			// some times IP is not a valid IPv4 or IPv6 address that why		
			if (strstr($host_name, ', ')) {
			    $host_array= explode(', ', $host_name);
			    $host_name = $host_array[0];
			}		
			return esc_attr($host_name);
			
		}else{		
			if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				$ip = $_SERVER["REMOTE_ADDR"];
			} else {
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			// some times IP Address is not a valid IPv4 or IPv6 address that why
			if(strpos($ip, ',') !== false) {
				$ip = explode(',', $ip_address);
				$ip = $ip[0];
			}
			return esc_attr($ip);
		}
	}
	


/**
 * print avg rating of post
 * @param  $ratings_post_id Current post or tag/category id
 * @param  $total_rating (maximum) Total no of rating value
 * @param  $rating_none_img  None rating images
 * @param  $rating_full_img  Rating images for rating path
 * @return  $rating_avg_img Average rating img path
 */
function aoi_post_rating_result($ratings_post_id, $total_rating, $rating_none_img, $rating_full_img, $rating_avg_img){
	
	$total_no_of_avg = get_post_meta($ratings_post_id, 'aio_average_rating', true);
	$total_no_of_avg_loop = 0;
	$avg_loop_half_rating = 0;	
		
	$total_no_of_avg_flaot_val = explode('.',$total_no_of_avg);
	$total_no_of_avg_flaot_val_point_val = end($total_no_of_avg_flaot_val);	
	
	if($total_no_of_avg_flaot_val_point_val >= 50  ){
		$avg_loop_half_rating = $total_no_of_avg_flaot_val[0] + 1;
	}
	
	if(empty($avg_loop_half_rating)){
		$total_no_of_avg_loop = $total_no_of_avg_flaot_val[0]; 
	}else{
		$total_no_of_avg_loop = $avg_loop_half_rating; 
	}
	
	//display Template variable
	$AOI_all_ready_rate_template = get_option('AOI_all_ready_rate_template');
	$AIO_RATING_IMAGES = '';
	$AIO_TOTAL_RATINGS = $total_rating;
	$AIO_RATINGS_SCORE = get_post_meta($ratings_post_id, 'aio_total_rating',true);
	$AIO_TOTAL_NO_RAT = get_post_meta($ratings_post_id, 'aio_rating_count',true);
	$AIO_RATINGS_AVERAGE = $total_no_of_avg;	
	$currentuser_allow_to_rate ='';
	// check user already rated this post.	
	$currentuser_allow_to_rate = Rating_Restriction_to_user($ratings_post_id);

	if(!empty($currentuser_allow_to_rate)){
		for($i=1; $i <= $total_rating; $i++){
					//** Rating half img
					if(!empty($avg_loop_half_rating)) {
						if($i <= $total_no_of_avg_loop ){
							if($i == $avg_loop_half_rating ){
								$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_avg_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" onclick="give_rate('.$ratings_post_id.', '.$i.');" 	onmouseover="aio_rating_hover('.$ratings_post_id.', '.$i.');" onmouseout="aio_rating_none('.$ratings_post_id.', '.$i.');" data-img-name="avg_rating" >';
								
							}else{							
								$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_full_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" onclick="give_rate('.$ratings_post_id.', '.$i.');"  onmouseover="aio_rating_hover('.$ratings_post_id.', '.$i.');" onmouseout="aio_rating_none('.$ratings_post_id.', '.$i.');" data-img-name="rating_full" >';
							}
						}else{						
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_none_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" onclick="give_rate('.$ratings_post_id.', '.$i.');" 	onmouseover="aio_rating_hover('.$ratings_post_id.', '.$i.');" onmouseout="aio_rating_none('.$ratings_post_id.', '.$i.');" data-img-name="rating_none" >';
						}
					}else{
						if($i <= $total_no_of_avg_loop ){
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_full_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" onclick="give_rate('.$ratings_post_id.', '.$i.');"  onmouseover="aio_rating_hover('.$ratings_post_id.', '.$i.');" onmouseout="aio_rating_none('.$ratings_post_id.', '.$i.');"  data-img-name="rating_full">';
						}else{
						
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_none_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" onclick="give_rate('.$ratings_post_id.', '.$i.');" 				onmouseover="aio_rating_hover('.$ratings_post_id.', '.$i.');" onmouseout="aio_rating_none('.$ratings_post_id.', '.$i.');"  data-img-name="rating_none" >';
						}
					}
			}
	}else{
		for($i=1; $i <= $total_rating; $i++){
					//** Rating half img
					if(!empty($avg_loop_half_rating)) {
						if($i <= $total_no_of_avg_loop ){
							if($i == $avg_loop_half_rating ){
								$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_avg_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" >';								
							}else{							
								$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_full_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" >';							}
						}else{						
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_none_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'"  >';
						}
					}else{
						if($i <= $total_no_of_avg_loop ){
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_full_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" >';
						}else{						
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_none_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" >';
						}
					}
			}
	}

	$AOI_all_ready_rate_template  = str_replace('<<%AIO_RATING_IMAGES%>>',$AIO_RATING_IMAGES,$AOI_all_ready_rate_template);
	$AOI_all_ready_rate_template  = str_replace('<<%AIO_TOTAL_RATINGS%>>',$AIO_TOTAL_RATINGS,$AOI_all_ready_rate_template);
	$AOI_all_ready_rate_template  = str_replace('<<%AIO_RATINGS_SCORE%>>',$AIO_RATINGS_SCORE,$AOI_all_ready_rate_template);
	$AOI_all_ready_rate_template  = str_replace('<<%AIO_TOTAL_NO_RAT%>>',$AIO_TOTAL_NO_RAT,$AOI_all_ready_rate_template);
	$AOI_all_ready_rate_template  = str_replace('<<%AIO_RATINGS_AVERAGE%>>',$AIO_RATINGS_AVERAGE,$AOI_all_ready_rate_template);
	echo $AOI_all_ready_rate_template;
			
}

/**
 * First time user rating img displayed
 * @param  $ratings_post_id Current post or tag/category id
 * @param  $total_rating (maximum) Total no of rating value
 * @param  $rating_none_img  None rating images
 * @param  $rating_full_img  Rating images for rating path
 * @return  $rating_avg_img Average rating img path
 */

function  aoi_post_rating_none($ratings_post_id, $total_rating, $rating_none_img, $rating_full_img, $rating_avg_img){
	
	$AOI_postratings_none_template = get_option('AOI_postratings_none_template');
	$AIO_RATING_IMAGES = '';
	$AIO_TOTAL_RATINGS = 0;
	$AIO_RATINGS_SCORE = 0;
	$AIO_TOTAL_NO_RAT = 0;
	$AIO_RATINGS_AVERAGE = 0;
	
	for($i=1; $i <= $total_rating; $i++){
	$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_none_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'" onclick="give_rate('.$ratings_post_id.', '.$i.');" onmouseover="aio_rating_hover('.$ratings_post_id.', '.$i.');" onmouseout="aio_rating_none('.$ratings_post_id.', '.$i.');"  >';
	}
 


	$AOI_postratings_none_template  = str_replace('<<%AIO_RATING_IMAGES%>>',$AIO_RATING_IMAGES,$AOI_postratings_none_template);
	$AOI_postratings_none_template  = str_replace('<<%AIO_TOTAL_RATINGS%>>',$AIO_TOTAL_RATINGS,$AOI_postratings_none_template);
	$AOI_postratings_none_template  = str_replace('<<%AIO_RATINGS_SCORE%>>',$AIO_RATINGS_SCORE,$AOI_postratings_none_template);
	$AOI_postratings_none_template  = str_replace('<<%AIO_TOTAL_NO_RAT%>>',$AIO_TOTAL_NO_RAT,$AOI_postratings_none_template);
	$AOI_postratings_none_template  = str_replace('<<%AIO_RATINGS_AVERAGE%>>',$AIO_RATINGS_AVERAGE,$AOI_postratings_none_template);
	echo $AOI_postratings_none_template;
	
}

/**
 * User given rating sucessfully then this function will run and this rating Templated will displayed
 * @param  $ratings_post_id Current post or tag/category id
 * @param  $total_no_of_avg rating avarage 
 * @param  $aio_total_rating  Total no of user voted on this post (no of vote counter)
 * @param  $aio_rating_count  count of given user rating 
 */

function sucessfully_rating($ratings_post_id, $total_no_of_avg, $aio_total_rating, $aio_rating_count){
	
	//After User Rating Templates show	
	$total_rating = (int) get_option('total_rating');
	$total_no_of_avg_loop = 0;
	$avg_loop_half_rating = 0;
	
	$total_no_of_avg_flaot_val = explode('.',$total_no_of_avg);
	$total_no_of_avg_flaot_val_point_val = end($total_no_of_avg_flaot_val);
	
	if($total_no_of_avg_flaot_val_point_val >= 50  ){
		$avg_loop_half_rating = $total_no_of_avg_flaot_val[0] + 1;
	}
	
	if(empty($avg_loop_half_rating)){
		$total_no_of_avg_loop = $total_no_of_avg_flaot_val[0];
	}else{
		$total_no_of_avg_loop = $avg_loop_half_rating;
	}
	
	//Get_img path 
	if('custom' == get_option('rating_img_name') ){
	 		$rating_none_img = get_option('rating_none');
			$rating_full_img = get_option('rating_full');
			$rating_avg_img = get_option('rating_avg');
			$rating_hover_img = get_option('rating_hover');
	 	}else{
	 		$img_path = plugins_url('/images/rating/', __FILE__ ).'star/';
	 		$img_path = str_replace('includes/','',$img_path);
			$rating_none_img = $img_path.'rating_none.png';
			$rating_full_img = $img_path.'rating_full.png';
			$rating_avg_img = $img_path.'rating_avg.png';
			$rating_hover_img = $img_path.'rating_hover.png';
	 	}
	
	//display Template variable
	$AOI_after_user_rating_template = get_option('AOI_after_user_rating_template');
	$AIO_RATING_IMAGES = '';
	$AIO_TOTAL_RATINGS = $total_rating;
	$AIO_RATINGS_SCORE = $aio_total_rating;
	$AIO_TOTAL_NO_RAT = $aio_rating_count;
	$AIO_RATINGS_AVERAGE = $total_no_of_avg;

	for($i=1; $i <= $total_rating; $i++){ 
				//** Rating half img 
				if(!empty($avg_loop_half_rating)) {
					if($i <= $total_no_of_avg_loop ){
						if($i == $avg_loop_half_rating ){
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_avg_img.'"  alt="rating_'.$i.'" >';
						}else{
							$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_full_img.'"  alt="rating_'.$i.'" >';
						}
					}else{
					
						$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_none_img.'"  alt="rating_'.$i.'"  >';	
					}
				}else{
					if($i <= $total_no_of_avg_loop ){
						$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_full_img.'"  alt="rating_'.$i.'" data-rat="'.$i.'">';
					}else{
						$AIO_RATING_IMAGES .= '<img id="'.$ratings_post_id.'_'.$i.'" src="'.$rating_none_img.'"  alt="rating_'.$i.'" >';
					}
				}
		}

	$AOI_after_user_rating_template  = str_replace('<<%AIO_RATING_IMAGES%>>',$AIO_RATING_IMAGES,$AOI_after_user_rating_template);
	$AOI_after_user_rating_template  = str_replace('<<%AIO_TOTAL_RATINGS%>>',$AIO_TOTAL_RATINGS,$AOI_after_user_rating_template);
	$AOI_after_user_rating_template  = str_replace('<<%AIO_RATINGS_SCORE%>>',$AIO_RATINGS_SCORE,$AOI_after_user_rating_template);
	$AOI_after_user_rating_template  = str_replace('<<%AIO_TOTAL_NO_RAT%>>',$AIO_TOTAL_NO_RAT,$AOI_after_user_rating_template);
	$AOI_after_user_rating_template  = str_replace('<<%AIO_RATINGS_AVERAGE%>>',$AIO_RATINGS_AVERAGE,$AOI_after_user_rating_template);
	echo $AOI_after_user_rating_template;
}

/**
 * This function will check rating user if user will access to rating than return true otherwise return none
 *
 * @param $user_ID get user id on parameter on this fuction we have check user access to rating admin setting 
 * @return if user will allow to rating then return true otherwise it will return none
 */

function Allow_To_Rate($user_ID = 0 ){
	$postratings_allow_to	= get_option('postratings_allow_to');
	$allow_rating = '';
	switch ($postratings_allow_to) {
    case 1:
        //Allo to only Guests Only 
        if(empty($user_ID)) $allow_rating ='true';
        break;
    case 2:
        //Allo to only User Only 
        if(!empty($user_ID)) $allow_rating ='true';
        break;
    case 3:
        //Allo to Guest and user both
        $allow_rating ='true';
        break;
	}
	
	return $allow_rating;
}


/**
 * check user tating ristriction to post and tag/category
 *
 * @param $post_ID curent post/cat/tag id
 * @return  if user will allow to rating than return ture otherwise return false
 */
function Rating_Restriction_to_user($post_ID = 0){
	global $wpdb, $user_ID;
	$table_name = $wpdb->prefix . "all_in_one_post_ratings";
	$rating_restriction = '';
	$postratings_user_type	= get_option('postratings_user_type');

	switch ($postratings_user_type) {
	    case 1:       
	       // $postratings_user_type = 1  then only one time one User will allow to rating       
	       $results = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE userid = $user_ID and postid = $post_ID ");	       
	       
	       if(empty($results) && $results <= 0){$rating_restriction =  'true';}
	       break;
	       
	    case 2:
	    	// $postratings_user_type = 2 one IP address will allow to one time rating
	    	$user_ip = users_ipaddress();
	       	$results = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE ip = '$user_ip' and postid = $post_ID ");
	       	if(empty($results) && $results <= 0){$rating_restriction =  'true';}	       	
	       	break;
	    case 3:
	    	// $postratings_user_type = 3 days wise allow to rating
	    	$rating_restric_day	= get_option('rating_restric_day');	
	    	$user_ip = users_ipaddress();
	       	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE ip = '$user_ip' and postid = $post_ID limit 0,1",ARRAY_A) ;
	       	
	       	if(count($results) > 0 && !empty($results[0]['timestamp'])){	    	
	    		$rating_date = $results[0]['timestamp'];
	    		//$rating_date = date('Y-m-d H:i:s',$time);
	    		$current_date = date('Y-m-d H:i:s');
	    		$date_between = (strtotime($current_date) - strtotime($rating_date));
				$date_between = floor($date_between/3600/24);
				if($rating_restric_day <= $date_between ){
					$rating_restriction =  'true';
				}				
	       	}
	        break;
		}
	
	return $rating_restriction;	
}
?>