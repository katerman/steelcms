<?php

function print_pre ($expression, $return = false, $wrap = false){
	$css = 'border:1px dashed #06f;background:#69f;padding:1em;text-align:left;';
	if ($wrap) {
		$str = '<p style="' . $css . '"><tt>' . str_replace(
			array('  ', "\n"), array('&nbsp; ', '<br />'),
			htmlspecialchars(print_r($expression, true))
		) . '</tt></p>';
	} else {
		$str = '<pre style="' . $css . '">'
			. htmlspecialchars(print_r($expression, true)) . '</pre>';
	}
	if ($return) {
		if (is_string($return) && $fh = fopen($return, 'a')) {
			fwrite($fh, $str);
			fclose($fh);
		}
		return $str;
	} else {
		echo $str;
	}
}

/**
 * custom_clean function.
 *
 * @access public
 * @param mixed $document text/code you're passing in to be sanitized
 * @param bool $js (default: true) clean js true/false
 * @param bool $html (default: true) clean html true/false
 * @param bool $styles (default: true) clean styling true/false
 * @param bool $cdata (default: true) clean cdata true/false
 * @param bool $php (default: true) clean php tag true/false
 * @param bool $stripslash (default: true) strip slashes
 * @return string cleaned text/code
 */
function custom_clean($document, $js = true, $html = true, $styles = true, $cdata = true, $php = true, $stripslash = true){
	$search = array();

	if($js){array_push($search, '@<script[^>]*?>.*?</script>@si');}
	if($html){array_push($search, '@<[\/\!]*?[^<>]*?>@si');}
	if($styles){array_push($search, '@<style[^>]*?>.*?</style>@siU');}
	if($cdata){array_push($search, '@<![\s\S]*?--[ \t\n\r]*>@');}
	if($php){array_push($search, '(<\?{1}[pP\s]{1}.+)');}

	$text = preg_replace($search, '', $document);
	if($stripslash){$text = stripslashes($text);}

	return $text;
}

function redirect($location){
	header("Location:  $location");
}

function send_404(){
	global $_config;

	header('Location: ' . $_config->rel_path . '/404');
	die();
}

function human_time_ago ($time){

	$time = time() - strtotime($time); // to get the time since that moment

	$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
	);

	foreach ($tokens as $unit => $text) {
		if ($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	}

}

function getRealIpAddr(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
