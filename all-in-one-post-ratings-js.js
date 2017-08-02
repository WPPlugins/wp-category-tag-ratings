
$=jQuery;

function aio_rating_hover(post_id,rat){
	var curent_img = $('#'+post_id+'_'+rat).attr('src');
	//curent_img = curent_img.replace(aio_rating.img, aio_rating.img_hover);
	for (i = 1; i <= rat; i++) {
		$('#'+post_id+'_'+i).attr('src',aio_rating.rating_hover);
	}
}

function aio_rating_none(post_id,rat){
	var curent_img = $('#'+post_id+'_'+rat).attr('src');
	//curent_img = curent_img.replace(aio_rating.img_hover,aio_rating.img);
	
	for (i = 1; i <= rat; i++) {
		var old_img = $('#'+post_id+'_'+i).attr('data-img-name');
		if('avg_rating' == old_img ){
			$('#'+post_id+'_'+i).attr('src',aio_rating.rating_avg);
		}else if('rating_full' == old_img ){
			$('#'+post_id+'_'+i).attr('src',aio_rating.rating_full);			
		}else{
			$('#'+post_id+'_'+i).attr('src',aio_rating.rating_none);
		}
	}
}
function give_rate(post_id,rat){
	aio_rating_hover(post_id,rat)
	
	$('div#all-in-one-rating div#aio-rating-loader').show();
	//alert(post_id+','+rat);
	jQuery.ajax({		
	  type:"POST",
	  url: aio_rating.ajax_url,	  
	  data: {
	      'action' : 'user_rating_data',
	      'post_id' : post_id,
	      'user_rat' : rat
	  },
	  success:function(data){	  	
	  	$('div#all-in-one-rating div#aio-rating-loader').hide();
		  	$('div#all-in-one-rating').html(data);
	  }
	}); 
}