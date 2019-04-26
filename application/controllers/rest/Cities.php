<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Cities extends REST_Controller
{
	function get_get()
	{
		$data = null;
		
		$id = $this->get('id');

		if ($id) {
			$city = $this->city->get_info($id);
			if($this->image->get_cover_image($city->id,'city')->path != ""){
				$city->cover_image_file = $this->image->get_cover_image($city->id,'city')->path;
			} else {
				$city->cover_image_file = "default_image_city.png";
			}
			
			if($this->image->get_cover_image($city->id,'city')->width != ""){
				$city->cover_image_width = $this->image->get_cover_image($city->id,'city')->width;
			} else {
				$city->cover_image_width = "600";
			}
			
			if($this->image->get_cover_image($city->id,'city')->height != ""){
				$city->cover_image_height = $this->image->get_cover_image($city->id,'city')->height;
			} else {
				$city->cover_image_height = "400";
			}
			$city->categories = $this->get_categories($id); 
			$city->name = html_entity_decode($city->name);
			$city->description = html_entity_decode($city->description);
			
			$data = $city;
		} else {
			$cities = $this->city->get_all()->result();
			foreach ($cities as $city) {
				$city->item_count = $this->item->count_all($city->id);
				$city->category_count = $this->category->count_all_by($city->id);
				$city->sub_category_count = $this->sub_category->count_all_by($city->id);
				
				$city->follow_count = $this->follow->count_all($city->id);
				
				if($this->image->get_cover_image($city->id,'city')->path != ""){
					$city->cover_image_file = $this->image->get_cover_image($city->id,'city')->path;
				} else {
					$city->cover_image_file = "default_image_city.png";
				}
				
				if($this->image->get_cover_image($city->id,'city')->width != ""){
					$city->cover_image_width = $this->image->get_cover_image($city->id,'city')->width;
				} else {
					$city->cover_image_width = "600";
				}
				
				if($this->image->get_cover_image($city->id,'city')->height != ""){
					$city->cover_image_height = $this->image->get_cover_image($city->id,'city')->height;
				} else {
					$city->cover_image_height = "400";
				}
				
				$city->cover_image_description = $this->image->get_cover_image($city->id,'city')->description;
				$city->categories = $this->get_categories($city->id);	
				$city->name = html_entity_decode($city->name);
				$city->description = html_entity_decode($city->description);				
			}
			$data = $cities;
		}
		
		$this->response(array(
			'status'=>'success',
			'data'	=>$data)
		);
		
	}
	
	function get_categories($city_id)
	{
		$cats = $this->category->get_only_publish($city_id)->result();
		foreach ($cats as $cat) {
			
			$cat->name = html_entity_decode($cat->name);
			
			if($this->image->get_cover_image($cat->id,'category')->path != "") {
				$cat->cover_image_file = $this->image->get_cover_image($cat->id,'category')->path;
			} else {
				$cat->cover_image_file = "default_image_cat.png";
			}
			if($this->image->get_cover_image($cat->id,'category')->width != "") {
				$cat->cover_image_width = $this->image->get_cover_image($cat->id,'category')->width;
			} else {
				$cat->cover_image_width = "400";
			}
			if($this->image->get_cover_image($cat->id,'category')->height != "") {
				$cat->cover_image_height = $this->image->get_cover_image($cat->id,'category')->height;
			} else {
				$cat->cover_image_height = "200";
			}
			
			$cat->sub_categories = $this->get_sub_categories($city_id, $cat->id);
		}
		
		return $cats;
	}
	
	function get_sub_categories($city_id, $cat_id)
	{
		$sub_cats = $this->sub_category->get_all_by_cat_id($cat_id,"id","asc")->result();
		foreach ($sub_cats as $sub_cat) {
			$sub_cat->name = html_entity_decode($sub_cat->name);
			if($this->image->get_cover_image($sub_cat->id,'sub_category')->path != "") {
				$sub_cat->cover_image_file   = $this->image->get_cover_image($sub_cat->id,'sub_category')->path;
			} else {
				$sub_cat->cover_image_file = "default_image_subcat.png";
			}
			
			if($this->image->get_cover_image($sub_cat->id,'sub_category')->width != "") {
				$sub_cat->cover_image_width  = $this->image->get_cover_image($sub_cat->id,'sub_category')->width;
			} else {
				$sub_cat->cover_image_width = "400";
			}
			
			if($this->image->get_cover_image($sub_cat->id,'sub_category')->height != "") {
				$sub_cat->cover_image_height = $this->image->get_cover_image($sub_cat->id,'sub_category')->height;
			} else {
				$sub_cat->cover_image_height = "200";
			}
			
		}
		
		
		return $sub_cats;
	}
	
	function get_items($city_id, $sub_cat_id)
	{
		$all = $this->get('item');
		$count = $this->get('count');
		$from = $this->get('from');
		$keyword = "";
		if ($this->get('keyword')) {
			$keyword = $this->get('keyword');
		}
					
		if (!$all) {
			$items = $this->item->get_all_by_sub_cat($sub_cat_id, $keyword, 3)->result();
		} else {
			if ($count && $from) {
				$items = $this->item->get_all_by_sub_cat($sub_cat_id, $keyword, $count, $from)->result();
			} else if ($count) {
				$items = $this->item->get_all_by_sub_cat($sub_cat_id, $keyword, $count)->result();
			} else {
				$items = $this->item->get_all_by_sub_cat($sub_cat_id, $keyword)->result();
			}
		}
		
		$i = 0;
		foreach ($items as $item) {
			$items[$i]->images = $this->image->get_all_by_item($item->id)->result();
			$items[$i]->like_count = $this->like->count_all($city_id, $item->id);
			$items[$i]->review_count = $this->review->count_all($city_id, $item->id);
			$items[$i]->inquiries_count = $this->inquiry->count_all($city_id, $item->id);
			$items[$i]->touches_count = $this->touch->count_all($city_id, $item->id);
			
			$reviews = array();
			$j = 0;
			foreach ($this->review->get_all_by_item_id($item->id)->result() as $review) {
				$reviews[$j] = $review;
				$reviews[$j]->added = $this->ago($reviews[$j]->added);
				$appuser = $this->appuser->get_info($review->appuser_id);
				$reviews[$j]->appuser_name = $appuser->username;
				$reviews[$j++]->profile_photo = $appuser->profile_photo;
			}
			
			$items[$i++]->reviews = $reviews;
		}
		
		return $items;
	}
	
	function follow_post()
	{
		$city_id = $this->get('city_id');
		if (!$city_id) {
			$this->response(array('error' => array('message' => 'require_city_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		
		if ($this->follow->exists(array('appuser_id' => $data['appuser_id'], 'city_id' => $city_id))) {
			$this->response(array('error' => array('message' => 'appuser_follow_exist')));
		}
		
		$data = array(
			'appuser_id' => $data['appuser_id'],
			'city_id' => $city_id
		);
		
		$this->follow->save($data);
		$count = $this->follow->count_all($city_id);
		$this->response(array(
			'success'=>'Follow is saved successfully!',
			'total'	=>$count)
		);
	}
	
	
	
	function user_follows_get()
	{
		$user_id = $this->get('user_id');
		if (!$user_id) {
			$this->response(array('error' => array('message' => 'require_user_id')));
		}
		
		$follows = $this->follow->get_by_user_id($user_id)->result();
		if(count($follows)>0){
			$data = array();
			foreach ($follows as $follow) {
				$city = $this->city->get_info($follow->city_id);
				$city->item_count = $this->item->count_all($city->id);
				$city->category_count = $this->category->count_all_by($city->id);
				$city->follow_count = $this->follow->count_all($city->id);
				$city->feed_count = $this->feed->count_all($city->id);
				$city->cover_image_file = $this->image->get_cover_image($city->id,'city')->path;
				$city->cover_image_width = $this->image->get_cover_image($city->id,'city')->width;
				$city->cover_image_height = $this->image->get_cover_image($city->id,'city')->height;
				$city->cover_image_description = $this->image->get_cover_image($city->id,'city')->description;
				$city->feeds = $this->get_each_feed($city->id);
				$data[] = $city;
			}
			$this->response($data);
		} else {
			$this->response(array('error' => array('message' => 'no_follow_cities')));
		}
	}
	
	function get_each_feed($city_id)
	{
		$feeds = $this->feed->get_all($city_id)->result();
		foreach ($feeds as $feed) {
			$feed->id = $feed->id;
			$feed->title = $feed->title;
			$feed->description = $feed->description;
			$feed->added = $this->ago($feed->added);
			$feed->images = $this->image->get_all_by_type($feed->id,"feed")->result();
		}
		
		return $feeds;
	}
		
	function feeds_get()
	{
		$city_id = $this->get('city_id');
		if (!$city_id) {
			$this->response(array(
				'status'=>'error',
				'data'	=> 'Required City ID')
			);
		}
	
		$count = $this->get('count');
		$from = $this->get('from');
	
		$feeds = array();
		if ($count && $from) {
			$feeds = $this->feed->get_all_published($city_id, $count, $from)->result();
		} else if ($count) {
			$feeds = $this->feed->get_all_published($city_id, $count)->result();
		} else {
			$feeds = $this->feed->get_all_published($city_id)->result();
		}
		
		$data = array();
		foreach ($feeds as $feed) {
			$this->get_feed_images($feed);
			$data[] = $feed;
		}
		//$this->response($data);
		$this->response(array(
			'status'=>'success',
			'data'	=> $data)
		);
	}
	
	function get_feed_images(&$feed)
	{
		$feed->added = $this->ago($feed->added);
		$feed->images = $this->image->get_all_by_type($feed->id, 'feed')->result();
	}
	
	function contactus_post()
	{
		$city_id = $this->get('city_id');
		if (!$city_id) {
			$this->response(array('error' => array('message' => 'require_city_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('name', $data)) {
			$this->response(array('error' => array('message' => 'require_name')));
		}
			
		if (!array_key_exists('email', $data)) {
			$this->response(array('error' => array('message' => 'require_email')));
		}
		
		if (!array_key_exists('message', $data)) {
			$this->response(array('error' => array('message' => 'require_message')));
		}
		
		$data = array(
			'name' => $data['name'],
			'email' => $data['email'],
			'message' => $data['message'],
			'city_id' => $city_id,
			'status' => 1
		);
		
		$this->contact->save($data);
		$this->response(array('success'=>'Contact message is saved successfully!'));
	}
	
	function is_follow_post() 
	{
		$city_id = $this->get('city_id');
		if (!$city_id) {
			$this->response(array('error' => array('message' => 'require_city_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		
		if ($this->follow->exists(array('appuser_id' => $data['appuser_id'], 'city_id' => $city_id))) {
			$this->response(array('status'=> 'yes'));
		} else {
			$this->response(array('status'=> 'no'));
		}
		
	}

	function ago($time)
	{
	   $time = mysql_to_unix($time);
	   $now = mysql_to_unix($this->category->get_now());
		
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
	
	   $difference = $now - $time;
	  	$tense = "ago";
	
	   for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	       $difference /= $lengths[$j];
	   }
	
	   $difference = round($difference);
	
	   if ($difference != 1) {
	       $periods[$j].= "s";
	   }
	
	   if ($difference==0) {
	   		return "Just Now";
	   } else {
	   		return "$difference $periods[$j] ago";
	   }
	}
	
	function search_by_geo_get()
	{
		$miles     = $this->get('miles');
		$user_lat  = $this->get('userLat');
		$user_long = $this->get('userLong');
		
		if (!$miles) {
			$this->response(array('error' => array('message' => 'require_miles')));
		}
		
		if (!$user_lat) {
			$this->response(array('error' => array('message' => 'require_user_lat')));
		}
		
		if (!$user_long) {
			$this->response(array('error' => array('message' => 'require_user_long')));
		}
		
		$cities = $this->city->search_by_geo($miles,$user_lat,$user_long)->result();
		foreach ($cities as $city) {
			$city->item_count = $this->item->count_all($city->id);
			$city->category_count = $this->category->count_all_by($city->id);
			$city->follow_count = $this->follow->count_all($city->id);
			$city->cover_image_file = $this->image->get_cover_image($city->id,'city')->path;
			$city->cover_image_width = $this->image->get_cover_image($city->id,'city')->width;
			$city->cover_image_height = $this->image->get_cover_image($city->id,'city')->height;
			$city->cover_image_description = $this->image->get_cover_image($city->id,'city')->description;
			$city->categories = $this->get_categories($city->id);					
		}
		
		$data = $cities;
		
		$this->response($data);
		
	}
	
	function search_by_keyword_post()
	{
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('keyword', $data)) {
			$this->response(array('error' => array('message' => 'require_keyword')));
		}
		
		
		$cities = $this->city->search_by_keyword( $data['keyword'])->result();
		foreach ($cities as $city) {
			$city->item_count = $this->item->count_all($city->id);
			$city->category_count = $this->category->count_all_by($city->id);
			$city->follow_count = $this->follow->count_all($city->id);
			$city->cover_image_file = $this->image->get_cover_image($city->id,'city')->path;
			$city->cover_image_width = $this->image->get_cover_image($city->id,'city')->width;
			$city->cover_image_height = $this->image->get_cover_image($city->id,'city')->height;
			$city->cover_image_description = $this->image->get_cover_image($city->id,'city')->description;
			$city->categories = $this->get_categories($city->id);		
			$city->name = html_entity_decode($city->name);
			$city->description = html_entity_decode($city->description);			
		}
		
		$data = $cities;
		
		$this->response($data);
		
	}
}