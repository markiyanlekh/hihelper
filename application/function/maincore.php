<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_web_page($url) {
    
	$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
}

function stripinput($text) {
	if (!is_array($text)) {
		$text = stripslashes(trim($text));
		$text = preg_replace("/(&amp;)+(?=\#([0-9]{2,3});)/i", "&", $text);
		$search = array("\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;"); // "&", 
		$replace = array("&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " "); //"&amp;", 
		$text = str_replace($search, $replace, $text);
	} else {
		foreach ($text as $key => $value) {
			$text[$key] = stripinput($value);
		}
	}
	return $text;
}

function _cut_str($start, $stop, $str) {
	$spos = strpos($str, $start);
	$spos = $spos + strlen($start);
	$text = substr($str, $spos);
	$end_pos = strpos($text, $stop);
	$text = substr($text, 0, $end_pos);
	return $text;
}

function get_web_page_curl($url, $key) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['key'=>$key,'listId'=>'LIST1','displayName'=>'My Publications','publicProfile'=>'true','_'=>'']));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$s = curl_exec($ch);
	curl_close($ch);
	return $s;
}
?>