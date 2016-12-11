<?php

/*
 * Plugin Name: Good Shelf
  Plugin URI: http://richardhole.co.uk/
  Description: A plugin to display books from any given Goddreads.com shelf
  Author: Richard Hole
  Version: 1.0
  Author URI: http://richardhole.co.uk
 * */

/*  Copyright 2010  Richard Hole  (email : sneakatron@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/* * **This is where the action begins*** */

//$newShelf = new GoodShelf();
//$shelves = GetShelves(); //Get the users shelves
//$shelf = get_option($option); //Get selected shelf (saved in db).
//$books = GetBooks($shelf, '4', '1');
//displayShelf($books);


class GoodShelf extends WP_Widget {

    /** constructor * */
    function GoodShelf() {
        parent::WP_Widget(false, 'Good Shelf', array('description' => 'display books from any given Goddreads.com shelf', 'class' => 'good-shelf-class textwidget'));
    }

    function goodShelfWidget($args) {
        // widget actual processes
        extract($args);
    }

    function form($instance) {// outputs the options form on admin
        //check that an ID has been added. If not use my ID (hope to change this in future)
        if (empty($instance['good_user_id'])) {
            $instance['good_user_id'] = '1553338';
        }

        //check that an ID has been added. If not use my ID (hopeto change this in future)
        if (empty($instance['no_items'])) {
            $instance['no_items'] = '5';
        }

//Title. $this->get_field_id('title') = id of tile field in db. $this->get_field_name('title') = name of field in db. $instance['title'] = the data stored in DB
        echo '<p><label for="' . $this->get_field_id('title') . '">Title: </label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . attribute_escape($instance['title']) . '" /></p>';

        //User ID.
        echo '<p><label for="' . $this->get_field_id('good_user_id') . '">GoodReads user ID: <br /> <input size="15"  id="' . $this->get_field_id('good_user_id') . '" name="' . $this->get_field_name('good_user_id') . '" type="text" value="' . attribute_escape($instance['good_user_id']) . '" /></label></p>';


        //No of items.
        echo '<p><label for="' . $this->get_field_id('no_items') . '">No of items displayed?: <br /><input size="2" maxlength="2" id="' . $this->get_field_id('no_items') . '" name="' . $this->get_field_name('no_items') . '" type="text" value="' . attribute_escape($instance['no_items']) . '" /></label></p>';


        /*         * *shelf dropdown** */
        //label
        echo '<p><label for="' . $this->get_field_id('shelf') . '">Shelf:</label><br />';



//get a list of users shelves
        $shelves = GetShelves($instance['good_user_id']);


//begin the dropdown
        echo '<select name="' . $this->get_field_name('shelf') . '">'; //dropdown start
        //count number of shelves
        $cnt = count($shelves); //Count number of items in array
        //loop through the shelves and display them as an option. Display by default the option stored in the DB.
        for ($i = 0; $i < $cnt; $i++) {

            if ($instance['shelf'] == $shelves[$i]) {
                echo '<option value="' . $shelves[$i] . '" selected>' . $shelves[$i] . '</option>';
            } elseif (empty($instance['shelf'])) {
                echo '<option value="currently-reading" selected>currently-reading</option>';
                echo '<option value="read">Read</option>';
                echo '<option value="to-read">to-read</option>';
                break;
            } else {
                echo "<option value=" . $shelves[$i] . ">$shelves[$i]</option>";
            }
        }

        echo '</select></p>'; //dropdown end

        /*         * display options dropdown** */
        //label
        echo '<p><label for="' . $this->get_field_id('display_options') . '">Display as:</label><br />';
        echo '<select name="' . $this->get_field_name('display_options') . '">'; //dropdown start

        if ($instance['display_options'] == 'cover art' || empty($instance['display_options'])) {
            echo '<option value="cover art" selected>Cover art</option>';
            echo '<option value="link List">Link list</option>';
        } elseif ($instance['display_options'] == 'linklist') {
            echo '<option value="cover art">Cover art</option>';
            echo '<option value="link List" selected>Link list</option>';
        }

        echo '</select></p>'; //dropdown end
    }

