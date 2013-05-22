<?php

/* Widgets */

if ( function_exists('register_sidebar') )
    register_sidebar();
    
$themecolors = array(
	'bg' => '000000',
	'border' => '959596',
	'text' => 'B0B0B0',
	'link' => 'FD5A1E'
);
$content_width = 450; // pixels

define('HEADER_TEXTCOLOR', 'FD5A1E');
define('HEADER_IMAGE', ''); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 760);
define('HEADER_IMAGE_HEIGHT', 200);

function blackletterhead_header_style() {

	if ($url = get_header_image()) {
		echo <<<EOF
<style type="text/css">
#header {
background-repeat: no-repeat;
background-position: bottom center;
background-image: url({$url});
}
#sidebar {
border-top: none;
border-bottom: 1px dashed #555;
}
.pagepost {
border-top: none;
margin: 0 0 40px;
}
.post {
border-top: none;
margin: 0 0 40px;
text-align: left;
}
</style>
EOF;
	}
	if ($color = get_header_textcolor()) {
		if ($color == 'blank')
			$style = "display: none;";
		else
			$style = "color: #{$color}";
		echo <<<EOF
<style type="text/css">
#header h1 a, #header div.description {
	{$style}
}
</style>
EOF;
	}
}

function blackletterhead_admin_header_style() {

	$url = get_header_image();
	$color = get_header_textcolor();
	echo <<<EOF
<style type="text/css">
#headimg {
	padding: 0;
	margin: 0 auto;
	height: 200px;
	width: 760px;
	background-color: #000;
	}
#headimg h1 {
	font-family: Garamond, Serif;
	font-weight: bold;
	font-size: 34px;
	text-align: center;
	text-transform: uppercase;
	letter-spacing: 12px;
	padding-top: 40px;
	margin: 0;
	}

#desc {
        font-family: Verdana,Arial,Sans-Serif;
	font-size: 12px;
	text-align: center;
	letter-spacing: .6em;
	}
#headimg h1 a, #desc {
	text-decoration: none;
	color: #{$color};
	border: none;
}
</style>
EOF;
	if ($color == 'blank')
		$style = "display: none;";
	else
		$style = "color: #{$color}";
	echo <<<EOF
<style type="text/css">
#headimg h1 a, #desc {
	{$style}
}
</style>
EOF;
}

add_custom_image_header('blackletterhead_header_style', 'blackletterhead_admin_header_style');

?>
