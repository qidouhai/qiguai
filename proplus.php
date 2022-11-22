<?php

 //接收内容
$searchkeyword = $_POST["souname"];

//rsstojson
include ("./rsstojson.php");
include ("./rssyan.php");

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


/** 
* @method 多维数组转字符串 
* @param type $array 
* @return type $srting 

*/ 
function arrayToString($arr) { 
if (is_array($arr)){ 
return implode(',', array_map('arrayToString', $arr)); 
} 
return $arr; 
}
//sql查库
function sou($searchkeyword) { 
include ("sqlcon.php");
$sql  = "select id,name,jsonurl,url,type,times,sign from urltablefirst"; 
$result = mysqli_query($conn,$sql);
$m=mysqli_num_rows($result);
$data=[];
   //获取所有行作为数组
    for($i=0;$i<=$m;$i++){
   $sqlu="select * from urltablefirst where id = $i";
   $results=mysqli_query($conn,$sqlu);
     $row = mysqli_fetch_assoc($results);       
  
   $name=$row["name"];
      $jsonurl=$row["jsonurl"];
      $url=$row["url"];
      $type=$row["type"];
      $sign=$row["sign"];
	  
	  //rss 判断
	  
	  $yanzhengrss = analyrss($jsonurl);
	  
	  if( $yanzhengrss ==1){
	  $arr=rsstojson($jsonurl);  //rss 转json
	  $arr= json_decode($arr,true); 
	  foreach($arr as $key=>$value){
	  
	  foreach($value[item] as $key=>$value){
	  $searchresultsf = $value[title];
	  $url=$value[link];
	  
	  if(strstr($searchresultsf,$searchkeyword)){
	  $giveup="?from=rss";
	  if(strstr($url,$giveup)){
	  $url=str_ireplace($giveup," ",$url);
	  }else{
	  
	  $url=$url;
	  	 }
	 $data[$sign][$i]="<br><br><a href=".$url.">".$url."</a><br><a href=".$url.">".$name."</a><br><br>".$searchresultsf."<br><br>";
	  }
	  
	  }
	  }
	  	  	  
	  }else{
	  
	  /*json  内容获取 */
	  
	  $u=$jsonurl;
	  $response = file_get_contents($u);
		
		$arr=decodeUnicode($response);
		
	  	$counts = substr_count($arr,$searchkeyword); 
	if($counts >0){
	$searchresults = preg_replace("/<a[^>]+href=\"(.*?)\"[^>]+data-poster=\"(.*?)\"[^>]*>.*?<\/a>/is"," ",$arr);
	$searchresultsf=strstr($searchresults ,$searchkeyword);
	if($searchresultsf){

	$searchresultsf=mb_substr($searchresultsf,0,50);
	//$data[$i]=$i;
	$data[$sign][$i]="<br><br><a href=".$url.">".$url."</a><br><a href=".$url.">".$name."</a><br><br>“.$searchresultsf.”<br><br>";
	}
	}
	}
}
return $data; 
}
echo<<<EOT
<center><form action="/proplus.php" method="post">
				<input placeholder="搜索" class="soustxt" type="text" name="souname" value="" required>
				<input type="submit" value="按钮" class="button">
			</form></center>
EOT;
if(sou($searchkeyword) != null){
echo "<center>您搜索的关键字<b><font size=9 color=#ff0000> $searchkeyword </font></b>查找到以下页面<br></center>";
foreach (sou($searchkeyword)as $key=>$values ){
foreach ($values as $key=>$value ){
$redkeywords="<b><font size=5 color=#ff0000>".$searchkeyword."</font></b>";
$value = preg_replace("/$searchkeyword/",$redkeywords,$value);

if($value){
$n=1;
$n=$n+1;
echo "<font size=5 color=#ff0000>".$key."</font><center>".$value."<hr></center>";
}
}
}
}else{
echo "<center>没有搜到结果</center>";
}

   //结束语句
   mysqli_free_result($results);
   mysqli_free_result($result);

   //关闭连接
   mysqli_close($conn);



?>
