<?php

 //接收内容
$searchkeyword = $_POST["souname"];
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
   /*json  内容获取 */
  
$u=$jsonurl;
$response = file_get_contents($u);

 $arr= json_decode($response,true);


$arr = arrayToString($arr);

$counts = substr_count($arr,$searchkeyword); 
if($counts >0){
$searchresults = preg_replace("/<a[^>]+href=\"(.*?)\"[^>]+data-poster=\"(.*?)\"[^>]*>.*?<\/a>/is"," ",$arr);
$searchresults=strstr($searchresults ,$searchkeyword);
$searchresults=mb_substr($searchresults,0,50);
//$data[$i]=$i;
$data[$sign][$i]="<br><br><a href=".$url.">".$url."</a><br><a href=".$url.">".$name."</a><br><br>$searchresults<br><br>";

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
echo "<font size=5 color=#ff0000>".$key."</font><center>".$value."<hr></center>";
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