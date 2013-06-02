<?php

$themecolors = array(
	'bg' => '0a0a0a',
	'border' => '0a0a0a',
	'text' => 'cccccc',
	'link' => 'cc3300'
);

$content_width = 450;

if ( function_exists('register_sidebar') )
    register_sidebar();

?>
<?php
/*
Plugin Name: Nice Categories
Plugin URI: http://txfx.net/2004/07/22/wordpress-conversational-categories/
Description: Displays the categories conversationally, like: Category1, Category2 and Category3
Version: 1.5.1
Author: Mark Jaquith
Author URI: http://txfx.net/
*/

function the_nice_category($normal_separator = ', ', $penultimate_separator = ' and ') {
    $categories = get_the_category();
   
      if (empty($categories)) {
        _e('Uncategorized');
        return;
    }

    $thelist = '';
        $i = 1;
        $n = count($categories);
        foreach ($categories as $category) {
            $category->cat_name = $category->cat_name;
                if (1 < $i && $i != $n) $thelist .= $normal_separator;
                if (1 < $i && $i == $n) $thelist .= $penultimate_separator;
            $thelist .= '<a href="' . get_category_link($category->cat_ID) . '" title="' . sprintf(__("View all posts in %s"), $category->cat_name) . '">'.$category->cat_name.'</a>';
                     ++$i;
        }
    echo apply_filters('the_category', $thelist, $normal_separator);
}
?>
