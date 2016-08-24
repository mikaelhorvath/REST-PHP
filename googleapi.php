<!DOCTYPE HTML>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div align="center">
<table class="apitable" id="api" width="850" border="1">
<?php
if(isset($_GET['location'])){

	$searchString = $_GET['location'];
	$address = "Sweden+".$searchString;
	$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Sweden";
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
		curl_close($ch);
	$response_a = json_decode($response);
	
	
	$latitude = $response_a->results[0]->geometry->location->lat;
	$longitude = $response_a->results[0]->geometry->location->lng;
	?>


	<?php
	$curlhandle = curl_init();
            
            curl_setopt($curlhandle, CURLOPT_URL, "https://api.foursquare.com/v2/venues/search?client_id=JZEWLXAQV53LQBBZF4TLIP0RA24NJECS1WF5USXIRQ3DNHF4&client_secret=RN344GMUXK3XRJGQ2JVHTJGYLQV5LULCSMLDWEUIFNMMVEJQ&v=20130815&ll=$latitude,$longitude&categoryId=4d4b7105d754a06374d81259&limit=20&radius=5000");
            curl_setopt($curlhandle, CURLOPT_RETURNTRANSFER, 1);

            $responsez = curl_exec($curlhandle);
            curl_close($curlhandle);

            $json = json_decode($responsez);
  
      if (is_array($json) || is_object($json)){
     	 	foreach ($json->response->venues as $result){
      		$adr = $result->location->address;
            echo "<tr><td><h1><strong>".$result->name."&nbsp;&nbsp;<a href='https://maps.google.com/?q=$adr,$searchString,Sweden' target='_blank'><img src='images/gmap.png' width='20' height='20'></img></a></td></tr></h1>";
            echo "<td><p><strong>Adress: </strong>".$result->location->address."</p>";
            $tfn = $result->contact->phone;
            echo "<p><strong>Telephone: </strong>".$result->contact->phone." <a href='skype:$tfn?call'><img src='images/skype.png' width='15' height='15'></img></a></p>";
            echo "<p><strong>Checkins: </strong>".$result->stats->checkinsCount."</p>";
            $weburl = $result->url;
            echo "<p><strong>Website: <a href='$weburl' class='linkclass' target='_blank'>$weburl</a> </strong></p></td>";
      				
      						
            }
     	 }          	      
}
?>
</table>
</div>
</body>
</HTML>