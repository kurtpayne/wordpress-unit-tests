<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '027ac6'
);

if ( function_exists('register_sidebar') )
	register_sidebar(array('name' => __('Left Sidebar'), 'id' => 'left-sidebar'));

if ( function_exists('register_sidebar') )
	register_sidebar(array('name' => __('Right Sidebar'), 'id' => 'right-sidebar'));

function garland_admin_menu() {
	$page = add_theme_page(__("Color Customizer"), __("Color Customizer"), 'edit_themes', 'custom-color', 'garland_admin_page');
	add_action("load-$page", 'garland_save_colors' );
	add_action("admin_print_scripts-$page", 'garland_admin_js');
	add_action("admin_head-$page", 'garland_admin_head');
	add_action("admin_print_scripts-$page", 'kill_feedback', 1 );
}

function garland_admin_js() {
	wp_deregister_script( 'prototype' );
	wp_enqueue_script( 'farbtastic' );
}

function garland_admin_head() {
	$base = garland_color('base');
	$_base = substr($base, 1);
	$text = garland_color('text');
	$link = garland_color('link');
	$_top = substr(garland_color('top'), 1);
	$_bottom = substr(garland_color('bottom'), 1);
	echo "<link rel='stylesheet' href='/wp-content/themes/pub/garland/farbtastic.css' type='text/css' />";
	echo <<<EOHEAD
<script type="text/javascript">
	imgObj = new Image();
	imgObj.src = "/wp-content/themes/pub/garland/garland-image.php?src=preview.png&top=$_top&bottom=$_bottom&base=$_base";
	function previewLoadImage() {
		if ( imgObj.complete || 'complete' == imgObj.readyState )
			jQuery('#preview').css({ backgroundImage: 'url("' + imgObj.src + '")' });
		else
			setTimeout("previewLoadImage();",200);
	}
	function previewUpdateDisplay() {
		var e = jQuery('.farbtastic', '#colorpicker');
		var angle = f.hsl[0] * 6.28;
		jQuery('.h-marker', e).css({
			left: Math.round(Math.sin(angle) * f.radius + f.width / 2) + 'px',
			top: Math.round(-Math.cos(angle) * f.radius + f.width / 2) + 'px'
		});

		jQuery('.sl-marker', e).css({
			left: Math.round(f.square * (.5 - f.hsl[1]) + f.width / 2) + 'px',
			top: Math.round(f.square * (.5 - f.hsl[2]) + f.width / 2) + 'px'
		});

		// Saturation/Luminance gradient
		jQuery('.color', e).css('backgroundColor', f.pack(f.HSLToRGB([f.hsl[0], 1, 0.5])));

		// Linked elements or callback
		if (typeof f.callback == 'object') {
			// Set background/foreground color
			jQuery(f.callback).each( function(i,j) {
				if ( 'preview' == j.id ) {
					var imgsrc = jQuery(j).css('backgroundImage');
					var oldimgsrc = imgsrc;
					var color = f.color.substring(1,7);
					if ( f.callback[0].className.match(/top/) )
						imgsrc = imgsrc.replace(/top=[0-9a-fA-F]{6}/, 'top=' + color);
					else if ( f.callback[0].className.match(/bottom/) )
						imgsrc = imgsrc.replace(/bottom=[0-9a-fA-F]{6}/, 'bottom=' + color);
					else if ( f.callback[0].className.match(/base/) )
						imgsrc = imgsrc.replace(/base=[0-9a-fA-F]{6}/, 'base=' + color);
					if ( imgsrc == oldimgsrc )
						return;
					if ( document.images ) {
						imgObj = new Image();
						imgsrc = imgsrc.match(/(http|\/)[^'")]+/);
						imgObj.src = imgsrc[0];
						previewLoadImage();
					} else {
						jQuery(j).css({ backgroundImage: imgsrc });
					}
				} else if ( j.tagName.match(/input/i) )
					jQuery(j).css({
						backgroundColor: f.color,
						color: f.hsl[2] > 0.5 ? '#000' : '#fff'
					});
				else
					jQuery(j).css({ color: f.color });
			} );

			// Change linked value
			jQuery(f.callback).each(function() {
				if (this.value && this.value != f.color)
					this.value = f.color;
			});
		} else if (typeof f.callback == 'function') {
			f.callback.call(fb, f.color);
		}
	}

	jQuery(document).ready( function() {
		f = jQuery.farbtastic('#colorpicker');
		f.updateDisplay = previewUpdateDisplay;
		jQuery('#color-table input')
			.each( function() { f.linkTo(this); } )
			.focus( function() { f.linkTo('.' + this.className); } );
	} );
</script>
<style type="text/css">
	#preview {
		width: 596px;
		height: 371px;
		background: url("/wp-content/themes/pub/garland/garland-image.php?src=preview.png&top=$_top&bottom=$_bottom&base=$_base");
		position: relative;
		margin: 0 auto;
		color: $text;
	}
	#preview h3 {
		position: absolute;
		top: 160px;
		left: 75px;
		font-family: Helvetica, Arial, sans-serif;
		font-weight: normal;
		font-size: 160%;
		line-height: 130%;
		margin: 0;
		padding: 0;
	}
	#preview p {
		position: absolute;
		top: 190px;
		left: 75px;
		width: 446px;
	}
	#preview a, #preview a:link, #preview a:visited {
		text-decoration: none;
		border: none;
		color: $link;
	}
	#preview a:hover {
		text-decoration: underline;
		border: none;
		color: $link;
	}
