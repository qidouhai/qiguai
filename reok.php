<?php
session_start();
 $urltype = $_SESSION['urltype'];
 $upjson = $_SESSION['upjson'];
 $upjsonsite=$_SESSION['upjsonsite'];
 $upjsonsitename = $_SESSION['upjsonsitename'];
 $upsign = $_SESSION['sign'];
include ("sqlcon.php");

$sql  = "select id,name,jsonurl,url,type,times from urltablefirst"; 
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      
      $oldjsonurl=$row["jsonurl"];
      $oldurl=$row["url"];
if($upjson==$oldjsonurl){
echo "这个json已存在</br>";
echo<<<EOT
<a href="http://www.hihot.cn/tijiao.html" class="dropdown-toggle">
               返回修改
              </a>
EOT;
} 
} 
   

   
 
 if ($result){
    $n=mysqli_num_rows($result);
  }else{
    $n=0;
  }    		 
			 
//初始化数据

if($n==null){
$n=0;
$u = "https://www.zhihu.com/api/v4/columns/c_1261258401923026944/items";
}
$rrr = "wwwwwwwww";
//json 判定格式

 //该变量是数组类型  返回1 
//该变量不是数组类型   返回2
function f($val){
	if(is_array($val)){
	
		return 1;
	}else{
	
		return 2;
	}
}


$rrr = file_get_contents($rrr);
$jiancea = json_decode($rrr,true);
$nojson=f($jiancea);

$uuu = file_get_contents($u);
$jianceu = json_decode($uuu,true);
$yesjson=f($jianceu);

//json 赋值给变量

if($_POST["upjson"] || $ysejson=1){
$n=$n+1;
$sum[urltype][n] = $n;
$sum[upjson][n]= $n;
$sum[upjsonsite][n] = $n;
$sum[upjsonsitename][n] = $n;
$sum[upsign][n] = $n;

$sum[urltype][name] = $urltype;
$sum[upjson][name]= $upjson;
$sum[upjsonsite][name] = $upjsonsite;
$sum[upjsonsitename][name] = $upjsonsitename;
$sum[upsign] = $upsign;

}
if($n>1000){
echo "服务器繁忙，请稍后再试";
}
if($n==0){

$sum[urltype][name] = 0 ;
$sum[upjson][name]= $u;
$sum[upjsonsite][name] = "www.zhihu.com";
$sum[upjsonsitename][name] = "网站标题占位 ";
$sum[upsign] = "zhihu";
}

if($n<1000||$n>0){
//echo "<pre>"; print_r($sum); echo "<pre>";
$sqlp = "INSERT INTO `urltablefirst`(`id`, `name`, `jsonurl`, `url`, `sign`, `type`, `times`) VALUES ('{$n}','{$sum[upjsonsitename][name]}','{$sum[upjson][name]}','{$sum[upjsonsite][name]}','{$sum[upsign]}','{$sum[urltype][name]}','{$n}')";
$re=mysqli_query($conn,$sqlp);
		   //结束语句
   mysqli_free_result($result);
mysqli_free_result($re);
   //关闭连接
   mysqli_close($conn);
		echo "<script>alert('添加成功');location.href='http://www.hihot.cn/sousuo.html';</script>";
		
}else{
echo "<script>alert('稍后尝试');location.href='http://www.hihot.cn/sousuo.html';</script>";

}
?>
