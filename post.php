<?php
//这个post文件是测试文件
$searchkeyword = $_POST["souname"];
//这里的变量是临时测试
$u = "https://www.zhihu.com/api/v4/columns/c_1261258401923026944/items";

  
function be($u){
$response = file_get_contents($u);
 $e = json_decode($response,true);
   
$counts = substr_count($e,$searchkeyword); 
if($counts >0){
echo $u;
}else{
echo "未找到结果";
}
}
be($u);
?>
