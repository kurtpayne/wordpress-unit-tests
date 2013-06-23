<?php
require_once dirname( dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) ) . '/wp-config.php';
require_once( '../functions.php');
header("Content-type: text/css"); 
?>
<?php //Load Variables
  $css = get_option('V_background_css'); 
  $background_color = get_option('V_background_color');
  $border_color = get_option('V_border_color'); 
  $link_color = get_option('V_link_color');
  $hover_color = get_option('V_hover_color');
  $image_hover = get_option('V_image_hover');
?> 
<?php if ($css == 'Enabled') {?>
/*Background
------------------------------------------------------------ */
body { background: #<?php echo $background_color; ?>; }
#wrapper{
	background: #fff;
	padding: 0 20px 10px 20px;
	border-left: 4px solid #<?php echo $border_color; ?>;
	border-right: 4px solid #<?php echo $border_color; ?>;
	}
.sticky .entry {
	padding: 10px;
	background-color: #<?php echo $border_color; ?>;
}
/*Links 
------------------------------------------------------------ */
#content a:link, #content a:visited { color: #<?php echo $link_color; ?>; }
#sidebar a:link, #sidebar a:visited { color: #<?php echo $link_color; ?>; }
h1#title a:hover, div#title a:hover { color: #<?php echo $link_color; ?>; }
#nav .page_item a:hover { 
  color: #<?php echo $link_color; ?>;
	border-top: 4px solid #<?php echo $link_color; ?>;
	}
#nav .current_page_item a:link, #nav .current_page_item a:visited, #nav .current_page_item a:hover, #nav .current_page_parent a:link, #nav .current_page_parent a:visited, #nav .current_page_parent a:hover, #nav .current_page_ancestor a:link, #nav .current_page_ancestor a:visited, #nav .current_page_ancestor a:hover {
	color: #<?php echo $link_color; ?>;
	border-top: 4px solid #<?php echo $link_color; ?>;
	}
.post-header h1 a:hover, .post-header h2 a:hover { color: #<?php echo $link_color; ?>; }
.comments a:hover { color: #<?php echo $link_color; ?>; }
.meta a:hover { color: #<?php echo $link_color; ?>; }
.highlight-box { background: #<?php echo $link_color; ?>;	}
.post-footer a:hover { color: #<?php echo $link_color; ?>; }
#footer a:hover { color: #<?php echo $link_color; ?>; }
/*Hover 
------------------------------------------------------------ */
a:hover, #content a:hover, #sidebar a:hover { color: #<?php echo $hover_color; ?>; }

  <?php if ($image_hover == 'true') { ?>
/*Hide hover colors on comment images and sidebar menu images
------------------------------------------------------------ */
.comments a:hover { background: url(../images/comments-bubble.gif) no-repeat 0 .4em; }
ul li.widget ul li a:hover { background: url(../images/list-item.gif) no-repeat 0 .35em; }
  <?php 
  } ?>

/*Reset Specific Link Colors
------------------------------------------------------------ */
#content .post-header h1 a:link, #content .post-header h1 a:visited, #content .post-header h2 a:link, #content .post-header h2 a:visited  { color: #444; }
#content .post-header h1 a:hover, #content .post-header h2 a:hover { color: #<?php echo $link_color; ?>; }
#content .comments a { color: #757575;	}
#content .comments a:hover { color: #<?php echo $link_color; ?>; }
#content .meta a:link, #content .meta a:visited { color: #666; }
#content .meta a:hover { color: #<?php echo $link_color; ?>; }
#content .post-footer a:link, #content .post-footer a:visited { color: #333; }
#content .c-permalink a:link, #content .c-permalink a:visited { color: #757575; }
#content .reply a:link, #reply .c-permalink a:visited { color: #757575; }
#content .reply a:hover { color: #<?php echo $link_color; ?>; }
#footer a:link, #footer a:visited { color: #666; }
#footer a:hover { color: #<?php echo $link_color; ?>; }
<?php 
} ?>
