<?php
require("config/configuration.php");
require("config/dbcon.php");

$db = new Db();

$siteName = $db -> quote($_GET["siteName"]);
$id = $db -> quote($_GET["id"]);

$sql = NULL;
if (isset($siteName) && ($siteName == "'Flipkart'")) {
    $sql = "SELECT * FROM `flipkart_mobiles` where `productID` = ".$id;
}
else if (isset($siteName) && ($siteName == "'Amazon'")) {
    $sql = "SELECT * FROM `amazon_mobiles` where `productID` = ".$id;
}

if (isset($sql)) {
    $rows = $db -> select($sql);
    if ($rows == false) {
        $output = json_encode (json_decode ("{}"));
    }
    else {
        if (isset($rows[0])) {
            $output = json_encode($rows[0]);
        }  
    }
    echo $output;
}
?>