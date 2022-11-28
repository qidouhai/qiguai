<?php

 //接收内容
$urrl=$_SERVER['QUERY_STRING'];
$ua = parse_url($urrl);
$searchkeyword = $ua[path];
$searchkeyword = urldecode($searchkeyword);
$de="words=";
$searchkeyword=str_replace($de,"",$searchkeyword);


if($searchkeyword==" "){
$searchkeyword = $_GET["souname"];
}

//rsstojson
include ("./rsstojson.php");
include ("./rssyan.php");

//随机颜色
function randColor(){

$colors = array();

for($i = 0;$i<6;$i++){

$colors[] = dechex(rand(0,15));

}

return implode('',$colors);

}

//转码

function decodeUnicode($str)

{

return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',

create_function(

'$matches',

'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'

),

$str);

}


//sql查库
function sou($searchkeyword) { 
include ("sqlcon.php");

$m=10000;
$data=[];
   //获取所有行作为数组
    for($i=1;$i<=$m;$i++){
   $sqlu="select * from urltittle where id = $i";
   $results=mysqli_query($conn,$sqlu);
     $row = mysqli_fetch_assoc($results);       
  
	  $name=$row["sitename"];
      $sitedescription=$row["sitedescription"];
      $siteurl=$row["siteurl"];
      $sitetype=$row["sitetype"];
      $updatatime=$row["updatatime"];
	  $lastBuildDate=$row["lastBuildDate"];
	  if($row["tittle"]){
	  $tittle=$row["tittle"];
	  }else{
	  $tittle=$sitedescription;
	  }
	  if($row["description"]){
	  $description=$row["description"];
	  }else{
	  $description=$tittle;
	  }
	  if($row["link"]){
	  $link=$row["link"];
	  }else{
	  $link= $siteurl;
	  }
	  $pubDate=$row["pubDate"];
	  $helpful=$row["helpful"];
	  $statue=$row["statue"];
	  
	  
	  
	  //search顺序  文章内容 文章标题  站点描述 站点名字
	  
	   if(strstr($description,$searchkeyword)){
	  $giveup="?from=rss";
	  if(strstr($link,$giveup)){
	  $url=str_ireplace($giveup," ",$link);
	  }else{
	  
	  $url=$link;
	  	 }
	$redkeywords="<b><font size=5 color=#ff0000>".$searchkeyword."</font></b>";
	$searchresultsf=strstr($description ,$searchkeyword);
	$changdu=mb_strlen($searchkeyword,'utf-8');
	if($changdu>2){
  	$searchresultsf=mb_substr($searchresultsf,0,20,'utf-8');
	}else{
	$searchresultsf=mb_substr($searchresultsf,-20,20,'utf-8');
	}
	$searchresultsf=strip_tags($searchresultsf);
	$searchresultsf = preg_replace("/$searchkeyword/",$redkeywords,$searchresultsf);
	
	 $tittle=wordwrap($tittle,20,"<br>\n");
	$data[$sign][$geshi]="<font size=5 color=#".randColor().">来自rss结果</font>";;
	 $data[$sign][$i]="<br><a href=".$url.">".$tittle."</a><br><br><a href=".$link.">".$name."</a><br><br>";
	  }
	  
	  }
return $data; 
}
echo<<<EOT
<style>



form{
	background:#0076FF;
	border-radius:7px;
	position: relative;
	width:300px;
	margin:0 auto;
}
form input{
	-webkit-appearance:none;
	border:0;
	margin:4px;
	font-size:22px;
	line-height:30px;
	padding:7px 13px;
	vertical-align:top;
	border-radius:4px;
	width:200px;
}
form input:focus{
	outline:none;
}
form input::-webkit-search-decoration{
	display:none;
}

</style>
<center><form action="http://www.hihot.cn/qiguai/so.php?" method="get">
				<input placeholder="搜索" class="soustxt" type="text" name="words" value="" required>
				<input type="submit" value="搜索" class="button">
			</form></center>
EOT;
function so($searchkeyword){
if(sou($searchkeyword) != null){
echo <<<EOF
<!DOCTYPE html>
<html lang="en">
<head><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
EOF;
echo "<center>您搜索的相关关键字<b><font size=9 color=#ff0000> $searchkeyword </font></b>查找到以下页面<br></center>";
foreach (sou($searchkeyword)as $keys=>$values ){
foreach ($values as $key=>$value ){
$n=1;
if($value){
$n=$n+1;
echo "<center><font size=4 color=#000>".$value."</font><hr></center>";
}
}
}
}
}


//英文字母大小写判断转换
 function checkcase($str)
{
             if(preg_match('/^[a-z]+$/', $str))
             {
                    return 1;
             }
             elseif(preg_match('/^[A-Z]+$/', $str))
             {
                    return 2;
             }
}
if(checkcase($searchkeyword)==1){
so($searchkeyword);
$searchkeyword=strtoupper($searchkeyword);
so($searchkeyword);
}elseif(checkcase($searchkeyword)==2){
so($searchkeyword);
$searchkeyword=strtolower($searchkeyword);
so($searchkeyword);
}elseif(sou($searchkeyword) != null){
so($searchkeyword);
}else{
echo "<center>".$searchkeyword."没有搜到结果</center>";
}
   //结束语句
    
   mysqli_free_result($results);

   //关闭连接
   mysqli_close($conn);



?>
