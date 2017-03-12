<?php
    require("config/configuration.php");

$mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

    $id      = $_POST["id"];
    $name      = $_POST["name"];
    $price      = $_POST["price"];
    $rating      = $_POST["rating"];
    $reviewCount      = $_POST["reviewCount"];
    $url      = $_POST["url"];
    $reviewUrl      = $_POST["reviewUrl"];
    $imageUrl      = $_POST["imageUrl"];
    $siteName = $_POST["siteName"];

/* create a prepared statement */
if (isset($siteName) && ($siteName == "Flipkart")) {
   if ($stmt = $mysqli->prepare("INSERT INTO `flipkart-mobiles` VALUES (?,?,?,?,?,?,?,?)")) {

    /* bind parameters for markers */
    $stmt->bind_param('sissssss', $id, $price, $name, $rating, $reviewCount, $url, $reviewUrl, $imageUrl);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($district);

    /* fetch value */
    $stmt->fetch();

    /* close statement */
    $stmt->close();
    }
}

/* create a prepared statement */
if (isset($siteName) && ($siteName == "Amazon")) {
   if ($stmt = $mysqli->prepare("INSERT INTO `amazon-mobiles` VALUES (?,?,?,?,?,?,?,?)")) {

    /* bind parameters for markers */
    $stmt->bind_param('sissssss', $id, $price, $name, $rating, $reviewCount, $url, $reviewUrl, $imageUrl);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($district);

    /* fetch value */
    $stmt->fetch();

    if (isset($stmt->error)) {
      echo json_encode($stmt->error);
    }
    else {
        echo json_encode("success");
    }

    /* close statement */
    $stmt->close();
    }
}

/* close connection */
$mysqli->close(); 
?>	