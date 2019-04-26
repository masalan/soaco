<?php 
/**
 * default photos base path
 */
// base path
define( 'DEFAULT_PHOTO_PATH', '/images/default_photos/' );
// default city photo
define( 'DEFAULT_CITY_PHOTO', 'city.png' );
// default about photo
define( 'DEFAULT_ABOUT_PHOTO', 'about.png' );
// default cover photo
define( 'DEFAULT_COVER_PHOTO', 'cover.png' );
// default item photo
define( 'DEFAULT_ITEM_PHOTO', 'item.png' );
// default profile photo
define( 'DEFAULT_PROFILE_PHOTO', 'profile.png' );
// default feed photo
define( 'DEFAULT_FEED_PHOTO', 'feed.png' );

/**
 * Validate photo and return default photo if image not exists
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists( 'validate_photos')) {
	function validate_photos( &$photo, $type = 'city' )
	{
		if ( empty( $photo )) {
		// if photo is empty, 
		
			// get the default photo
			$obj = new stdClass;
			$obj->path = get_default_photo( $type );
		 	$photo[] = $obj;
		} else {
		// if photo array is not empty
		
			// modify the path for each photo
			foreach ( $photo as &$p ) {
				$tmp = $p->path;
				$p->path = base_url( '/uploads/'. $tmp );
				$p->thumbnail = base_url( '/uploads/thumbnail/'. $tmp );
			}
		}
	}
}

/**
 * Validate photo and return default photo if image not exists
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists( 'validate_photo')) {
	function validate_photo( $photo, $type = 'city' )
	{
		if ( empty( $photo )) {
		// if photo is empty, 
		
			// return default photo				
			return get_default_photo( $type );
		}
		
		// just return the full path of that image
		if ( is_object( $photo )) {
			return base_url( '/uploads/'. $photo->path );
		}

		return base_url( '/uploads/'. $photo );
	}
}

/**
 * Gets the defaulty photo by type
 *
 * @param      <type>  $type   The type
 */
function get_default_photo( $type )
{
	switch ( $type ) {
		// return city default photo
		case 'city':
			$photo = city_default_photo();
			break;

		// return about default photo
		case 'about':
			$photo = about_default_photo();
			break;

		// return cover default photo
		case 'cover':
			$photo = cover_default_photo();
			break;

		// return item default photo
		case 'item':
			$photo = item_default_photo();
			break;

		// return profile default photo
		case 'profile':
			$photo = profile_default_photo();
			break;

		// return feed default photo
		case 'feed':
			$photo = feed_default_photo();
			break;
	}

	return $photo;
}

/**
 * Gets city default city photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('city_default_photo'))
{
    function city_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_CITY_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_CITY_PHOTO;
    }   
}

/**
 * Gets city default aboutus photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('about_default_photo'))
{
    function about_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_ABOUT_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_ABOUT_PHOTO;
    }   
}

/**
 * Gets city default cover photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('cover_default_photo'))
{
    function cover_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_COVER_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_COVER_PHOTO;
    }   
}

/**
 * Gets city default item photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('item_default_photo'))
{
    function item_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_ITEM_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_ITEM_PHOTO;
    }   
}

/**
 * Gets city default profile photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('profile_default_photo'))
{
    function profile_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_PROFILE_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_PROFILE_PHOTO;
    }   
}

/**
 * Gets city default feed photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('feed_default_photo'))
{
    function feed_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_FEED_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_FEED_PHOTO;
    }   
}





/*************************************************** TIME ***************************************************************/
/**
 * Short Time ago function
 * @param  datetime $time_ago
 * @return mixed
 */
function time_ago($time_ago)
{
    if (is_numeric($time_ago) && (int)$time_ago == $time_ago) {
        $time_ago = $time_ago;
    } else {
        $time_ago = strtotime($time_ago);
    }
    $cur_time = time();
    $time_elapsed = $cur_time - $time_ago;
    $seconds = $time_elapsed;
    $minutes = round($time_elapsed / 60);
    $hours = round($time_elapsed / 3600);
    $days = round($time_elapsed / 86400);
    $weeks = round($time_elapsed / 604800);
    $months = round($time_elapsed / 2600640);
    $years = round($time_elapsed / 31207680);
    // Seconds
    if ($seconds <= 60) {
        return 'maintenant';
    } //Minutes
    elseif ($minutes <= 60) {
        if ($minutes == 1) {
            return 'il y a 1 mn';
        } else {
            return 'Il y a '. $minutes.' mn';
        }
    } //Hours
    elseif ($hours <= 24) {
        if ($hours == 1) {
            return 'il y a 1h';
        } else {
            return 'Il y a '. $hours.' heures';
        }
    } //Days
    elseif ($days <= 7) {
        if ($days == 1) {
            return 'il y a 1 jour';
        } else {
            return 'Il y a '. $days.' jours';
        }
    } //Weeks
    elseif ($weeks <= 4.3) {
        if ($weeks == 1) {
            return 'il y a 1 semaine';
        } else {
            return 'Il y a '. $weeks.' semaines';
        }
    } //Months
    elseif ($months <= 12) {
        if ($months == 1) {
            return 'il y a 1 mois';
        } else {
            return 'Il y a '. $months.' mois';
        }
    } //Years
    else {
        if ($years == 1) {
            return 'il y a  1 an';
        } else {
            return 'Il y a '. $years.' ans';
        }
    }
}

function daysleft($time)
{
    $result = null;
    $to_date = strtotime($time); //Future date.
    $cur_date = strtotime(date('Y-m-d'));
    $timeleft = $to_date - $cur_date;
    $daysleft = round((($timeleft / 24) / 60) / 60);
    if ($daysleft == 1) {
        $result = $daysleft . 'day left';
    } else if ($daysleft > 1) {
        $result = $daysleft . 'day left ';
    } else if ($daysleft == -1) {
        $result = $daysleft . 'day gone';
    } else if ($daysleft > -1) {
        $result = $daysleft . 'day gone';
    }
    return $result;

}


/***
 * @param $table
 * @param $where
 * @param $table_field
 * @return mixed
 */
function get_any_field($table, $where, $table_field)
{
    $CI =& get_instance();
    $query = $CI->db->select($table_field)->where($where)->get($table);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->$table_field;
    }
}


/***
 * @param $table
 * @param $where
 * @param null $fields
 * @return mixed
 */
function get_row($table, $where, $fields = null)
{
    $CI =& get_instance();
    $query = $CI->db->where($where)->get($table);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        if (!empty($fields)) {
            return $row->$fields;
        } else {
            return $row;
        }
    }
}

/***
 * @param $table
 * @param $where
 * @param $data
 */
function update($table, $where, $data)
{
    $CI =& get_instance();
    $CI->db->where($where);
    $CI->db->update($table, $data);
}

/**
 * @param $table
 * @param $where
 */
function delete($table, $where)
{
    $CI =& get_instance();
    $CI->db->where($where);
    $CI->db->delete($table);
}




