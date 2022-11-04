<?php
header('content-type:text/html;charset=utf-8');   
$searchkeyword = $_POST["souname"];

//url验证
$url = $_POST["upjson"];
function or_url($url){

if (filter_var($url, FILTER_VALIDATE_URL) !== false) {

echo 'url 地址正确';

}else{

echo 'url 地址不正确';

}

}
//初始化数据
$n=0;
if($n==0){
$u = "https://www.zhihu.com/api/v4/columns/c_1261258401923026944/items";
}
$rrr = "wwwwwwwww";
//json 判定格式

     
function f($val){
	if(is_array($val)){
	//该变量是数组类型
		return 1;
	}else{
	//该变量不是数组类型
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

if( $_POST["upjson"]||$ysejson=1){
$n=$n+1;
$a+$n= $_POST["upjson"];
}
if($n>1000){
echo "服务器繁忙，请稍后再试";
}


//域名获取
 
 
header('content-type:text/html;charset=utf-8');
 $url = $u;
//获取顶级域名
function getTopHost($url){
	$url = strtolower($url);   //首先转成小写
	$host = parse_url($url)['host'];
	//查看是几级域名
    $data = explode('.', $host);
    $n = count($data);
 
    //判断是否是双后缀
    $preg = '/[\w].+\.(com|net|org|gov|edu)\.cn$/';
    if(($n > 2) &&  preg_match($preg,$host)){
    	//双后缀取后3位
    	$host = $data[$n-3].'.'.$data[$n-2].'.'.$data[$n-1];
    }else{
    	//非双后缀取后两位
    	$host = $data[$n-2].'.'.$data[$n-1];
    }
    return $host;
}

//判定状态码
$url=getTopHost($url);
$url1 = "https://".$url;
$url2 = "http://".$url;

if(get_headers($url1, true))
{
$url=$url1;
}else{
$url=$url2;
};



/**
后期备用
* 取得根域名

* @param type $domain 域名

* @return string 返回根域名

*/
//$domain = $u;
/*
function GetUrlToDomain($domain) {

$re_domain = "";

$domain_postfix_cn_array = array("com", "net", "org", "gov", "edu", "com.cn", "cn");

$array_domain = explode(".", $domain);

$array_num = count($array_domain) - 1;

if ($array_domain[$array_num] == "cn") {

if (in_array($array_domain[$array_num - 1], $domain_postfix_cn_array)) {

$re_domain = $array_domain[$array_num - 2] . "." . $array_domain[$array_num - 1] . "." . $array_domain[$array_num];

} else {

$re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];

}

} else {

$re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];

}

return $re_domain;

}
$genurl=GetUrlToDomain($domain);

*/

/*json  内容获取 */
  

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
echo "<a href=".$url.">$url</a>";
}else{
echo 1;
}

?>
