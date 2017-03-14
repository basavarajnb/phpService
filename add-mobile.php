<?php
require("config/configuration.php");
require("config/dbcon.php");

$id = $_POST["id"];
$name = $_POST["name"];
$price = $_POST["price"];
$rating = $_POST["rating"];
$reviewCount = $_POST["reviewCount"];
$url = $_POST["url"];
$reviewUrl = $_POST["reviewUrl"];
$imageUrl = $_POST["imageUrl"];
$siteName = $_POST["siteName"];


$sql = NULL;
/* create a prepared statement */
if (isset($siteName) && ($siteName == "Flipkart")) {
    $sql = "INSERT INTO `flipkart_mobiles` (`mobileId`, `mobilePrice`, `mobileLowestPrice`, `mobileName`, `mobileRating`, `mobileReviewCount`, `mobileUrl`, `mobileReviewUrl`, `mobileImageUrl`, `lowestPriceDate`) VALUES (?,?,?,?,?,?,?,?,?,?)";
}
else if (isset($siteName) && ($siteName == "Amazon")) {
    $sql = "INSERT INTO `amazon_mobiles` (`mobileId`, `mobilePrice`, `mobileLowestPrice`, `mobileName`, `mobileRating`, `mobileReviewCount`, `mobileUrl`, `mobileReviewUrl`, `mobileImageUrl`, `lowestPriceDate`) VALUES (?,?,?,?,?,?,?,?,?,?)";
}

$stmt = $mysqli->prepare($sql);
$dateTimeVal = date("Y-m-d H:i:s");

if ($stmt && isset($sql)) {
    /* bind parameters for markers */
    $stmt->bind_param('siisssssss', $id, $price, $price, $name, $rating, $reviewCount, $url, $reviewUrl, $imageUrl, $dateTimeVal);
    
    /* execute query */
    $stmt->execute();
    
    
    $errorStmt1 = $stmt->error;
    $errorMysqli1 = $mysqli->error;
}
if (isset($price)) {
    $mainTableName = NULL;
    $historyTableName = NULL;
    if ($siteName == "Amazon") {
        $mainTableName = "amazon_mobiles";
        $historyTableName = "amazon_price_history";
    } else if ($siteName == "Flipkart") {
        $mainTableName = "flipkart_mobiles";
        $historyTableName = "flipkart_price_history";
    }
    
    if (isset($mainTableName) && isset($historyTableName)) {
        $lowestValue = get_value($mysqli,"SELECT `mobileLowestPrice` FROM `".$mainTableName."` WHERE `mobileId` = '".$id."' LIMIT 1");
        $lowestValue = (int)$lowestValue;
        $price = (int)$price;
        if ($lowestValue == 0 || $lowestValue > $price) {
            $lowestValueInsertSql = "UPDATE `".$mainTableName."` SET  `mobileLowestPrice`= ".$price." WHERE `mobileId`= '".$id."'";
            if ($result = $mysqli->query($lowestValueInsertSql)) {
                $rowsEffected =  $result->num_rows;
                /* free result set */
            }
        }
        $historyInsertSql = "INSERT INTO `".$historyTableName."`(`productId`, `productPrice`, `updatedDate`) VALUES ('".$id."',".$price.",'".$dateTimeVal."')";
        if ($result = $mysqli->query($historyInsertSql)) {
            /* free result set */
        }
    }
}
if ($mysqli->error) {

}
else {
    echo json_encode (json_decode ("{}"));
}

/* close connection */
$mysqli->close();
function get_value($mysqli, $sql) {
    $result = $mysqli->query($sql);
    $rows = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($rows , $row);
        }
    }
    return is_array($rows) ? $rows[0]['mobileLowestPrice'] : "0";
}
?>