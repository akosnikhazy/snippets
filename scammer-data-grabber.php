<?php
/*
* From time to time I talk to scammers, pretending to be a victim. Sometimes they ask for pictures to prove that I sent them money and stuff. 
* I use this script to collect some data about them. I just put it on a free PHP server, make a bit.ly link from it.
*
* It is not very sophisticated, I do not really update the OS and browser list, but it does store IP and user agent, so it might be useful. 
* If you can tell their country by IP, they get angry. It can also be useful for law enforcement to know where the attack came from.
*
* To set this up you need: 
*   -a baitimage.jpg, it will render for preview in most chats, so the scammer clicks.
*   -a free PHP server, where you upload this file and the baitimage.jpg image
*   -a database with a table like this:
*     CREATE TABLE `ip` (
*       `id` int(11) NOT NULL,
*      `OS` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
*       `browser` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
*       `uagent` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
*       `ip` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
*       `date` datetime NOT NULL DEFAULT current_timestamp()
*     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*
*  -Alternativally you can rewrite it so it saves a textfile wiht the data.
*/
function getUserIP()
{

    if(filter_var( @$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
        return  @$_SERVER['HTTP_CLIENT_IP'];
 
    if(filter_var( @$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
        return @$_SERVER['HTTP_X_FORWARDED_FOR'];
    
    return $_SERVER['REMOTE_ADDR'];
}

function getUserAgentData() { 
	
	$data = array('OS' => 'not-known','browser' => 'not-known');
	
	$os_array =   array(
		'/windows nt 10/i'      =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'mobile device',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu'
	);
	
	$browser_array  = array(
		'/msie/i'       =>  'Internet Explorer',
		'/firefox/i'    =>  'Firefox',
		'/chrome/i'     =>  'Chromium based',
		'/safari/i'     =>  'Safari',
		'/edge/i'       =>  'Edge (old)',
		'/opera/i'      =>  'Opera',
		'/mobile/i'     =>  'Mobile Browser'
	);

	foreach ( $os_array as $regex => $val ) { 
		if ( preg_match($regex, $_SERVER['HTTP_USER_AGENT'] )) { 
			$data['OS'] = $val;
			break;
		}
	
	}

	foreach ( $browser_array as $regex => $val ) { 
		if ( preg_match( $regex, $_SERVER['HTTP_USER_AGENT'] ) ) {
			$data['browser'] = $val;
			break;
		}
	}
	
	return $data;
}

/* grab data */
$data = getUserAgentData();

/* save data */
$conn = new mysqli("localhost",'','','');

$sql = 'INSERT INTO ip (ip,OS,browser,uagent)
	VALUES ("' . getUserIP() . '","' . $data['OS'] . '","' . $data['browser'] . '","' . $_SERVER['HTTP_USER_AGENT'] . '")';

$conn->query($sql);
 
/* render image */
$im = imagecreatefromjpeg ('baitimage.jpg' );

header('Content-Type: image/jpeg');

imagejpeg($im);

imagedestroy($im);
