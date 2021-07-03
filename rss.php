#!/usr/bin/php -q
<?php

include 'config.php';
define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__.'/src/Facebook/');
require_once(__DIR__.'/src/Facebook/autoload.php');


$servername = "localhost";
$username = "";
$password = "j%byl^M78YqT";
$dbname = "itlearne_gossip_db";


//Rss feed url

  $xml=("https:/exsample.com/feed");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

//get elements from "<channel>"
$channel=$xmlDoc->getElementsByTagName('channel')->item(0);

//Get rss feed item title
$channel_title = $channel->getElementsByTagName('title')
->item(0)->childNodes->item(0)->nodeValue;

//Get rss feed item url
$channel_link = $channel->getElementsByTagName('link')
->item(0)->childNodes->item(0)->nodeValue;

//Get rss feed item description
$channel_desc = $channel->getElementsByTagName('description')
->item(0)->childNodes->item(0)->nodeValue;

//output elements from "<channel>"
echo("<p><a href='" . $channel_link
  . "'>" . $channel_title . "</a>");
echo("<br>");
echo($channel_desc . "</p>");

//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');
for ($i=0; $i<=1; $i++) {
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue;
  
  /* View result
  echo ("<p><a href='" . $item_link
  . "'>" . $item_title . "</a>");
  echo ("<br>");
  echo ($item_desc . "</p>");
*/



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$key_id = $item_link;



//Insert feed url to DB
$sql = "SELECT * FROM rss_table_name WHERE link='$key_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

 echo "found";

} else {

  $sql = "INSERT INTO rss_table (title, des, link)
VALUES ('$item_title', '$item_desc', '$item_link')";
if ($conn->query($sql) === TRUE) {
  echo "New url successfully added";
  
//facebook api
//Add your facebook app ID and secret
$fb = new Facebook\Facebook([
 'app_id' => '',
 'app_secret' => '',
 'default_graph_version' => 'v10.0',
]);

//Post property to Facebook
$linkData = [
 'link' => $item_link,
 'message' => $item_desc
];
$pageAccessToken = $token;

try {
 $response = $fb->post('/me/feed', $linkData, $pageAccessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 echo 'Graph returned an error: '.$e->getMessage();
 exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 echo 'Facebook SDK returned an error: '.$e->getMessage();
 exit;
}
$graphNode = $response->getGraphNode();

}
  
  
}

}
$conn->close();

?>