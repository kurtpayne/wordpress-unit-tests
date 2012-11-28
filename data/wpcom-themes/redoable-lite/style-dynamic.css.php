<?php
/*
Dynamic Stylesheet for colours only.
Still somewhat experimental, only a preview feature for Redoable 1.1.
*/

// Send correct type:
header("Content-Type: text/css");

$style_selected = $_GET['s']; //get_option('dynamicss_style');
$colour_selected = $_GET['c'];


/* Background colours */

$greybase = "#FFFFFF";

/*$greycolour[0] = GreyColour(0); "#000000";
$greycolour[1] = GreyColour(0.35); "#111111";
$greycolour[2] = GreyColour(0.45); "#161616";
$greycolour[3] = GreyColour(0.5); "#191919";
$greycolour[4] = GreyColour(0.675); "#222222";
$greycolour[5] = GreyColour(0.75); "#262626";
$greycolour[6] = GreyColour(0.82); "#292929";
$greycolour[7] = GreyColour(0.87); "#2C2C2C";
$greycolour[8] = GreyColour(0.9); "#2D2D2D";
$greycolour[9] = GreyColour(0.95); "#303030";
$greycolour[10] = GreyColour(1); "#333333";
$greycolour[11] = GreyColour(1.07); "#363636";
$greycolour[12] = GreyColour(1.13); "#393939";
$greycolour[13] = GreyColour(1.35); "#444444";
$greycolour[14] = GreyColour(1.67); "#555555";
$greycolour[15] = GreyColour(1.9); "#606060";
$greycolour[16] = GreyColour(2); "#666666";
$greycolour[17] = GreyColour(2.35); "#777777";
$greycolour[18] = GreyColour(3); "#999999";
$greycolour[19] = GreyColour(4); "#CCCCCC";
$greycolour[20] = GreyColour(4.35); "#DDDDDD";
$greycolour[21] = GreyColour(4.67); "#EEEEEE";
$greycolour[22] = GreyColour(5); "#FFFFFF";*/

$grey_default[0] = GreyColour(0); 
$grey_default[1] = GreyColour(0.07); 
$grey_default[2] = GreyColour(0.09); 
$grey_default[3] = GreyColour(0.1); //sidebar border right
$grey_default[4] = GreyColour(0.135); // main border colour
$grey_default[5] = GreyColour(0.15); //sidebar bg
$grey_default[6] = GreyColour(0.162); //comment bg
$grey_default[7] = GreyColour(0.175); //sidebar left border
$grey_default[8] = GreyColour(0.18); //page nav bg
$grey_default[9] = GreyColour(0.19); //sidenote bg
$grey_default[10] = GreyColour(0.2); //main back colour
$grey_default[11] = GreyColour(0.215); //pinglist bg
$grey_default[12] = GreyColour(0.225); //current page nav hover
$grey_default[13] = GreyColour(0.27); //page meta bg colour
$grey_default[14] = GreyColour(0.335); //page meta border, img border
$grey_default[15] = GreyColour(0.38); //ping list border
$grey_default[16] = GreyColour(0.4); //comment form border
$grey_default[17] = GreyColour(0.47); 
$grey_default[18] = GreyColour(0.6); //comment bg, various border
$grey_default[19] = GreyColour(0.8); 
$grey_default[20] = GreyColour(0.87); 
$grey_default[21] = GreyColour(0.935); 
$grey_default[22] = GreyColour(1); 

$grey_white[0] = GreyColour(0);
$grey_white[1] = GreyColour(0.87);
$grey_white[2] = GreyColour(0.89);
$grey_white[3] = GreyColour(0.9); //sidebar border right
$grey_white[4] = GreyColour(0.935); // main border colour
$grey_white[5] = GreyColour(0.95); //sidebar bg
$grey_white[6] = GreyColour(0.962); // comment bg
$grey_white[7] = GreyColour(0.975); //sidebar left border
$grey_white[8] = GreyColour(0.98); //page nav bg
$grey_white[9] = GreyColour(0.99); //sidenote bg
$grey_white[10] = GreyColour(1); // main back colour
$grey_white[11] = GreyColour(0.915); //pinglist bg
$grey_white[12] = GreyColour(0.925); //current page nav hover
$grey_white[13] = GreyColour(0.97); //page meta bg colour
$grey_white[14] = GreyColour(0.835); //page meta border, img border
$grey_white[15] = GreyColour(0.88); //ping list border
$grey_white[16] = GreyColour(0.8); //comment form borders
$grey_white[17] = GreyColour(0.87);
$grey_white[18] = GreyColour(0.89); //comment bg, various border
$grey_white[19] = GreyColour(0.2);
$grey_white[20] = GreyColour(0.27);
$grey_white[21] = GreyColour(0.975);
$grey_white[22] = GreyColour(1);


