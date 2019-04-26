<?php
/**
 * Front End Item Filters Page Controller
 * 
 */
include_once( APPPATH .'controllers/Main.php' );

class NewsFeed extends Main
{
	// theme folder name
	protected $theme;

	// data object to pass to view
	protected $data;

	// feeds limit to show 
	protected $limit;

	// fav and like item limit
	protected $fav_limit;

	/**
	 * Constructs required data
	 * 
	 */
	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );
		$this->theme = "templates/front-end/";
		$this->limit = 5;
		$this->fav_limit = 5;

		$this->data['dir'] = $this->theme;
		$this->data['page_id'] = 'news-feeds';
		$this->data['limit'] = $this->limit;
	}

	/**
	 * News Feeds LIst
	 */
	function index( $city_id = 0 )
	{
		/* load feeds */
		$feeds = $this->feed->get_all_published( $city_id, $this->limit )->result();
		foreach ($feeds as $feed) {
			$this->get_feed_images($feed);
		}
		$this->data['feeds'] = $feeds;

		$this->data['city_id'] = $city_id;
		$this->load_sidebar_data( $city_id );

		/* load views */
		$this->data['feeds_cover'] = true;
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'nav' );
		$this->load->view( $this->theme .'feeds' );
		$this->load->view( $this->theme .'footer' );
	}

	function load_more_feeds( $city_id, $start )
	{
		$feeds = $this->feed->get_all_published( $city_id, $this->limit, $start )->result();

		if ( count( $feeds )) {
			foreach ($feeds as $feed) {
				$this->get_feed_images($feed);
			}

			$this->load->view( $this->theme .'feed-list', array( 'feeds' => $feeds ));
		}
	}

	function has_more_feeds( $city_id, $start )
	{
		$count = $this->feed->count_all_published( $city_id, $this->limit, $start );

		if ( $count > 0 ) echo "true";
		else echo "false";
	}

	/**
	 * News Feeds Detail
	 */
	function detail( $feed_id = 0 )
	{
		/* get feed info */
		$feed = $this->feed->get_info( $feed_id );
		$this->get_feed_images( $feed );
		$this->data['feed'] = $feed;

		$this->load_sidebar_data( $feed->city_id );

		/* load view */
		/* load views */
		$this->data['feeds_cover'] = true;
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'nav' );
		$this->load->view( $this->theme .'feed-detail' );
		$this->load->view( $this->theme .'footer' );
	}

	/**
	 * loads sidebar data
	 */
	function load_sidebar_data( $city_id )
	{
		/* loads favourites */
		$favs = $this->favourite->get_all_by( $city_id, array(), $this->fav_limit )->result();
		$this->data['favourites'] = $favs;

		$likes = $this->like->get_all_by( $city_id, array(), $this->fav_limit )->result();
		$this->data['likes'] = $likes;
	}

	/**
	 * Gets the feed images.
	 *
	 * @param      <type>  $feed   The feed
	 */
	function get_feed_images(&$feed)
	{
		$feed->title = html_entity_decode( $feed->title );
		$feed->description = html_entity_decode( $feed->description );
		$feed->added = $this->ago( $feed->added );
		$feed->images = $this->image->get_all_by_type( $feed->id, 'feed' )->result();
	}
	
	/**
	 * () minutes ago calculation
	 *
	 * @param      integer  $time   The time
	 *
	 * @return     string   ( description_of_the_return_value )
	 */
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
}