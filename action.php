<?php
session_start();
header('content-type:text/html;charset=utf-8');   
//接收内容

$urltype = $_POST["urltype"];  //站点/小程序/app的类型 （1 网站 2 小程序 3 app ）

$upjson = trim($_POST["upjson"]);    //json网址链接

$upjsonsite = trim($_POST["upjsonsite"]);  //站点网址链接

$upjsonsitename =  trim($_POST["upjsonsitename"]);   //站点名称

$upsign = trim($_POST["sign"]);    //站点标识

$_SESSION['urltype'] = $urltype;
$_SESSION['upjson'] = $upjson;
$_SESSION['upjsonsite'] = $upjsonsite;
$_SESSION['upjsonsitename'] = $upjsonsitename;
$_SESSION['sign'] = $upsign;


//url验证
//$url = $_POST["upjson"];
//1 地址接近正确
//2 url 地址不正确
function or_url($url){
if (filter_var($url, FILTER_VALIDATE_URL) !== false) {

return 1;
}else{

return 2;
}

}

$urlzhuangtai_1=or_url($upjson);
$urlzhuangtai_2=or_url($upjsonsite);





if ($urlzhuangtai_1==1||$urlzhuangtai_2==1){
echo "你提交的内容如下，请检查是否有误</br>";
if ($urltype==1){
echo  "类型：网站"."</br>";
}elseif($urltype==2){
echo  "类型：小程序"."</br>";
}else{
echo  "类型：APP"."</br>";
}
 echo "JSON：".$upjson."</br>";
echo "网址：".$upjsonsite."</br>";
echo "网站名称：".$upjsonsitename."</br>";
echo "网站标识：".$upsign."</br>";
echo<<<EOT
<a href="javascript:history.back(-1)" class="dropdown-toggle">
               返回修改
              </a>
EOT;
echo<<<EOT
<form action="/reok.php" method="post">
<label><input name="reok" type="hidden" value="ok" /></label> 
<input type="submit" value="确认提交" class="button"></form>
EOT;
}else{
echo "url不正确";
echo<<<EOT
<a href="javascript:history.back(-1)" class="dropdown-toggle">
               返回
              </a>
EOT;
}
?>
