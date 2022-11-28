<?php

//rsstojson
include ("./rsstojson.php");
include ("./rssyan.php");

//sql查库

include ("sqlcon.php");
$sql  = "select id,name,jsonurl,url,type,times,sign from urltablefirst"; 
$result = mysqli_query($conn,$sql);
$m=mysqli_num_rows($result);
   //获取所有行作为数组
    for($i=0;$i<=$m;$i++){
   $sqlu="select * from urltablefirst where id = $i";
   $results=mysqli_query($conn,$sqlu);
     $row = mysqli_fetch_assoc($results);       
  
   $name=$row["name"];
      $jsonurl=$row["jsonurl"];
      $url=$row["url"];
      $type=$row["type"];
      $sign=$row["sign"];
	  
	  //rss 判断
	  
	  $yanzhengrss = analyrss($jsonurl);
	  
	  if( $yanzhengrss !==5){
	  $arr=rsstojson($jsonurl);  //rss 转json
	  //$arr=htmlspecialchars_decode($arr);
	  //$arr=strip_tags($arr);
	  $arr= json_decode($arr,true); 
	  foreach($arr as $key=>$value){
	  $title=$value[title];
	  
	  //$description 过滤rsshub 内容
	  $description=$value[description];
		if($description){
			$hub=" - Made with love by RSSHub(https://github.com/DIYgod/RSSHub)";
			if(strstr($description,$hub)){
		$description=str_replace($hub,"",$description);
							}else{
	  $description=$description;
							}
	  }else{
	  $description=$value[description];
	  	 }
	  
	  $lastBuildDate=$value[lastBuildDate];
		  
	  // sql 入库
		//$rusql  = "INSERT INTO 'urltittle' ('sitename','sitedescription','siteurl','sitetype','lastBuildDate') VALUES ('{$title}','{$description}','{$url}','{$type}','{$lastBuildDate}')";
		//$ruresult = mysqli_query($conn,$rusql);
		
	  foreach($value[item] as $key=>$values){
	  $searchresultsf = trim($values[title]);
	  $guiurl=$values[link];
	  
	  //空格 链接 非中文过滤
	  if($values[description]){
	  $itemdescription=$values[description];
	  $itemdescription=str_replace("/<a[^>]+href=\"(.*?)\"[^>]+data-poster=\"(.*?)\"[^>]*>.*?<\/a>/is"," ",$itemdescription);
	  $itemdescription=strip_tags($itemdescription);
	  $itemdescription=preg_replace("/[^\x{4E00}-\x{9FFF}]+/u"," ",$itemdescription);
	  }else{
	  $itemdescription=$values[description];
	  $itemdescription=str_replace("/<a[^>]+href=\"(.*?)\"[^>]+data-poster=\"(.*?)\"[^>]*>.*?<\/a>/is"," ",$itemdescription);
	  $itemdescription=preg_replace("/[^\x{4E00}-\x{9FFF}]+/u"," ",$itemdescription);
	  $itemdescription=strip_tags($itemdescription);

	  }
	  $itempubDate=$values[pubDate];
	  $giveup="?from=rss";
	  if($guiurl){
	  if(strstr($guiurl,$giveup)){
	  $guiurl=str_ireplace($giveup," ",$guiurl);
	  }else{
	  $guiurl=$guiurl;
 	 }
	 }else{
		  $guiurl=$url;
		 }
		 date_default_timezone_set("Asia/Shanghai");
		 $newthistime=time();
		 //echo '1'.$title.'<br>';
		 //echo '2'.$description.'<br>';
		 //echo '3'.$url.'<br>';
		 //echo '4'.$type.'<br>';
		 
		 //echo '6'.$lastBuildDate.'<br>';
		 //echo '7'.$searchresultsf.'<br>';
		 //echo '8'.$itemdescription.'<br>';
		 //echo '9'.$guiurl.'<br>';
		 //echo '10'.$itempubDate.'<br>';
		 //echo 'time():'.time().'<br>';
		$lastBuildDate = time($lastBuildDate);
		$itempubDate = time(itempubDate);
		 
		 // sql 入库
	 
	  //$upsql = "INSERT INTO 'urltittle'('sitename','sitedescription','siteurl','sitetype','updatatime','lastBuildDate','tittle','description','link','pubDate','keywords','statue','follow','helpful') VALUES ('{$title}','{$description}','{$url}','{$type}','{$newthistime}','{$lastBuildDate}','{$searchresultsf}','{$itemdescription}','{$guiurl}','{$itempubDate}','0','0','0','0')";
	 $upsql = "INSERT INTO `urltittle`(`sitename`, `sitedescription`, `siteurl`, `sitetype`, `updatatime`, `lastBuildDate`, `tittle`, `description`, `link`, `pubDate`, `keywords`, `statue`, `follow`, `helpful`) VALUES ('{$title}','{$description}','{$url}','{$type}','{$newthistime}','{$lastBuildDate}','{$searchresultsf}','{$itemdescription}','{$guiurl}','{$itempubDate}',0,0,0,0)";
	 //$upresult = mysqli_query($conn,$upsql);
	 if ($conn->multi_query($upsql) === TRUE) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $upsql . "<br>" . $conn->error;
}
	 }
	 }
	 }
}

   //结束语句
   mysqli_free_result($results);
   mysqli_free_result($result);
  // mysqli_free_result($ruresult);
   mysqli_free_result($upresult);

   //关闭连接
   mysqli_close($conn);



?>
