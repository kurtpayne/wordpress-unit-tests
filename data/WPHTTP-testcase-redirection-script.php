<?php

// Thanks WordPress..
function is_ssl() {
	if ( isset($_SERVER['HTTPS']) ) {
		if ( 'on' == strtolower($_SERVER['HTTPS']) )
			return true;
		if ( '1' == $_SERVER['HTTPS'] )
			return true;
	} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		return true;
	}
	return false;
}

$url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . (!empty($_SERVER['HTTP_POST']) && 80 != $_SERVER['HTTP_POST'] ? ':' . $_SERVER['HTTP_POST'] : '');
if ( strpos($_SERVER['REQUEST_URI'], '?') )
	$url .= substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
else
	$url .= $_SERVER['REQUEST_URI'];

if ( isset($_GET['source']) ) {
	highlight_file(__FILE__ );
	exit;
}
if ( isset($_GET['200-location']) ) {
	header("HTTP/1.1 200 OK");
	if ( isset($_GET['fail']) ) {
		echo "FAIL";
	} else {
		header("Location: $url?200-location&fail=true", true, 200);
		echo "PASS";
	}
	exit;
}
if ( isset($_GET['header-check']) ) {
	$out = array();
	header("Content-type: text/plain");
	foreach ( $_SERVER as $key => $value ) {
		if ( stripos($key, 'http') === 0 ) {
			$key = strtolower(substr($key, 5));
			echo "$key:$value\n";
		}
	}
	exit;
}
if ( isset($_GET['multiple-headers']) ) {
	header("HeaderName: One", false);
	header("HeaderName: Two", false);
	header("HeaderName: Three", false);
	exit;
}

$rt = isset($_GET['rt']) ? $_GET['rt'] : 5;
$r = isset($_GET['r']) ? $_GET['r'] : 0;

/*if ( $r === 0 ) {
	header("Location: http://tools.dd32.id.au/redirect/?r=1" );
	exit;
}*/

if ( $r < $rt ) {
	$code = isset($_GET['code']) ? (int)$_GET['code'] : 302;
	header("Location: $url?rt=" . $rt . "&r=" . ($r+1), true, $code);
	echo "Redirect $r of $rt";
	exit;
}
echo "Redirect $r of $rt is FINAL.<br/>";
echo "GET['rt'] = Total times to redirect. Defaults to 5.<br />";
echo "GET['r'] = Current redirection. Defaults to 0.<br />";
echo "<a href='$url?source=true'>View Source</a>";