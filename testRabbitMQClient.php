#!/usr/bin/php
<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$username = $_POST['LoginInfo'];
$password = $_POST['Password'];

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "login";
$request['username'] = $username;
$request['password'] = $password;
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
echo "\n\n";

if ($response==0)
{
  	header('Location: Frontend/login.php');
    	exit();
}
else
{
	 $_SESSION['valid'] = true;
	 $_SESSION['response'] = $response;
	 header('Location: Frontend/landing.php');
   	 exit();
}

echo $argv[0]." END".PHP_EOL;