/* Text colours */

$textbase = "#FFFFFF";

$text_default[0] = TextColour(0);
$text_default[1] = TextColour(0.135);
$text_default[2] = TextColour(0.2);
$text_default[3] = TextColour(0.27);
$text_default[4] = TextColour(0.4);
$text_default[5] = Textcolour(0.47);
$text_default[6] = TextColour(0.535);
$text_default[7] = TextColour(0.6);
$text_default[8] = TextColour(0.735);
$text_default[9] = TextColour(0.8);
$text_default[10] = TextColour(0.87);
$text_default[11] = TextColour(0.915);
$text_default[12] = TextColour(0.935);
$text_default[13] = TextColour(1);

$text_white[0] = TextColour(1); 
$text_white[1] = TextColour(0.765); 
$text_white[2] = TextColour(0.8); 
$text_white[3] = TextColour(0.13); 
$text_white[4] = TextColour(0.6); 
$text_white[5] = TextColour(0.53);
$text_white[6] = TextColour(0.465); 
$text_white[7] = TextColour(0.4); 
$text_white[8] = TextColour(0.265); 
$text_white[9] = TextColour(0.2); 
$text_white[10] = TextColour(0.13); 
$text_white[11] = TextColour(0.085); 
$text_white[12] = TextColour(0.065); 
$text_white[13] = TextColour(0.001);

/* Header and link colours */

$colour_default = array("#000000","#440000","#660000","#770000","#880000","#990000","#DD0000","#EE0000","#FF0000","#FFFFFF");
$colour_blue 	= array("#000000","#000044","#000066","#000077","#000088","#000099","#0000DD","#0000EE","#0000FF","#FFFFFF");
$colour_green 	= array("#000000","#004400","#006600","#007700","#008800","#009900","#00DD00","#00EE00","#00FF00","#FFFFFF");
$colour_orange	= array("#000000","#442200","#663300","#773B00","#884400","#994B00","#DD6B00","#EE7700","#FF7F00","#FFFFFF");
$colour_aqua 	= array("#000000","#004444","#006666","#007777","#008888","#009999","#00DDDD","#00EEEE","#00FFFF","#FFFFFF");
$colour_pink 	= array("#000000","#440022","#660033","#77003B","#880044","#99004B","#DD006B","#EE0077","#FF007F","#FFFFFF");
$colour_grey	= array("#000000","#444444","#666666","#777777","#888888","#999999","#DDDDDD","#EEEEEE","#FFFFFF","#FFFFFF");
$colour_black	= array("#000000","#050505","#0A0A0A","#101010","#151515","#1A1A1A","#202020","#252525","#2A2A2A","#FFFFFF");


function GreyColour($scale) {
	if ($scale) {
		
		global $greybase;
		
		$minr = hexdec(substr($greybase, 1, 2));
		$ming = hexdec(substr($greybase, 3, 2));
		$minb = hexdec(substr($greybase, 5, 2));
		
		if ($minr > 128 and $ming > 128 and $minb > 128) {
		
			$r = dechex(intval( (($minr) * $scale) ));
			$g = dechex(intval( (($ming) * $scale) ));
			$b = dechex(intval( (($minb) * $scale) ));
			
		}
		else {
	
			$r = dechex(intval( (($minr) + (255 * (1-$scale))) ));
			$g = dechex(intval( (($ming) + (255 * (1-$scale))) ));
			$b = dechex(intval( (($minb) + (255 * (1-$scale))) ));
				
		}
							
		if (strlen($r) == 1) $r = "0" . $r;
		if (strlen($g) == 1) $g = "0" . $g;
		if (strlen($b) == 1) $b = "0" . $b;
		
		return "#$r$g$b";
	}
}

