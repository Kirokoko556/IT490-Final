#!/usr/bin/php
<?php
@ob_end_clean();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$artist = $_POST['artist'];

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
$request['type'] = "artist";
$request['artist'] = $artist;
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

session_start();
  if(!isset($_SESSION['valid']) OR $_SESSION['valid'] !== true){
      header("location: login.php");
      exit;
  }
  if(isset($_SESSION['response'])){
      $rep = $_SESSION['response'];

      $uname = $rep[0];
      $fname = $rep[1];
      $lname = $rep[2];
      $email = $rep[3];
      include "nav.php";
  }

?>
<html>
<head>
    <meta charset="utf-8">
    <title>Search for Artist</title>
    <style>
    body{
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      background: linear-gradient(120deg, #9370DB,#E6E6FA);
      height: 100vh;
      overflow: hidden;
    }
    table {
        width: 100;
        margin: 0 auto;
        font-size: large;
        border: 1px solid black;
    }
    .center{
      position: absolute;
      top: 50%;
      left:50%;
      transform: translate(-50%, -50%);
      width: 400px;
      background: white;
      border-radius: 10px;
      box-shadow: 20px 20px 50px grey;
    }
.center h1{
      text-align: center;
      color: #9370DB;
      padding: 0 0 20px 0;
      border-bottom: 1px #E6E6FA;
    }
    .center form{
      padding: 0 40px;
      box-sizing: border-box;
    }
    form .txt_field{
      position: relative;
      border-bottom: 2px solid #E6E6FA;
      margin: 30px 0;
    }
    .txt_field input{
      width: 100%;
      padding 0 5px;
      height: 40px;
      font-size: 16px;
      border: none;
      background: none;
      outline: none;
    }
.txt_field label{
      position: absolute;
      top:50%;
      left: 5px;
      color: #9370DB;
      transform: translateY(-50%);
      font-size: 16px;
      pointer-events: none;
      transition: .5s;
    }
    .txt_field span::before {
      content: ' ';
      position: absolute;
      top: 40px;
      left: 0;
      width: 0%;
      height: 2px;
      background: #9370DB;
      transition: .5s;
    }
    .txt_field input:focus ~ label,
    .txt_field input:valid ~ label{
      top: -5px;
      color:#9370DB;
    }
.txt_field input:focus ~ span::before,
    .txt_field input:focus ~ span::before{
      width: 100px;
    }
    .pass{
      margin: -5px 0 20px 5px;
      color: #a6a6a6;
      cursor: pointer;
    }
    .pass:hover{
      text-decoration: underline;
    }
    input[type="Submit"]{
      width: 100%;
      height: 50px;
      border: 1px solid;
      background: #9370DB;

      font-size:18px;
      color: #e9f4fb;
      font-weight: 700;
      cursor: pointer;
      outline:none;
    }
input[type="submit"]:hover{
      border-color: #9370DB;
      transition: .5s;
    }
    .center a{
      color: #9370DB;
      font-size: 16px;
      text-decoration: none;
      color:#9370DB;
    }
</style>
</head>
<body>
    <div class="center">
        <h1>Search For Artist<h1>
        <form method="post" action= "../artistClient.php">

                <div class="txt_field">
                <input type="text" name="artist" id="artist" required>
                <label>Artist</label>
                </div>
                <input type="submit" value="Submit" name="Search Artist">
	</form>
        
     <?php
     if ($response!==0)
     {
     ?>
        <table>
           	<tr>
                	<th>Artist Name</th>
                	<th>Followers</th>
                	<th>Montly Listeners</th>"
                	<th>World Rank</th>
               </tr>
               <tr>;
               		<td><?php echo $response[0];?></td>
                        <td><?php echo $response[1];?></td>
			<td><?php echo $response[2];?></td>
			<td><?php echo $response[3];?>"</td>
               </tr>";
	</table>
      <?php
      }
      ?>
</body>
</html>

