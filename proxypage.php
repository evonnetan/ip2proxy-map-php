<html>
<head>
<title>IP2Proxy</title>
</head>
<body style="margin:auto;">

<?php
require 'class.IP2Proxy.php';
$db = new \IP2Proxy\Database();
$db->open('./samples/IP2PROXY-LITE-PX4.BIN', \IP2Proxy\Database::FILE_IO);

require_once 'class.IP2Location.php';
$dbip = new \IP2Location\Database('./samples/IP2LOCATION-LITE-DB5.BIN', \IP2Location\Database::FILE_IO);


$country_Code 	= $db->getCountryShort('1.2.3.4');
$country_Name 	= $db->getCountryLong('1.2.3.4');
$region_Name 	= $db->getRegion('1.2.3.4');
$city_Name		= $db->getCity('1.2.3.4');
$isp 			= $db->getISP('1.2.3.4');
$proxy_Type 	= $db->getProxyType('1.2.3.4');
$is_Proxy 		= $db->isProxy('1.2.3.4');


echo"<table border=\"1\" style=\"font-size:20px;\">";
echo"<tr>";
echo "<td><strong>Country Code: </strong></td><td>". $country_Code . "</td>";
echo"</tr>";
echo"<tr>";
echo "<td><strong>Country Name: </strong></td><td>". $country_Name . "</td>";
echo"</tr>";
echo"<tr>";
echo "<td><strong>Region Name: </strong></td><td>". $region_Name . "</td>";
echo"</tr>";
echo"<tr>";
echo "<td><strong>City Name: </strong></td><td>". $city_Name . "</td>";
echo"</tr>";
echo"<tr>";
echo "<td><strong>ISP: </strong></td><td>". $isp . "</td>";
echo"</tr>";
echo"<tr>";
echo "<td><strong>Proxy Type: </strong></td><td>". $proxy_Type . "</td>";
echo"</tr>";
echo"<tr>";
echo "<td><strong>Is Proxy: </strong></td><td>". $is_Proxy . "</td>";
echo"</tr>";
echo"</table>";


$records = $db->getAll('1.2.3.4');
echo '<pre>';
print_r($records);
echo '</pre>';


$record_ip = $dbip->lookup('1.2.3.4', \IP2Location\Database::ALL);

$latitude = $record_ip['latitude'];
$longitude = $record_ip['longitude'];


echo"<h1>Google Map</h1>";
echo"<div>";
echo "<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyB-hhau6SC79uqmg_asgrLJ4PKNoC-cINs'></script><div style='overflow:hidden;height:400px;width:520px;'><div id='gmap_canvas' style='height:400px;width:520px;'></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div> <a href='https://www.embed-map.net/'>google maps embed directions</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=f9780c5b95e245c1022cb02e2b0db0f7630b73e3'></script><script type='text/javascript'>function init_map(){var myOptions = {zoom:9,center:new google.maps.LatLng($latitude,$longitude),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng($latitude,$longitude)});infowindow = new google.maps.InfoWindow({content:'<strong>$region_Name</strong><br><br> $city_Name<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>";


echo"</div>";
?>
</body>
</html>

<?php
$db->close();
?>
