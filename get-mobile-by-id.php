<?php
    require("config/configuration.php");


$siteName = $_GET["siteName"];
$id = $_GET["id"];
$link = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

if (isset($siteName) && ($siteName == "Flipkart")) {
   $str = "SELECT * FROM `flipkart-mobiles` where flipkartMobileID = '".mysql_escape_string($id)."'";

   $result1 = mysqli_query($link, $str);
   if (!$result1) {
    die('Could not query:' . mysql_error());
   }
   $rows = array();

   while($r = mysqli_fetch_assoc($result1)) {
      array_push($rows , $r);
   }
   if (isset($rows[0]))
      print json_encode($rows[0]);
   else {
      print "";
   }
}

else if (isset($siteName) && ($siteName == "Amazon")) {

   $str = "SELECT * FROM `amazon-mobiles` where amazonMobileID = '".mysql_escape_string($id)."'";

    $result1 = mysqli_query($link, $str);
   if (!$result1) {
    die('Could not query:' . mysql_error());
   }
   $rows = array();

   while($r = mysqli_fetch_assoc($result1)) {
      array_push($rows , $r);
   }
   if (isset($rows[0]))
      print json_encode($rows[0]);
   else {
      print "";
   }
}

mysqli_close($con);
?>




			