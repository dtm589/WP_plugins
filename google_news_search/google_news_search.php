<?php
/** 
 * Plugin Name: Google News Search
 * Description : Google news serach api
 * Author: Derek Marchese
 * Version: 1.0.0
 * Text Domain: google_news_search
 * 
*/

//Protects the php file from being access by the URL
if( !defined('ABSPATH') )
{
    exit;
}

class GoogleNewsSearch {

    public function __construct()
    {
        add_action('init', array( $this,'create_custom_post_type') );

        add_action('wp_enqueue_scripts', array( $this,'load_assets') );

        add_shortcode('google_search_form', array( $this,'load_shortcode') );

        
    }

    public function create_custom_post_type()
    {
        $args = array(

            'public'=> true,
            'has_archive' => false,
            'supports' => array('title'),
            'publicly_queryable' => false
        );

        register_post_type('google_news_search', $args );
    }

    public function load_assets()
    {
        wp_enqueue_style(
            'google_news_search',
            plugins_url( __FILE__ ) . 'styles/styles.css',
            array(),
            1,
            'all'
        );
    }

    public function load_shortcode()
    {
        return 'Hello its working!';
    }

}


new GoogleNewsSearch;