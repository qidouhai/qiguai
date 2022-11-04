<?php
$searchkeyword = $_POST["souname"];
$u = "https://www.zhihu.com/api/v4/columns/c_1261258401923026944/items";


  

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
echo 2;
}else{
echo 1;
}

?>
