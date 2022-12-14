#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function displayNotification($username, $concertTitle, $artist, $date, $notification)
{
$con = mysqli_connect("localhost", "ali", "12345", "testdb");
$query = "
INSERT INTO comments (userR, comment_subject, comment_text) VALUES ('$username', 'Concert', '$notification');
";
$result = mysqli_query($con, $query); 

return true;
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "notification":
      return displayNotification($request['username'], $request['concertTitle'], $request['artist'], $request['date'], $request['notification']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("notifyRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