</style>
EOHEAD;
}

function garland_using_custom_colors() {
	if ( get_theme_mod( 'custom-colors' ) )
		return true;
	return false;
}

function garland_color( $color, $shift = false ) {
	$colors = garland_custom_colors();
	if ( isset($colors[$color]) )
		return ( $shift && $colors[$color][1] ? $colors[$color][1] : $colors[$color][0] );
	return $color;
}

function garland_custom_colors() {
	if ( !$colors = get_theme_mod( 'custom-colors' ) ) {
		$colors = array();
		foreach ( garland_colors() as $label => $color ) {
			$colors[$label] = array( $color['default'] );
			if ( isset($colors[$label]['shift']) )
				$colors[$label][] = $colors[$label]['shift'][0];
		}
	}
	return $colors;
}

function garland_colors() {
	return array(
		'base' => array( 'label' => __('Base'), 'el' => 'body, #wrapper, .commentlist .alt', 'prop' => 'background-color', 'default' => '#0072b9', 'shift' => array( '#EDF5FA', '#ffffff' )  ),
		'link' => array( 'label' => __('Link'), 'el' => 'a, a:link, a:hover, a:visited', 'prop' => 'color', 'default' => '#0062A0' ),
		'top' => array( 'label' => __('Header Top'), 'default' => '#0472EC' ),
		'bottom' => array( 'label' => __('Header Bottom'), 'default' => '#67AAF4' ),
		'text' => array ( 'label' => __('Text'), 'el' => '#wrapper', 'prop' => 'color', 'default' => '#494949' )
	);
}

function garland_images() {
	return array(
		'bg-navigation-item.png' => array( 'el' => array(
				'ul.primary-links li a, ul.primary-links li a:link, ul.primary-links li a:visited',
				'ul.primary-links li a:hover, ul.primary-links li a.active'
			),
			'args' => array(
				array( 'top', 'bottom' ),
				array( 'top', 'bottom' )
			),
			'color' => array(
				'transparent',
				'transparent'
			),
			'post' => array(
				'no-repeat 50% 0',
				'no-repeat 50% -48px'
			 )
		),
		'bg-navigation.png' => array( 'el' => '#navigation', 'args' => 'base', 'post' => 'repeat-x 50% 100%' ),
		'body.png' => array( 'el' => '#wrapper', 'args' => array( 'base', 'top', 'bottom' ), 'color' => 'base', 'post' => 'repeat-x 50% 0'),
		'bg-content.png' => array( 'el' => '#wrapper #container #center #squeeze', 'args' => array( 'base', 'top', 'bottom' ), 'color' => '#fff', 'post' => 'repeat-x 50% 0'),
		'bg-content-right.png' => array( 'el' => '#wrapper #container #center .right-corner', 'args' => array( 'base', 'top', 'bottom' ), 'color' => 'transparent', 'post' => 'no-repeat 100% 0'),
		'bg-content-left.png' => array( 'el' => '#wrapper #container #center .right-corner .left-corner', 'args' => array( 'base', 'top', 'bottom' ), 'color' => 'transparent', 'post' => 'no-repeat 0 0')
	);
}
		

