<?php
require("config/configuration.php");
require("config/dbcon.php");


$siteName = $_GET["siteName"];
$id = $_GET["id"];
$sql = "";
if (isset($siteName) && ($siteName == "Flipkart")) {
    $sql = "SELECT * FROM `flipkart_mobiles` where `productID` = '".$id."'";
}
else if (isset($siteName) && ($siteName == "Amazon")) {
    $sql = "SELECT * FROM `amazon_mobiles` where `productID` = '".$id."'";
}

if (isset($sql) && ($sql != "")) {
    $result = $mysqli->query($sql);
    $rows = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($rows , $row);
        }
    }

    if (isset($rows[0])) {
        $output = json_encode($rows[0]);
    }
    else {
        $output = json_encode (json_decode ("{}"));
    }    
    echo $output;
}
$mysqli->close();
?>