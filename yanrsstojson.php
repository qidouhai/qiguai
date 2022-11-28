<?
echo<<<EOT
<head><meta name="viewport"
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"></head>
<center><form action="http://www.hihot.cn/qiguai/yanrsstojson.php" method="post">
				<input placeholder="搜索" class="soustxt" type="text" name="yanrss" value="" required>
				<input type="submit" value="按钮" class="button">
			</form></center>
EOT;
$url=$_POST['yanrss'];
$link = $url;
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
echo "<pre>";echo rsstojson($link);echo "</pre>";
?>
