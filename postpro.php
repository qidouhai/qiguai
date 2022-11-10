<?php
include ("sqlcon.php");
 //接收内容
$searchkeyword = $_POST["souname"];

//sql查库

$sql  = "select id,name,jsonurl,url,type,times from urltablefirst"; 
$result = mysqli_query($conn,$sql);

   //获取所有行作为数组
   while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      
	 
      $name=$row["name"];
      $jsonurl=$row["jsonurl"];
      $url=$row["url"];
      $type=$row["type"];
	  
	  /*json  内容获取 */
  
$u=$jsonurl;
$response = file_get_contents($u);

 $arr= json_decode($response,true);

/** 
* @method 多维数组转字符串 
* @param type $array 
* @return type $srting 
* @author yanhuixian 
*/ 
function arrayToString($arr) { 
if (is_array($arr)){ 
return implode(',', array_map('arrayToString', $arr)); 
} 
return $arr; 
}
$arr = arrayToString($arr);

$counts = substr_count($arr,$searchkeyword); 
if($counts >0){
echo "<a href=".$url.">".$url."</a><br>";
echo "<a href=".$url.">".$name."</a><br>";
}else{
echo 1;
}
   }
   //结束语句
   mysqli_free_result($result);

   //关闭连接
   mysqli_close($conn);

?>