function TextColour($scale) {
	if ($scale) {
		
		global $textbase;
		
		$minr = hexdec(substr($textbase, 1, 2));
		$ming = hexdec(substr($textbase, 3, 2));
		$minb = hexdec(substr($textbase, 5, 2));

		if ($minr > 128 and $ming > 128 and $minb > 128) {
		
			$r = dechex(intval( (($minr) * $scale) ));
			$g = dechex(intval( (($ming) * $scale) ));
			$b = dechex(intval( (($minb) * $scale) ));
			
		}
		else {
	
			$r = dechex(intval( (($minr) + (255 * (1-$scale))) ));
			$g = dechex(intval( (($ming) + (255 * (1-$scale))) ));
			$b = dechex(intval( (($minb) + (255 * (1-$scale))) ));
				
		}
				
		if (strlen($r) == 1) $r = "0" . $r;
		if (strlen($g) == 1) $g = "0" . $g;
		if (strlen($b) == 1) $b = "0" . $b;
		
		return "#$r$g$b";
	}
}

/*
function dHue(cHex, d) {
	d = d % 360;
	var y = new Color(cHex);
	y = y.rgbToHsb();
	y[0] = y[0] + d;
	if (y[0] > 359) y[0] = y[0] - 360;
	return y.hsbToRgb().rgbToHex();
}
function dSaturation(cHex, d) {
	d = d % 100;
	var y = new Color(cHex);
	y = y.rgbToHsb();
	y[1] = y[1] + d;
	if (y[1] > 99) y[1] = y[1] - 100;
	return y.hsbToRgb().rgbToHex();
}
function dBrightness(cHex, d) {
	d = d % 100;
	var y = new Color(cHex);
	y = y.rgbToHsb();
	y[2] = y[2] + d;
	if (y[2] > 99) y[2] = y[2] - 100;
	return y.hsbToRgb().rgbToHex();
}
*/


if ($style_selected == "default") { $greycolour = $grey_default; $textcolour = $text_default; }
else if ($style_selected == "white") { $greycolour = $grey_white; $textcolour = $text_white; }
else { $greycolour = $grey_default; $textcolour = $text_default; }

if ($colour_selected == "default") { $headercolour = $colour_default; }
else if ($colour_selected == "blue") {$headercolour = $colour_blue; }
else if ($colour_selected == "green") {$headercolour = $colour_green; }
else if ($colour_selected == "orange") {$headercolour = $colour_orange; }
else if ($colour_selected == "aqua") {$headercolour = $colour_aqua; }
else if ($colour_selected == "pink") {$headercolour = $colour_pink; }
else if ($colour_selected == "grey") {$headercolour = $colour_grey; }
else if ($colour_selected == "black") {$headercolour = $colour_black; }
else { $headercolour = $colour_default; }
?>


/* Greys - by default */

#searchform input { color: <?php echo $textcolour[1]?>; }

.single #primary .redo-asides .entry-content, .single #primaryFirst .redo-asides .entry-content, input[type=text]:focus, textarea:focus,
#commentlist li .counter, li.bypostauthor blockquote, #searchform input:focus, #akst_social a, #wp-calendar #today, .link-header { color: <?php echo $textcolour[2]?>; }

body, input[type=text], textarea { color: <?php echo $textcolour[3]?>; }
ul.menu li.current_page_item a, ul.menu li.current_page_item a:hover, .published_link { color: <?php echo $textcolour[3]?> !important; }

.tertiary { color: <?php echo $textcolour[4]?>; }
#comment-block { color: <?php echo $textcolour[4]?> !important; }

.comment-login, .comment-welcomeback, .comments input[type=text], .comments textarea, small, strike, .link-title { color: <?php echo $textcolour[5]?>; }

h3, h3 a, h3 a:visited, h4, h4 a, h4 a:visited { color: <?php echo $textcolour[6]?>; }

#primary .metalink a, #primary .metalink a:visited, #primaryFirst .metalink a, #primaryFirst .metalink a:visited,
.secondary .metalink a, .secondary .metalink a:visited, .secondary span a, .secondary span a:visited,
.tertiary .metalink a, .secondary .metalink a:visited, .tertiary span a, .tertiary span a:visited, .commentsrsslink a, .trackbacklink a,
.page-nav, .page-nav a, .sb-comments-blc ul li span a, .sb-comments ul li small a,
.sb-comments-blc li > a[title="Go to the comments of this entry"] { color: <?php echo $textcolour[7]?>; } /* #footer, #footer a, .footer_content, */

.page-nav a:hover { color: <?php echo $textcolour[8]?>; }

