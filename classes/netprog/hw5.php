<?php
if(isset($_POST['method'])){
	$username = "dbo323736322";
	$password = "hw5cookie";
	$hostname = "db2372.perfora.net";	
	$dbh = mysql_connect($hostname, $username, $password)
		or die("Unable to connect to MySQL");
	$selected = mysql_select_db("db323736322",$dbh) 
		or die("Could not select first_test");
	if($_POST['method']=="update"){
		if(isset($_POST['x']) && isset($_POST['y']) && isset($_POST['id'])){
			$query = sprintf("UPDATE location SET x=%s,y=%s WHERE id=%s",
						mysql_real_escape_string($_POST['x']),
						mysql_real_escape_string($_POST['y']),
						mysql_real_escape_string($_POST['id']));
						
			if (mysql_query($query)) {
			  print "successfully inserted record";
			}
			else {
				  print "Failed to insert record";
			}			
		}else{
			print "Please provide appropriate arguments";
		}
	}else if($_POST['method']=="get"){
		if(isset($_POST['id'])){
			$query = sprintf("SELECT * FROM location WHERE id=%s",
						mysql_real_escape_string($_POST['id']));
			$result = mysql_query($query);
			$row = mysql_fetch_row($result);
			if($row){
				$ret = array("id"=>$row[0],"code"=>200,"x"=>$row[1], "y"=>$row[2]);
				echo json_encode($ret);
			}else{
				$ret = array("code"=>400,"message"=>"Could not find that id");
				echo json_encode($ret);
			}
		}else{
			$ret = array("code"=>400,"message"=>"Please provide id for method get");
			echo json_encode($ret);
		}
	}else{
		$ret = array("code"=>400,"message"=>"Unsupported method");
		echo json_encode($ret);
	}
	mysql_close($dbh);
}else{
	$ret = array("code"=>400,"message"=>"Please provide method");
	echo json_encode($ret);
}
?>