    function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
        //strip tags
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['shelf'] = strip_tags($new_instance['shelf']);
        $instance['no_items'] = strip_tags($new_instance['no_items']);
        $instance['good_user_id'] = strip_tags($new_instance['good_user_id']);
        $instance['no_items'] = strip_tags($new_instance['no_items']);
        return $instance;
    }

    function widget($args, $instance) {
        //**** outputs the content of the widget****
        extract($args, EXTR_SKIP);

        //before the widget content
        echo $before_widget;

        //the title, called from the database. If it's empty then display a non-breaking space
        $title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        //get books
        $books = GetBooks($instance['shelf'], $instance['good_user_id'], $instance['no_items']);
        $cnt = count($books);

        //Display a list of links to books if it has been selected else display cover images
        if ($instance['display_options' == 'link list']) {
            echo '<ul class="goodreads">';
            for ($i = 0; $i < $cnt; $i++) {
                echo '<li><a href="' . $books[$i]['link'] . '" title="' . $books[$i]['title'] . '">' . $books[$i]['title'] . '</a></li>';
            }
            echo '</ul>';
        } else {
            for ($i = 0; $i < $cnt; $i++) {
                echo '<a class="goodreads_image" href="' . $books[$i]['link'] . '" title="' . $books[$i]['title'] . '"><img src="' . $books[$i]['image'] . '" alt="' . $books[$i]['title'] . '" /></a>&nbsp;';
            }
        }

        //link to goodreads. This must remain as it is stated in their terms of service
        echo '<p class="goodreads_power"><a href="https://goodreads.com" title="Goodreads.com">Provided by Goodreads</a></p>';

        //close the widget
        echo $after_widget;
    }

}

//end class
//Register widget function
function registerwidget() {
    register_widget('GoodShelf');
    //wp_register_sidebar_widget("GoodShelf","Good Shelf",'WidgetCall');
}

// register widget
add_action('widgets_init', 'registerwidget');




/* * **Get a list of the Users Shelves*** */

function GetShelves($good_user_id) {

    $good_user_id = strip_tags($good_user_id);

    //Initialize the cURL session
    $ch = curl_init();

    //set URL. params. key = API Key. user_id = user id
    curl_setopt($ch, CURLOPT_URL,
            "https://www.goodreads.com/shelf/list.xml?key=SgRUKzGo9czsY71QrgVw&user_id=$good_user_id");

    //return contents as a variable, instead of outputting to browser
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //store contents in a variable
    $contents = curl_exec($ch);

    //parse XML
    $doc = new SimpleXmlElement($contents, LIBXML_NOCDATA);

    //count Items in XML
    $cnt = count($doc->shelves->user_shelf);

    //Loop through the avalible Shelf names and store them in an array
    for ($i = 0; $i < $cnt; $i++) {
        $shelfNames[$i] = $doc->shelves->user_shelf[$i]->name;
    }

    return($shelfNames);
}

/* * **Get Book Contents*** */

function GetBooks($shelf, $id, $num) {
    //Initialize the cURL session
    $ch = curl_init();

    //set URL. params. key = API Key. user_id = user id. per_page = num 'of displayed pages'
    curl_setopt($ch, CURLOPT_URL,
            "https://www.goodreads.com/review/list/$id.xml?key=SgRUKzGo9czsY71QrgVw&v=2&per_page=$num&shelf=$shelf");

    //return contents as a variable, instead of outputting to browser
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //store contents in a variable
    $contents = curl_exec($ch);

    //parse XML
    $doc = new SimpleXmlElement($contents, LIBXML_NOCDATA);

    //count Items in XML
    $cnt = count($doc->reviews->review);

    //Loop through the avalible Shelf names and store them in an array
    for ($i = 0; $i < $cnt; $i++) {
        $books[$i]['title'] = $doc->reviews->review[$i]->book->title;
        $books[$i]['image'] = $doc->reviews->review[$i]->book->small_image_url;
        $books[$i]['link'] = $doc->reviews->review[$i]->book->link;
    }

    return($books);
}

function displayShelf($books) {
//this will be used in future for the shortcode


    return($books);
}

?>
