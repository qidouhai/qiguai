<?php
//接收内容
$searchkeyword = $_POST["souname"];
//域名获取
header('content-type:text/html;charset=utf-8');
$u = "https://www.zhihu.com/api/v4/columns/c_1261258401923026944/items";
$url =$u;
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
echo "<a href=".$url.">".$url."</a>";
}else{
echo 1;
}

?>
