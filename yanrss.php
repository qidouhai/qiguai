<?
echo<<<EOT
<head><meta name="viewport"
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"></head>
<center><form action="http://www.hihot.cn/qiguai/yanrss.php" method="post">
				<input placeholder="搜索" class="soustxt" type="text" name="yanrss" value="" required>
				<input type="submit" value="按钮" class="button">
			</form></center>
EOT;
$url=$_POST['yanrss'];
$isrss_link=$url;
//rss判断
function analyrss($isrsslink){
$isrsslink =file_get_contents($isrsslink);
$atom="http://www.w3.org/2005/Atom";

$rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns";

$rss="http://purl.org/dc/elements/1.1/";

$rss2 = "rss version=\"2.0\"";

$isatom=strstr($isrsslink,$atom);

$isrdf=strstr($isrsslink,$rdf);

$isrss=strstr($isrsslink,$rss);

$isrss2=strstr($isrsslink,$rss2);

if($isatom){return 1;}elseif($isrdf){return 2;}elseif($isrss){return 3;}elseif($isrss2){return 4;}else{return 5;}

}
echo "<center>结果：".analyrss($isrss_link)."</center><br>";
echo "<center>1 为 atom,2 为 rdf , 3,4 为 rss , 5 为 链接非rss类型</center>";
?>
