<?php
session_start();
header('content-type:text/html;charset=utf-8');   
//接收内容

$rssjson = $_POST["rssorjson"];	//rss 或 json

$urltype = $_POST["urltype"];  //站点/小程序/app的类型 （1 网站 2 小程序 3 app ）

$upjson = trim($_POST["upjson"]);    //json网址链接

$upjsonsite = trim($_POST["upjsonsite"]);  //站点网址链接

$upjsonsitename =  trim($_POST["upjsonsitename"]);   //站点名称

$upsign = trim($_POST["sign"]);    //站点标识


if($urltype==" "){
echo "不支持提交空数据";
echo "<script>alert('稍后尝试');location.href='http://www.baidu.com';</script>";
die;
}elseif($upjson==" "){
echo "不支持提交空数据";
echo "<script>alert('稍后尝试');location.href='http://www.baidu.com';</script>";
die;
}elseif($upjsonsite==" "){
echo "不支持提交空数据";
echo "<script>alert('稍后尝试');location.href='http://www.360.cn';</script>";
die;
}elseif($upjsonsitename==" "){
echo "不支持提交空数据";
echo "<script>alert('稍后尝试');location.href='http://www.sogou.com';</script>";
die;
}elseif($upsign==" "){
echo "不支持提交空数据";
echo "<script>alert('稍后尝试');location.href='http://www.qq.com';</script>";
die;
}

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
$urlzhuangtai_3=or_url($upjsonsite);

/**

* 解析json串

* @param type $json_str

* @return type

*/

function analyJson($json_str) {

$json_str = str_replace('＼＼', '', $json_str);

$out_arr = array();

preg_match('/{.*}/', $json_str, $out_arr);

if (!empty($out_arr)) {

$result = json_decode($out_arr[0], TRUE);

} else {

return FALSE;

}

return TRUE;

}

$yanzhengjson = analyJson($upjson);

//rss判断
function analyrss($isrsslink){
$isrsslink = file_get_contents($isrsslink);


$atom = "http://www.w3.org/2005/Atom";

$rdf = "http://www.w3.org/1999/02/22-rdf-syntax-ns";

$rss = "http://purl.org/dc/elements/1.1/";

$rss2 = "rss version=\"2.0\"";

$isatom = stristr($isrsslink,$atom);

$isrdf = stristr($isrsslink,$rdf);

$isrss = stristr($isrsslink,$rss);

$isrss2=strstr($isrsslink,$rss2);

if($isatom){return 1;}elseif($isrdf){return 2;}elseif($isrss){return 3;}elseif($isrss){return 4;}else{return 5;}

}

$yanzhengrss = analyrss($upjson);

//rssjson 不为空
if($rssjson==" "){
echo "您没有选择提交类型（rss 或 json）";
echo<<<EOT
<a href="javascript:history.back(-1)" class="dropdown-toggle">
               返回
              </a>
EOT;
die;
}else{

//rss 链接不能选择json
//json 不能选择rss 判定

if($yanzhengrss <> 5){if($rssjson!=5){
echo "您选择的类型有错误（请选择rss）";
echo<<<EOT
<a href="javascript:history.back(-1)" class="dropdown-toggle">
               返回
              </a>
EOT;
die;
}
} 
if($yanzhengjson==true){
if($rssjson!==6){
echo "您选择的类型有错误（请选择 json）";
echo<<<EOT
<a href="javascript:history.back(-1)" class="dropdown-toggle">
               返回
              </a>
EOT;
die;
}
}


//rss json 分别提交前检测
if($rssjson==5 && $yanzhengrss <> 5){
$reok="http://www.hihot.cn/qiguai/rssreok.php";
}else{
$reok="http://www.hihot.cn/qiguai/reok.php";

}
}
//输出


if ($urlzhuangtai_1==1 && $urlzhuangtai_2==1 && $urlzhuangtai_3==1){
if($yanzhengjson== TRUE){
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
<form action="$reok" method="post">
<label><input name="reok" type="hidden" value="ok" /></label> 
<input type="submit" value="确认提交" class="button"></form>
EOT;
}elseif($yanzhengrss!=5){
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
<a href="javascript:history.back(-2)" class="dropdown-toggle">
               返回修改
              </a>
EOT;
echo<<<EOT
<form action="$reok" method="post">
<label><input name="reok" type="hidden" value="ok" /></label> 
<input type="submit" value="确认提交" class="button"></form>
EOT;
}else{
echo "json或rss链接据格式不正确";
echo<<<EOT
<a href="javascript:history.back(-2)" class="dropdown-toggle">
               返回
              </a>
EOT;
}
}else{
echo "url不正确";
echo<<<EOT
<a href="http://www.hihot.cn/qiguai/tijiao.html" class="dropdown-toggle">
               返回修改
              </a>
EOT;
}
?>
