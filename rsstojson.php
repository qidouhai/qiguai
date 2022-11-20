<?

function rsstojson($link){
//header('content-type:application/json;charset=utf8'); 
// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $link);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);
$xml = simplexml_load_string($output,"SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
return $json;

// close curl resource to free up system resources
curl_close($ch);
}

