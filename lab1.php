<?php

include_once 'DBConnector.php';
include_once 'user.php';



if(isset($_POST['btn-save'])){
	$conn = mysql_connect("localhost", "root","") or die("Error: " .mysql_error());
		$db=mysql_select_db("btc3205",$conn);
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$city = $_POST['city_name'];
	
	$user = new User($first_name,$last_name,$city);
	$res = $user->save();
	
	if($res){
		echo "Save operation was successful";
		} else {
			echo "An error occured!";
			}
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LAB1</title>
</head>

<body>
	<form method="post" name="user_details" id="user_details" action="<?=$_SERVER['PHP_SELF']?>">
    	<table align="center">
        	<tr>
            	<td>
                	
                </td>
            </tr>
        	<tr>
        		<td><input type="text" name="first_name" required placeholder="First Name" /> </td>
            </tr>
            <tr>
            	<td><input type="text" name="last_name" placeholder="Last Name"/></td>
            </tr>
            <tr>
            	<td><input type="text" name="city_name" placeholder="City"/></td>
            </tr>
            
            <tr>
            	<td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
            <tr>
            	<td>
                	<a href="login.php">Login</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>