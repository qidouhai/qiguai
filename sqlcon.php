<?php
 
	$conn=mysqli_connect("localhost","qiguai","123456") or die("数据库连接错误");
	
	$select = mysqli_select_db($conn,"urltablefirst");
	
	mysqli_query($conn,"set names 'utf8'");
 ?>
