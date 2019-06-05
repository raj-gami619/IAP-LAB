<?php
session_start();
if(!isset($_SESSION['username'])){
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>private</title>
	<script type="text/javascript" src="validate.js"></script>
    <script type="text/javascript" src="apikey.js"></script>
	<link rel="stylesheet" type="text/css" href="validate.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css.map">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css.map">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css.map">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css.map">



</head>
<body>
<p><a href="logout.php">Logout</a></p>
<hr>
<h3>Here we will create an api key that will allow users /developers to order items from the external system</h3>
<hr>
<h4>We now put this feature of allowing users to generate an API key. Click the button to generate the API key.</h4>
<button class="btn-btn-primary" id="api-key-btn">Generate API Key</button> <br> <br>
<strong>Your API key:</strong> (Note: if your api key is already in use by already running applications,generating a new key will stop the application from functioning) <br>
<textarea cols="100" rows="2" id="api_key" name="api_key" readonly><?php echo fetchUserApiKey(); ?></textarea>

<h3>Service description: </h3>
We have a service that allows exxternal application top order food and also pull all order status by using order id.Lets do it
<hr>
</body>
</html>

<?php
    include_once 'DBConnector.php';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('HTTP/1.0 403 forbidden');
        echo 'You are forbidden';
    }else{
        $api_key = null;
        $api_key = generateApiKey(64);
        header('Content-type: application/json');
        echo generateResponse($api_key);
    }
    function generateApiKey($str_length){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $bytes= openssl_random_pseudo_bytes(3*$str_length/4+1);

        $repl = unpack('c2' , $bytes);

        $first =$chars[$repl[1]%62];
        $second =$chars[$repl[2]%62];
        return strtr(substr(base64_encode($bytes), 0, $str_length), '+/',  "$first$second");
    }
    function saveApiKey(){

    }
    function generateResponse($api_key){
        if (saveApiKey()){
            $res = [ 'success' => 1, 'message' => $api_key];
        }else{
            $res = [ 'success' => 0, 'message' => 'Something went wrong. Please generate the API key.'];
        }
        return json_encode($res);
    }
    function fetchUserApiKey(){

    }
?>