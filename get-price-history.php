<?php
require("config/configuration.php");
require("config/dbcon.php");

$db = new Db();

$siteName = $db -> quote($_GET["siteName"]);
$id = $db -> quote($_GET["id"]);

$sql = NULL;
if (isset($siteName) && ($siteName == "'Flipkart'")) {
    $sql = "SELECT * FROM `flipkart_price_history` where `productId` = ".$id;
}
else if (isset($siteName) && ($siteName == "'Amazon'")) {
    $sql = "SELECT * FROM `amazon_price_history` where `productId` = ".$id;
}

if (isset($sql)) {
    $rows = $db -> select($sql);
    if ($rows == false) {
        $output = json_encode (json_decode ("[]"));
    }
    else {
        if (isset($rows)) {
            $output = json_encode($rows);
        }
    }
    echo $output;
}
?>