h2, #primary .entry-content h2, #primaryFirst .entry-content h2, h2, h2 a, h2 a:visited, h2, h2 a, h2 a:hover, h2 a:visited,
.first .entry-meta, .entry-meta, .page-meta, .sidenote h2, a, .secondary h2, .tertiary h2, .first .entry-meta h2,
.entry-content a:visited, blockquote, #comment-block h2, #wp-calendar caption, .first .relatedPosts, .first .relatedPosts h2 { color: <?php echo $textcolour[9]?>; }
h3.entry-title a:hover, .sidenote h2 a, .first h3.entry-title a:hover, .published_tiny, .comment-content blockquote { color: <?php echo $textcolour[9]?> !important; }

#leavecomment, .comments #loading, .page-nav .current_page_item, .page-nav .current_page_item a { color: <?php echo $textcolour[10]?>; }

#footer a:hover { color: <?php echo $textcolour[11]?>; }

.secondary, .entry-content, .entry-meta a, .page-meta a, .comment-meta a, .sidenote, .first p, #commentlist li, li.byuser,
li.bypostauthor, .navigation a, .sb-links a, #comment-block a, .sb-latest a, .sb-comments a, .sb-months a, #wp-calendar td,
#wp-calendar td.pad:hover, #wp-calendar td:hover, .relatedPosts a, .link-title a { color: <?php echo $textcolour[12]?>; }
h3.entry-title a, ul.menu li a:hover, .first h3.entry-title a { color: <?php echo $textcolour[12]?> !important; }

#header_content, #header_content a, #header_content a:hover, ul.menu li a,
.sb-catblock a { color: <?php echo $textcolour[13]?> !important; } /* #footer_content, */
#wp-calendar a:hover, #wp-calendar #next a:hover, #wp-calendar #prev a:hover { color: <?php echo $textcolour[13]?> !important; }


/* 1 - #111111 */
body, #header { background-color: <?php echo $greycolour[1]?>; }

/* 2 - #161616 */
/* #footer_content { border-left-color: <?php echo $greycolour[2]?>; border-right-color: <?php echo $greycolour[2]?>; } */

/* 3 - #191919 */
#menu a, #rightcolumn, #rightcolumnheader, #rightcolumnfooter { border-right-color: <?php echo $greycolour[3]?>; }
#comment-block, #alt_menu { border-left-color: <?php echo $greycolour[3]?>; border-right-color: <?php echo $greycolour[3]?>; }

/* 4 - #222222 */
#menu .current_page_item a, #leftcolumn { border-right-color: <?php echo $greycolour[4]?>; }
#middlecolumn { border-left-color: <?php echo $greycolour[4]?>; border-right-color: <?php echo $greycolour[4]?>; }
li.byuser, #alt_menu { background-color: <?php echo $greycolour[4]?>; } /*, #footer_content*/

/* 5 - #262626 */
#header_content a, #rightcolumn, #rightcolumnheader, #rightcolumnfooter { background-color: <?php echo $greycolour[5]?>; }

/* 6 - #292929 */
h2, #comment-block { background-color: <?php echo $greycolour[6]?>; }
#menu a:hover { border-right-color: <?php echo $greycolour[6]?>; }

/* 7 - #2C2C2C */
#leftcolumn { border-left-color: <?php echo $greycolour[7]?>; }

/* 8 - #2D2D2D */
.page-nav { background-color: <?php echo $greycolour[8]?>; }

/* 9 - #303030 */
#leftcolumn { background-color: <?php echo $greycolour[9]?>; }
.lentry { border-color: <?php echo $greycolour[9]?>; }

/* 10 - #333333 */
#header_content a:hover, #header_content .current_page_item a, ul.menu li a:hover,
#middlecolumn, #footer, .footer_contentm, blockquote { background-color: <?php echo $greycolour[10]?>; }
#menu .current_page_item a:hover { border-right-color: <?php echo $greycolour[10]?>; }
li.byuser, #searchform input { border-color: <?php echo $greycolour[10]?>; }
.link-header { color: <?php echo $greycolour[10]?>; }

/* 11 - #363636 */
#pinglist { background-color: <?php echo $greycolour[11]?>; }

/* 12 - #393939 */
#header_content .current_page_item a:hover, .lentry { background-color: <?php echo $greycolour[12]?> !important; }

