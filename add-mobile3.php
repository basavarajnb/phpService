<?php
require("config/configuration.php");
    $id      = "AAA2";
    $name      = "OnePlus 3T";
    $price      = 29999;
    $rating      = "5";
    $reviewCount      = "1222";
    $url      = "URL";
    $reviewUrl      = "RURL";
    $imageUrl      = "IURL";
$siteName = "Flipkart";

$mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$city = "Amersfoort";

/* create a prepared statement */
if ($stmt = $mysqli->prepare("INSERT INTO `flipkart-mobiles` VALUES (?,?,?,?,?,?,?,?)")
) {

    /* bind parameters for markers */
    $stmt->bind_param('sissssss', $id, $price, $name, $rating, $reviewCount, $url, $reviewUrl, $imageUrl);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($district);

    /* fetch value */
    $stmt->fetch();

    printf("%s is in district %s\n", $city, $district);

    /* close statement */
    $stmt->close();
}

/* close connection */
$mysqli->close();
?>