function garland_admin_page() {
	if ( isset($_GET['updated']) ) : ?>
	<div class="updated fade"><p><?php _e('Custom Colors Updated'); ?></p></div>
<?php endif; ?>

<div class="wrap">
	<h2><?php _e('Custom Colors'); ?></h2>

<?php garland_color_form(); ?>

<h2>Preview</h2>
<div id="preview" class="preview-base preview-top preview-bottom">

	<h3 class="preview-text">Lorem ipsum dolor</h3>

	<p class="preview-text">
		Sit amet, consectetur adipisicing elit, sed do eiusmod <a href="#" class="preview-link">tempor incididunt</a> ut labore et
		dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
		nisi ut aliquip ex ea commodo consequat. Duis aute <a href="#" class="preview-link">irure dolor</a> in reprehenderit in
		voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
		cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	<p>

</div>
</div>
<?php }

function garland_colors_css() {
	if ( !garland_using_custom_colors() )
		return;

	echo "<style type='text/css'>";

	foreach ( garland_colors() as $label => $color )
		echo "\n\t{$color['el']}" . ' { ' . "{$color['prop']}: " . garland_color( $label, true ) . ' } ';

	foreach ( garland_images() as $src => $image ) {
		if ( is_array($image['el']) ) {
			foreach ( $image['el'] as $k => $el ) {
					echo "\n\t$el" . ' { background: ' . garland_color( $image['color'][$k], true ) . " url('" . get_stylesheet_directory_uri() . "/garland-image.php?src=$src";
				foreach ( (array) $image['args'][$k] as $color )
					echo "&$color=" . substr(garland_color( $color ), 1);
				echo "') {$image['post'][$k]}" . ' } ';
			}
		} else {
			echo "\n\t{$image['el']}" . ' { background: ' . garland_color( $image['color'], true ) . " url('" . get_stylesheet_directory_uri() . "/garland-image.php?src=$src";
			foreach ( (array) $image['args'] as $color )
				echo "&$color=" . substr(garland_color( $color ), 1);
			echo "') {$image['post']}" . ' } ';
		}
	}

	echo "\n</style>\n";
}
	
function garland_color_form()  {
	$colors = garland_colors(); ?>

<form name="custom-colors" id="custom-colors" action="" method="post">
<table id="color-table" class="alignleft">
<?php	foreach ( $colors as $label => $color ) : ?>
	<tr>
		<th scope="row"><label for="<?php echo $label; ?>-color"><?php echo $color['label']; ?></th>
		<td><input type="text" name="custom-color[<?php echo $label; ?>]" id="<?php echo $label; ?>-color" class="preview-<?php echo $label; ?>" value="<?php echo garland_color( $label ); ?>" /></td>
	</tr>
<?php	endforeach; ?>
</table>
<div id="colorpicker" class="alignleft" style="padding: 0 5ex;"></div>
<p class="submit" style="clear: both;">
<input type="submit" value="<?php echo attribute_escape(__('Save Custom Colors')); ?>" />
<input type="submit" name="reset-colors" value="<?php echo attribute_escape(__('Reset to Default Colors')); ?>" class="delete" />
</p>
</form>
<?php }

function garland_save_colors() {
	if ( !$_POST )
		return;

	require( 'color-module.php' );

	$colors = garland_custom_colors();
	$defaults = garland_colors();

	if ( isset($_POST['reset-colors']) ) {
		remove_theme_mod( 'custom-colors' );
	} else {
		foreach ( $_POST['custom-color'] as $label => $color ) {
			$colors[$label] = array( preg_replace('/[^#a-fA-F0-9]/', '', $color) );
			if ( isset($defaults[$label]['shift']) )
				$colors[$label][] = _color_shift( $colors[$label][0], $defaults[$label]['default'], $defaults[$label]['shift'][0], $defaults[$label]['shift'][1] );
		}

		set_theme_mod( 'custom-colors', $colors );
	}
	wp_redirect( add_query_arg('updated', '1') );
	exit;
}
	

function kill_feedback() {
	remove_action( 'admin_head', 'feedback_hackpage' );
	remove_action( 'admin_print_scripts', 'feedback_scripts' );
	remove_action( 'admin_head', 'feedbackform_javascript' );
}

add_action( 'admin_menu', 'garland_admin_menu' );

add_action( 'wp_head', 'garland_colors_css' );

?>
