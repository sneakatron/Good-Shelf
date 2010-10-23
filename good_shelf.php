<?php
/*
 * Plugin Name: Good Shelf
Plugin URI: http://richardhole.co.uk/
Description: An RSS Reader created especially for good reads books
Author: Richard Hole
Version: 0.5
Author URI: richardhole.co.uk
 * */


//usage [shelf feed="http://feedurl.com/feed.rss" img="true/false" txt="true/false"
//feed = the URL to the feed
////num = number of items to display
//img = display image?
//txt = display title?


/****shortcode function***/
function shelf($atts) {
    extract(shortcode_atts(array(
            'feed' => 'http://www.goodreads.com/review/list_rss/1553338-rich?key=ca4096c415fb92313ccd9a8e67a59cbcc1c8ccf1&shelf=currently-reading',//the default
            'num' => '1',//defualt
            'img' => True,
            'txt' => True
            ) , $atts));


    function fetch_feed_modified($url,$num,$img,$txt) {
        require_once  (ABSPATH . WPINC . '/class-feed.php');//include simplePie class
        $feed = new SimplePie();//create the class object
        $feed->set_feed_url($url);//set the feed url
        $feed->set_cache_class('WP_Feed_Cache');//feed cache
        $feed->set_file_class('WP_SimplePie_File');//the class
        $feed->set_cache_duration(apply_filters('wp_feed_cache_transient_lifetime', 43200));
        $feed->init();
        $feed->handle_content_type();

        ob_start();//put it in a buffer
        if ( $feed->error() )
            printf ('There was an error while connecting to Feed server, please, try again!');

        foreach ($feed->get_items(0,$num) as $item) {
           if($img == True) {printf('<a href="%s"><img src="%s" class="good_img" /></a>', $item->get_permalink(),scrapeImage($item->get_description()));}//get image
            if($txt == True){printf('<a href="%s">%s</a>',$item->get_permalink(), $item->get_title());}//Get link
        

        }
        $content = ob_get_contents();//Get the contents that was just output
        ob_end_clean();//clean the buffer
        return $content;//return the content of the buffer
    }

//Get the uRL of the image
    function scrapeImage($text) {
        $pattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';//preg for image URL
        preg_match($pattern, $text, $link);//match it
        if(empty($link))
            $link = 'http://default-image-location.com/some-image.jpg';
        else
            $link = $link[1];
        return $link;
    }

    function ms_smallpie_feed($uri,$num,$img,$txt) {
        if(function_exists('fetch_feed_modified')) {
            $content = fetch_feed_modified($uri,$num,$img,$txt);//grab the feed
            return($content);//grab the content
        }
    }

    $content = ms_smallpie_feed($feed,$num,$img,$txt);//call the smallpie feed function to get results
    return($content);

}

add_shortcode('shelf', 'shelf');
add_filter( 'widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');


?>