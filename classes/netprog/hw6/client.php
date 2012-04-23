<?php
include_once "xml_rpc.php";

# Change these two paths in order to run the server in a new location
$server = "danomoseley.com";
$path = "/rpc/server.php";


if(isset($_POST["cmd"])){
	
	# Process a command to get the number of names in the directory
	if($_POST["cmd"]=="getnumname"){
		list($success, $response) = XMLRPC_request($server, "/rpc/server.php", "hw6.getnumname");
		if($success){
			echo "There are ".$response." names in the directory";
		}else{
			echo $response["faultString"];
		}
	}
	# Process a command to get a lis of all names in the directory
	else if($_POST["cmd"]=="listallnamed"){
		list($success, $response) = XMLRPC_request($server, "/rpc/server.php", "hw6.listallnamed");
		if($success){
			foreach($response as $name){
				echo $name."<br/>";
			}
		}else{
			echo $response["faultString"];
		}
	}
	# Process a command to add a new name-email pair to the directory
	else if($_POST["cmd"]=="add"){
		list($success, $response) = XMLRPC_request($server, $path, "hw6.add", array(XMLRPC_prepare($_POST['name']),XMLRPC_prepare($_POST['email'])));
		if($success){
			echo "done";
		}else{
			echo $response["faultString"];
		}
	}
	# Process a command to remove a name-email pair from the directory
	else if($_POST["cmd"]=="remove"){
		list($success, $response) = XMLRPC_request($server, $path, "hw6.remove", array(XMLRPC_prepare($_POST['name']),XMLRPC_prepare($_POST['email'])));
		if($success){
			echo "done";
		}else{
			echo $response["faultString"];
		}
	}
	# Process a command to get the email associated with a name
	else if($_POST["cmd"]=="getemailbyname"){
		list($success, $response) = XMLRPC_request($server, $path, "hw6.getemailbyname", array(XMLRPC_prepare($_POST['name'])));
		if($success){
			foreach($response as $email){
				echo $email."<br/>";
			}
		}else{
			echo $response["faultString"];
		}
	}
	# Process a command to get the name associated with an email
	else if($_POST["cmd"]=="getnamebyemail"){
		list($success, $response) = XMLRPC_request($server, $path, "hw6.getnamebyemail", array(XMLRPC_prepare($_POST['email'])));
		if($success){
			echo $response;
		}else{
			echo $response["faultString"];
		}
	}
	# Search the directory for a name
	else if($_POST["cmd"]=="namesearch"){
		list($success, $response) = XMLRPC_request($server, $path, "hw6.namesearch", array(XMLRPC_prepare($_POST['name'])));
		if($success){
			foreach($response as $name){
				echo $name."<br/>";
			}
		}else{
			echo $response["faultString"];
		}
	}
	# Search the directory for an email
	else if($_POST["cmd"]=="emailsearch"){
		list($success, $response) = XMLRPC_request($server, $path, "hw6.emailsearch", array(XMLRPC_prepare($_POST['email'])));
		if($success){
			foreach($response as $email){
				echo $email."<br/>";
			}
		}else{
			echo $response["faultString"];
		}
	}	
	echo "<br/><a href=client.php>Go Back</a>";	
}else{
?>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="getnumname">
<input type="submit" value="Get Number of Names">
</form>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="listallnamed">
<input type="submit" value="List All Names">
</form>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="add">
<input type="text" name="name"><br/>
<input type="text" name="email"><br/>
<input type="submit" value="Add new name-email pair">
</form>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="remove">
<input type="text" name="name"><br/>
<input type="text" name="email"><br/>
<input type="submit" value="Remove name-email pair">
</form>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="getemailbyname"
<input type="text" name="name"><br/>
<input type="submit" value="Get Emails For This Name">
</form>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="getnamebyemail"
<input type="text" name="email"><br/>
<input type="submit" value="Get Name For This Email">
</form>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="namesearch"
<input type="text" name="name"><br/>
<input type="submit" value="Search For This name">
</form>

<form action="client.php" method="post">
<input type="hidden" name="cmd" value="emailsearch"
<input type="text" name="email"><br/>
<input type="submit" value="Search For This Email">
</form>

<?php
}
?>