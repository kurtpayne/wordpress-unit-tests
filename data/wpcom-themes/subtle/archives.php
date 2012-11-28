<?php
/*
Filename: 		archives.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
Template Name:  Archives
*/

$query_string = add_query_arg('order', 'DESC', remove_query_arg('pagename', $query_string));

query_posts($query_string);

include('search.php');

?>
