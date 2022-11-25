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
<a href="http://www.hihot.cn/qiguai/tijiao.html" class="dropdown-toggle">
               返回修改
              </a>
EOT;
exit;
} 
} 
   

   
 
 if ($result){
    $n=mysqli_num_rows($result);
  }else{
    $n=0;
  }    		 
			 
//upjson 赋值给变量

if( $upjson){
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
die;
}
if($n==0){
echo "服务器繁忙，请稍后再试";
die;
$sum[urltype][name] = 0 ;
$sum[upjson][name]= $u;
$sum[upjsonsite][name] = "www.zhihu.com";
$sum[upjsonsitename][name] = "网站标题占位 ";
$sum[upsign] = "zhihu";
}

if($n<100 && $n>0){
//echo "<pre>"; print_r($sum); echo "<pre>";
$sqlp = "INSERT INTO `urltablefirst`( `name`, `jsonurl`, `url`, `sign`, `type`, `times`) VALUES ('{$sum[upjsonsitename][name]}','{$sum[upjson][name]}','{$sum[upjsonsite][name]}','{$sum[upsign]}','{$sum[urltype][name]}','{$n}')";
$re=mysqli_query($conn,$sqlp);
		   //结束语句
   mysqli_free_result($result);
mysqli_free_result($re);
   //关闭连接
   mysqli_close($conn);
		echo "<script>alert('添加成功');location.href='http://www.hihot.cn/qiguai';</script>";
		
}else{
echo "<script>alert('稍后尝试');location.href='http://www.hihot.cn/qiguai';</script>";

}
?>