/* 13 - #444444 */
.first .entry-meta, .entry-meta, .page-meta, li.bypostauthor, #primary .entry-content img, #primaryFirst .entry-content img,
#searchform input, .sb-listen img:hover, .sb-watch img:hover, .sb-badge img:hover, .first .relatedPosts, .first-alt .relatedPosts,
.published_tiny { background-color: <?php echo $greycolour[13]?>; }

/* 14 - #555555 */
.first .entry-meta, .entry-meta, .page-meta, li.bypostauthor, #primary .entry-content img,
#primaryFirst .entry-content img, .sb-listen img, .sb-listen img:hover, .sb-watch img,
.sb-watch img:hover, .sb-badge img, .sb-badge img:hover, .first .relatedPosts, .published_tiny { border-color: <?php echo $greycolour[14]?>; }

/* 15 - #606060 */
#pinglist { border-color: <?php echo $greycolour[15]?>; }

/* 16 - #666666 */
.comments input[type=text], .comments textarea, input[type=text]:focus, textarea:focus,
.comments form #submit, #searchform input:focus { border-color: <?php echo $greycolour[16]?>; }

/* 17 - #777777 */
.firstheader { background-color: <?php echo $greycolour[17]?>; }

/* 18 - #999999 */
.comments input[type=text], .comments textarea { background-color: <?php echo $greycolour[18]?>; }
acronym, abbr { border-bottom-color: <?php echo $greycolour[18]?>; }
.sb-flickr div a:hover img, .published, .published_sm, .published_link { border-color: <?php echo $greycolour[18]?>; }
.entry-content .imgDigg, .entry-content .diggButton, .comment-content blockquote { border-color: <?php echo $greycolour[18]?> !important; }

/* 19 - #CCCCCC */
.secondary h2, .tertiary h2, .first .entry-meta h2, .entry-content a, #comment-block h2, #wp-calendar h2,
#wp-calendar caption, .first .relatedPosts h2, .first-alt .relatedPosts h2 { border-bottom-color: <?php echo $greycolour[19]?>; }
.sb-flickr div a img, .relatedPosts { border-color: <?php echo $greycolour[19]?>; }

/* 20 - #DDDDDD */
#searchcontrols { background-color: <?php echo $greycolour[20]?>; }

/* 21 - #EEEEEE */
li.bypostauthor blockquote, .published, .published_sm, .published_link { background-color: <?php echo $greycolour[21]?>; }
#wp-calendar #today{ background-color: <?php echo $greycolour[21]?> !important; }
.entry-content .imgDigg, .entry-content .diggButton { background-colour: <?php echo $greycolour[21]?> !important; }
	
/* 22 - #FFFFFF */
ul.menu li.current_page_item a, ul.menu li.current_page_item a:hover, input[type=text]:focus,
textarea:focus, #searchform input:focus { background-color: <?php echo $greycolour[22]?>; }
#wp-calendar td { border-color: <?php echo $greycolour[22]?>; }




/* Colourifical - not finished in Redoable 1.1 */

h1, h1 a, h1 a:hover, h1 a:visited, #header .description { color: <?php echo $headercolour[9]?>; }

.quotes { border-left-color: <?php echo $headercolour[1]?>; border-right-color: <?php echo $headercolour[1]?>; }

#header_content { border-left-color: <?php echo $headercolour[2]?>; border-right-color: <?php echo $headercolour[2]?>; }
#menu a { border-left-color: <?php echo $headercolour[2]?>; }
#menu .current_page_item a { border-left-color: <?php echo $headercolour[2]?>; }

#menu a:hover { border-left-color: <?php echo $headercolour[3]?>; }
.quotes { background-color: <?php echo $headercolour[3]?>; background-image:none;}
#wp_quotes { background-image:none; }

#menu .current_page_item a:hover { border-left-color: <?php echo $headercolour[4]?>; }

#header_content { background-color: <?php echo $headercolour[5]?>; }

.sidenote h2 a:hover { color: <?php echo $headercolour[6]?> !important; }
a:hover { color: <?php echo $headercolour[6]?>; }
.entry-content a:hover { border-bottom-color: <?php echo $headercolour[6]?>; }
#akst_social a:hover { color: <?php echo $headercolour[6]?>; }

h2 a:hover, h2 span a:hover { color: <?php echo $headercolour[7]?> !important; }
#comment-block a:hover { color: <?php echo $headercolour[7]?>; }
#wp-calendar a { color: <?php echo $headercolour[7]?> !important; }
#wp-calendar #next a { color: <?php echo $headercolour[7]?>; }
#wp-calendar #prev a { color: <?php echo $headercolour[7]?>; }
#wp-calendar #today a, #wp-calendar #today a:visited{ color: <?php echo $headercolour[7]?> !important; }

