<?
function get_country($ip) {
if(!$ip) $ip= $ENV{'REMOTE_ADDR'};
$fd=fopen("http://www.maxmind.com/app/lookup?ips=$ip", "r");
while($line=fgets($fd,1000)) {
if($start=='yes') {
$flag=eregi_replace(" <td><img src=\"/img/flag/","",$line);
$flag=eregi_replace(".gif\" height=\"12\" width=\"18\"></td>",""
,$flag);
$start="no";
}
if(strstr($line,$ip)) $start="yes";
}
fclose ($fd);
return $flag;
}

$country=get_country($ENV{'REMOTE_ADDR'});
/*
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
	$country = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
	$country = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$country = $_SERVER['REMOTE_ADDR'];
}

*/
if($country=='kr') {
	echo "KOREA"; //include "index_kr.html";
} else {
	echo($country);
	echo "NONONO";
}
if($country=='jp') echo "I hate Japanese";
else include "index_en.html";
?>