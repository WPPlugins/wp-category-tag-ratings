<?php
/**
 * Display rating on page.
 *
 */
function display_rating_functiona_own(){	
	/**
	 * get AOI post rating template
	 */
	
	$AOI_postratings_none_template = get_option('AOI_postratings_none_template');
	if(empty($AOI_postratings_none_template)) $AOI_postratings_none_template = '<<%AIO_RATING_IMAGES%>><br>
 ( No Ratings Yet )';
	
	$AOI_all_ready_rate_template = get_option('AOI_all_ready_rate_template');
	if(empty($AOI_all_ready_rate_template)) $AOI_all_ready_rate_template = '<<%AIO_RATING_IMAGES%>><br>
 ( <<%AIO_TOTAL_NO_RAT%>> votes, average: <<%AIO_RATINGS_AVERAGE%>> out of <<%AIO_TOTAL_RATINGS%>> )';
	
	$AOI_after_user_rating_template = get_option('AOI_after_user_rating_template');
	if(empty($AOI_after_user_rating_template)) $AOI_after_user_rating_template = '<<%AIO_RATING_IMAGES%>><br>
 ( <<%AIO_TOTAL_NO_RAT%>> votes, average: <<%AIO_RATINGS_AVERAGE%>> out of <<%AIO_TOTAL_RATINGS%>> )';
	      	
      		
?>

<div class="wrap">
	<h2>Post Ratings Display</h2>
	<br>
	<div id="admin-notification" class="post-rating_notification"></div>
		<table class="form-table">			
			 <tr>
				<td width="30%">
					<h3>First time user rating Templates</h3>
					<strong>Variables:</strong><br><br>
					<p style="margin: 2px 0"> <<%AIO_RATING_IMAGES%>> </p>
					<p style="margin: 2px 0"> <<%AIO_TOTAL_RATINGS%>> </p>
					<p style="margin: 2px 0"> <<%AIO_RATINGS_SCORE%>> </p>
					<p style="margin: 2px 0"> <<%AIO_TOTAL_NO_RAT%>> </p>
					<p style="margin: 2px 0"> <<%AIO_RATINGS_AVERAGE%>></p>				
				</td>
				<td>
				<textarea cols="80" rows="8" id="AOI_postratings_none_template" name="AOI_postratings_none_template"><?php echo $AOI_postratings_none_template; ?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%">
					<h3>Already Rating Templates</h3>
					<strong>Variables:</strong><br><br>
					<p style="margin: 2px 0"> <<%AIO_RATING_IMAGES%>> </p>
					<p style="margin: 2px 0"> <<%AIO_TOTAL_RATINGS%>> </p>
					<p style="margin: 2px 0"> <<%AIO_RATINGS_SCORE%>> </p>
					<p style="margin: 2px 0"> <<%AIO_TOTAL_NO_RAT%>> </p>
					<p style="margin: 2px 0"> <<%AIO_RATINGS_AVERAGE%>></p>				
				</td>
				<td>
				<textarea cols="80" rows="8" id="AOI_all_ready_rate_template" name="AOI_all_ready_rate_template"><?php echo $AOI_all_ready_rate_template; ?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%">
					<h3>After User Rating the Post</h3>
					<strong>Variables:</strong><br><br>
					<p style="margin: 2px 0"> <<%AIO_RATING_IMAGES%>> </p>
					<p style="margin: 2px 0"> <<%AIO_TOTAL_RATINGS%>> </p>
					<p style="margin: 2px 0"> <<%AIO_RATINGS_SCORE%>> </p>
					<p style="margin: 2px 0"> <<%AIO_TOTAL_NO_RAT%>> </p>
					<p style="margin: 2px 0"> <<%AIO_RATINGS_AVERAGE%>></p>				
				</td>
				<td>
				<textarea cols="80" rows="8" id="AOI_after_user_rating_template" name="AOI_after_user_rating_template"><?php echo $AOI_after_user_rating_template;?></textarea>
				</td>
			</tr>		
			</table>
			<p class="submit"><input type="submit" name="Submit" class="button-primary aio-btn-submit-for-display" value="Save Changes"></p>
			<a href="#" class="wp-core-ui button" id="default-template">Default Template</a>
</div>	

<?php
}
function rating_option_functiona_own(){ 
/**
 * get all option valuse 
 */

$rating_img_name	= get_option('rating_img_name');
if(empty($rating_img_name)) $rating_img_name = 'star';

$google_rich = get_option('google_rich');
if(empty($google_rich)) $google_rich='on';

$total_rating	= get_option('total_rating');
if(empty($total_rating)) $total_rating = 5;

$postratings_allow_to	= get_option('postratings_allow_to');
if(empty($postratings_allow_to)) $postratings_allow_to = 3;

$postratings_user_type	= get_option('postratings_user_type');
if(empty($postratings_user_type)) $postratings_user_type = 2;

$rating_restric_day	= get_option('rating_restric_day');
if(empty($rating_restric_day)) $rating_restric_day = 1;

$AOI_custom_css	= get_option('AOI_custom_css');

$aio_rating_loader	= get_option('aio_rating_loader');



// custom rating images

$rating_none_img = get_option('rating_none');
$sample_rating_none_img = (empty($rating_none_img)) ? plugins_url()."/wp-category-tag-ratings/images/rating/star/rating_none.png" : $rating_none_img ;


$rating_full_img = get_option('rating_full');
$sample_rating_full_img = (empty($rating_full_img)) ? plugins_url()."/wp-category-tag-ratings/images/rating/star/rating_full.png" : $rating_full_img ;


$rating_hover_img = get_option('rating_hover');
$sample_rating_hover_img = (empty($rating_hover_img)) ? plugins_url()."/wp-category-tag-ratings/images/rating/star/rating_hover.png" : $rating_hover_img;


$rating_avg_img = get_option('rating_avg');
$sample_rating_avg_img = (empty($rating_avg_img)) ? plugins_url()."/wp-category-tag-ratings/images/rating/star/rating_avg.png": $rating_avg_img;

global $wpdb;  
$current_user = wp_get_current_user();
if (!get_option('ctr_plugin_notice_shown')) {
	 echo '<div id="ctr_dialog" title="Basic dialog"><p>Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p> <p><input type="text" id="txt_user_sub_ctr" class="regular-text" name="txt_user_sub_ctr" value="'.$current_user->user_email.'"></p></div>';
}

?>

<div class="wrap">
	<h2>Post Ratings Options</h2>	
	<form method="post" action="">		
		<h3>Ratings Settings</h3>
		<div class="post-rating_notification"></div>
		<div id="rating_option_wrapper">
		
			<div class="wrapper-left-area">
				<table class="form-table">				
				<tr>
					<td class="h_title">Rating Images</td>
					<td class="admin_rating_img">
						
						<p class="rating-radio"> <input type="radio" name="postratings_image" onclick="" value="star" <?php if('star' == $rating_img_name) { echo 'checked="checked"';} ?>></p>
						<p>
						<img src="<?php echo plugins_url();?>/wp-category-tag-ratings/images/rating/star/star.png" alt="star rating">
						</p></td>						
				</tr>
				<tr>
					<td class="h_title">Custom Rating Images</td>
					<td class="admin_rating_img">
					<p class="rating-radio"><input type="radio" name="postratings_image" onclick="" value="custom" <?php if('custom' == $rating_img_name) { echo 'checked="checked"';} ?>></p>
					<?php 
						if(get_option('rating_none')){
						echo "<p>";						
							for ($i =1; $i <= $total_rating; $i++){
								if($i <= 2){
									echo '<img src="'.$rating_full_img.'" alt="custom rating">';
								}else{
									echo '<img src="'.$rating_none_img.'" alt="custom rating">';
								}
							}						
						echo "</p>";
						}else{
							echo '<p><img src="'.plugins_url().'/wp-category-tag-ratings/images/rating/heart/heart.png" alt="custom rating"></p>';
						}
						?>
					</td>
				</tr>				
				<tr class="csutom_rating_img <?php if('custom' == $rating_img_name) { echo 'custom-active';} ?>">
					<td class="h_title">No Rating Images</td>
					<td>
					<div class="custom-img-uploding-wrapper">
						<span class="example-img">Ex: 
							<img src="<?php echo $sample_rating_none_img;?>" alt="custom rating">
						</span>
						<span class="custom_img_input_box"><input id="rating_none" name="rating_none" type="text" class="custom_image_url_upload" value="<?php echo $rating_none_img;?>"></span>
					 </div>
					 <p class="admin_suggestion"><span id="admin_suggestion">we recommended rating image width 25px</span></p>
					 </td>
					 
				</tr>
				<tr class="csutom_rating_img <?php if('custom' == $rating_img_name) { echo 'custom-active';} ?>">
					<td class="h_title">Full Rating Images</td>
					<td>
					<div class="custom-img-uploding-wrapper">
						<span class="example-img">Ex: 
							<img  src="<?php echo $sample_rating_full_img;?>" alt="custom rating">
						</span>
						<span class="custom_img_input_box"><input id="rating_full" type="text" name="rating_full" class="custom_image_url_upload" value="<?php echo $rating_full_img;?>"></span>
					 </div>
					 <p class="admin_suggestion"><span id="admin_suggestion">we recommended rating image width 25px</span></p>
					</td>
				</tr>
				<tr class="csutom_rating_img <?php if('custom' == $rating_img_name) { echo 'custom-active';} ?>">
					<td class="h_title">Hover Images</td>
					<td>
					<div class="custom-img-uploding-wrapper">
						<span class="example-img">Ex: 
							<img  src="<?php echo $sample_rating_hover_img;?>" alt="custom rating">
						</span>
						<span class="custom_img_input_box"><input id="rating_hover" type="text" name="rating_hover" class="custom_image_url_upload" value="<?php echo $rating_hover_img;?>"></span>
					 </div>
					 <p class="admin_suggestion"><span id="admin_suggestion">we recommended rating image width 25px</span></p>
					</td>
				</tr>				
				<tr class="csutom_rating_img <?php if('custom' == $rating_img_name) { echo 'custom-active';} ?>">
					<td class="h_title">Average rating Images</td>
					<td>
					<div class="custom-img-uploding-wrapper">
						<span class="example-img">Ex:
						<img  src="<?php echo $sample_rating_avg_img;?>" alt="custom rating">
						</span>
						<span class="custom_img_input_box"><input id="rating_avg" type="text" name="rating_avg" class="custom_image_url_upload" value="<?php echo $rating_avg_img;?>"></span>
					 </div>
					 <p class="admin_suggestion"><span id="admin_suggestion">we recommended rating image width 25px</span></p>
					</td>
				</tr>
				<tr>
					<td class="h_title">Max Ratings:</td>
					<td><input type="text" name="no_of_rating" value="<?php echo $total_rating;?>" class="num-error-val" maxlength="5" onkeyup="this.value = minmax(this.value, 3, 100)"> <span id="num-error-msg"></span></td>
				</tr>
				<tr>
					<td class="h_title">Enable Google Rich Snippets</td>
					<td>
					
					<input type="radio" name="google_rich" onclick="" value="on" <?php if('on' == $google_rich ){echo 'checked="checked"';}?> > ON &nbsp;&nbsp;&nbsp; 
					<input type="radio" name="google_rich" onclick=""   value="off" <?php if('off' == $google_rich ){echo 'checked="checked"';}?>> OFF</td>
				</tr>
				<tr>
					<td class="h_title">Who is Allow To Rate</td>
					<td>
						<select id="postratings_allow_to" name="postratings_allow_to" size="1">
						<option value="1" <?php if(1 == $postratings_allow_to ){echo 'selected="selected"';}?>>Guest Only</option>
						<option class="aio-rating-user" value="2" <?php if(2 == $postratings_allow_to ){echo 'selected="selected"';}?>>Users Only</option>
						<option value="3" <?php if(3 == $postratings_allow_to ){echo 'selected="selected"';}?>>Users And Guest</option>
					</select></td>
				</tr>
				<tr>
					<td class="h_title">Rating Registration Method</td>
					<td>
						<div id="post_ratings_ristric_to"> 
						<select id="post_ratings_ristric_type" name="postratings_ristric_to" size="1">						
						<option class="aio-rating-user" value="1" <?php if(1 == $postratings_user_type ){echo 'selected="selected"';}?>>User</option>
						<option value="2" <?php if(2 == $postratings_user_type ){echo 'selected="selected"';}?>>IP address</option>
						<option value="3" <?php if(3 == $postratings_user_type ){echo 'selected="selected"';}?>>days</option>
						</select>
						</div>
					<input type="text" value="<?php echo $rating_restric_day;?>" <?php  if(3 != $postratings_user_type ){ echo 'style="display:none"';} ?>" name="rating_restric_day" id="post_rating_restric_day" class="num-error-val"> <span id="num-error-msg"></span>
					</td>
				</tr>
				
				<tr>
					<td class="h_title custom_css_title">Custom CSS </td>
					<td>
					<textarea cols="80" rows="8" id="AOI_custom_css" name="AOI_custom_css"><?php echo $AOI_custom_css;?></textarea>
					</td>
				</tr>
				<tr>
					<td class="h_title">Loader image </td>
					<td>
					<div class="custom-img-uploding-wrapper">						
						<span><input id="aio_rating_loader" name="aio_rating_loader" type="text" class="custom_image_url_upload" value="<?php echo $aio_rating_loader;?>"></span>
						<span class="default-loader">X</span>
					 </div>
					</td>
				</tr>		
				</table>				
			</div>
			<div id="post-rating-loader"></div>
		</div>		
	</form>
	<p class="submit"><input type="submit" name="Submit" class="button-primary btn-submit" value="Save Changes"></p>	
</div>
<?php } ?>