.contacterror { border-color: <?php echo $headercolour[8]?>; }


/*#firefox_check { background: #995500; border-left: 10px solid #773300; border-right: 10px solid #773300; color: #FFFFFF; }
#firefox_check a { color: #FFFFFF; }
#firefox_check a:hover { color: #FFCC00; }*/
/*.comments #error { color: #FF0000; background-color: #FFFF99; }*/
/* end colourifical */


/* images */
<?php if ($style_selected == "white") { ?>
blockquote { background-image: url('images/quote_lt.gif'); }
blockquote p { background-image: url('images/quote_end_lt.gif'); }
<?php } else if ($style_selected == "default") { ?>
blockquote { background-image: url('images/quote.gif'); }
blockquote p { background-image: url('images/quote_end.gif'); }
<?php } ?>

/* special */
<?php if ($style_selected == "white") { ?>
	.download { background-color: #CFC; border-top: 2px solid #6C6; border-bottom: 2px solid #6C6; }
	.download a, .download a:visited { color: #6C6; border-bottom: 2px dotted #6C6; }
	.download a:hover { color: #9F9; border-bottom: 2px dotted #9F9; }
	.imp-download { background-color: #CFC !important; border-top: 2px solid #6C6 !important; border-bottom: 2px solid #6C6 !important; }
	.imp-download-error { background-color: #FCC !important; border-top: 2px solid #F33 !important; border-bottom: 2px solid #F33 !important; }
	.imp-download a, .imp-download a:visited, .imp-download-error a, .imp-download-error a:visited { color: #6C6 !important; border-bottom: 2px dotted #6C6 !important; }
	.imp-download a:hover, .imp-download-error a:hover { color: #9F9 !important; border-bottom: 2px dotted #9F9 !important; }
	.imp-download small, .imp-download-error small { color: #333333 !important; }
	.code { background-color: #EEEEEE; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; }
	.alert { background-color: #FCC; border-top: 2px solid #F33; border-bottom: 2px solid #F33; }
	.new { background-color: #FDB; border-top: 2px solid #F93; border-bottom: 2px solid #F93; }
	.construction { background-color: #FFC; border-top: 2px solid #FF3; border-bottom: 2px solid #FF3; }
	.information { background-color: #CCF; border-top: 2px solid #33F; border-bottom: 2px solid #33F; }
	.note { background-color: #EEEEEE; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; }
	.callout { border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; color: #CCCCCC; }
<?php } else if ($style_selected == "default") { ?>
	.download { background-color: #353; border-top: 2px solid #383; border-bottom: 2px solid #383; }
	.download a, .download a:visited { color: #3F3; border-bottom: 2px dotted #3F3; }
	.download a:hover { color: #3C3; border-bottom: 2px dotted #3C3; }
	.imp-download { background-color: #353 !important; border-top: 2px solid #383 !important; border-bottom: 2px solid #383 !important; }
	.imp-download-error { background-color: #533 !important; border-top: 2px solid #F33 !important; border-bottom: 2px solid #F33 !important; }
	.imp-download a, .imp-download a:visited, .imp-download-error a, .imp-download-error a:visited { color: #3F3 !important; border-bottom: 2px dotted #3F3 !important; }
	.imp-download a:hover, .imp-download-error a:hover { color: #3C3 !important; border-bottom: 2px dotted #3C3 !important; }
	.imp-download small, .imp-download-error small { color: #EEEEEE !important; }
	.code { background-color: #444444; border-top: 2px solid #AAAAAA; border-bottom: 2px solid #AAAAAA; }
	.alert { background-color: #533; border-top: 2px solid #F33; border-bottom: 2px solid #F33; }
	.new { background-color: #643; border-top: 2px solid #F93; border-bottom: 2px solid #F93; }
	.construction { background-color: #553; border-top: 2px solid #FF3; border-bottom: 2px solid #FF3; }
	.information { background-color: #335; border-top: 2px solid #33F; border-bottom: 2px solid #33F; }
	.note { background-color: #444444; border-top: 2px solid #AAAAAA; border-bottom: 2px solid #AAAAAA; }
	.callout { border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; color: #CCCCCC; }
<?php } ?>