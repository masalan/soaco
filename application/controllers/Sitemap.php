<?php
/**
 * Sitemap Generator
 */
class Sitemap extends CI_Controller {

	/**
	 * generate sitemap
	 */
	function __construct()
	{
		parent::__construct();

		$this->generate_xml();
	}

	/**
	 * index page
	 */
	function index() {}

	/**
	 * sitemap generation logic
	 */
	function generate_xml()
	{
		// load xml helper
		$this->load->helper('file');

		// base urls
		$site_url = site_url();
		$city_url = site_url( 'CityInfo/index/');
		$item_url = site_url( 'ItemInfo/index/');

		// home page
		$sitemap[] = array( 'loc' => $site_url );

		// about us page
		$sitemap[] = array( 'loc' => site_url( 'about_us' ));

		// contact us page
		$sitemap[] = array( 'loc' => site_url( 'contact_us'));

		// cities
		$cities = $this->city->get_all_by( array( 'is_approved' => 1 ))->result();
		if ( !empty( $cities )) {
			foreach ( $cities as $city ) {
				$sitemap[] = array( 'loc' => $city_url . $city->id, 'lastmod' => $city->added );
			}
		}

		// items
		$items = $this->item->get_all()->result();
		if ( !empty( $items )) {
			foreach ( $items as $item ) {
				$sitemap[] = array( 'loc' => $item_url . $item->id, 'lastmod' => $item->added );
			}
		}

		// generate xml
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		if ( !empty( $sitemap )) {
			foreach ( $sitemap as $site ) {
				$xml .= '<sitemap>';
				if ( isset( $site['loc'] )) $xml .= '<loc>'. $site['loc'] .'</loc>';
				if ( isset( $site['lastmod'] )) $xml .= '<lastmod>'. $site['lastmod'] .'</lastmod>';
				$xml .= '</sitemap>';
			}
		}
		$xml .= '</sitemapindex>';

		write_file( 'sitemap.xml', $xml );
	}
}