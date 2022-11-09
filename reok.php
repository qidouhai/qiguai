<?php
session_start();
 $urltype = $_SESSION['urltype'];
 $upjson = $_SESSION['upjson'];
 $upjsonsite=$_SESSION['upjsonsite'];
 $upjsonsitename = $_SESSION['upjsonsitename'];

//初始化数据
$n=0;
if($n==0){
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

$sum[urltype][name] = $urltype;
$sum[upjson][name]= $upjson;
$sum[upjsonsite][name] = $upjsonsite;
$sum[upjsonsitename][name] = $upjsonsitename;


}
if($n>1000){
echo "服务器繁忙，请稍后再试";
}
if($n==0){

$sum[urltype][name] = 0 ;
$sum[upjson][name]= $u;
$sum[upjsonsite][name] = "www.zhihu.com";
$sum[upjsonsitename][name] = "网站标题占位 ";
}
include ("sqlcon.php");
if($n<1000||$n>0){
//echo "<pre>"; print_r($sum); echo "<pre>";
$sql = "INSERT INTO `urltablefirst`(`id`, `name`, `jsonurl`, `url`, `type`, `times`) VALUES ('{$n}','{$sum[upjsonsitename][name]}','{$sum[upjson][name]}','{$sum[upjsonsite][name]}','{$sum[urltype][name]}','{$n}')";
mysqli_query($conn,$sql);
		
		echo "<script>alert('添加成功');location.href='../sousuo.html';</script>";
}else{
echo "<script>alert('稍后尝试');location.href='../sousuo.html';</script>";
}
?>
