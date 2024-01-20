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
if (!defined('ABSPATH')) {
    exit;
}

class GoogleNewsSearch
{

    public function __construct()
    {

        add_action('wp_enqueue_scripts', array($this, 'load_assets'));

        add_shortcode('google_search_form', array($this, 'load_shortcode'));


    }


    public function load_assets()
    {
        wp_enqueue_style(
            'google_news_search',
            plugins_url('styles/styles.css', __FILE__),
            array(),
            '1.0',
            'all'
        );
    }

    public function load_shortcode()
    {
        ob_start()
            ?>
        <div>
            <h2>Google News Search</h2>

            <form method="GET" action="">
                <label for="query">Enter query here:</label>
                <input type="text" name="query" autofocus>
                <button type="submit">Search</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["query"])) {
                $search_term = urlencode($_GET["query"]);
                $api = "https://news.google.com/news?q={$search_term}&output=rss";

                $feed = fetch_feed($api);

                if (!is_wp_error($feed)) {
                    echo "<h3>Search Results for '" . urldecode($search_term) . "':</h3>";

                    $items = $feed->get_items();
                    $num_results = min(count($items), 5);

                    echo "<ul>";
                    for ($i = 0; $i < $num_results; $i++) {
                        $item = $items[$i];
                        $title = esc_html($item->get_title());
                        $link = esc_url($item->get_permalink());
                        echo "<li><a href='{$link}' target='_blank'>{$title}</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Error retrieving data from the API:</p>";
                    echo "<pre>";
                    print_r($feed->get_error_message());
                    echo "</pre>";
                }
            }
            ?>

        </div>
        <?php
        return ob_get_clean();
    }

}


new GoogleNewsSearch;