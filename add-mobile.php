<?php
require("config/configuration.php");
require("config/dbcon.php");

$db = new Db();

$id = $db -> quote($_POST["id"]);
$name = $db -> quote($_POST["name"]);
$price = $_POST["price"];
$rating = $db -> quote($_POST["rating"]);
$reviewCount = $db -> quote($_POST["reviewCount"]);
$url = $db -> quote($_POST["url"]);
$reviewUrl = $db -> quote($_POST["reviewUrl"]);
$imageUrl = $db -> quote($_POST["imageUrl"]);
$siteName = $db -> quote($_POST["siteName"]);

$price = (int)$price;
$sql = NULL;
$dateTimeVal = "'".date("Y-m-d H:i:s")."'";
$tableName = NULL;
/* create a prepared statement */
if (isset($siteName) && ($siteName == "'Flipkart'")) {
    $tableName = "`flipkart_mobiles`";
}
else if (isset($siteName) && ($siteName == "'Amazon'")) {
    $tableName = "`amazon_mobiles`";
}

if (isset($tableName)) {
    $sql = "INSERT INTO ".$tableName." (`productId`, `productPrice`, `productLowestPrice`, `productName`, `productRating`, `productReviewCount`, `productUrl`, `productReviewUrl`, `productImageUrl`, `lowestPriceDate`) VALUES($id, $price, $price, $name, $rating, $reviewCount, $url, $reviewUrl, $imageUrl, $dateTimeVal)";
    $result = $db -> query($sql);
}
if (isset($price)) {
    $mainTableName = NULL;
    $historyTableName = NULL;
    if ($siteName == "'Amazon'") {
        $mainTableName = "`amazon_mobiles`";
        $historyTableName = "`amazon_price_history`";
    } else if ($siteName == "'Flipkart'") {
        $mainTableName = "`flipkart_mobiles`";
        $historyTableName = "`flipkart_price_history`";
    }
    
    if (isset($mainTableName) && isset($historyTableName)) {
        $sqlSel = "SELECT `productLowestPrice` FROM ".$mainTableName." WHERE `productId` = ".$id." LIMIT 1";
        $rows = $db -> select($sqlSel);
        if ($rows == false) {
            return_empty();
        }
        else {
            $lowestValue = is_array($rows) ? $rows[0]['productLowestPrice'] : "0";
            $lowestValue = (int)$lowestValue;
            
            if ($lowestValue == 0 || $lowestValue > $price) {
                $result = $db -> query("UPDATE ".$mainTableName." SET  `productLowestPrice`= ".$price.", `lowestPriceDate` = ". $dateTimeVal ." WHERE `productId`= ".$id);
            }
            $result = $db -> query("INSERT INTO ".$historyTableName." (`productId`, `productPrice`, `updatedDate`) VALUES (".$id.",".$price.",".$dateTimeVal.")");
        }
    }
}
function return_empty() {
    echo json_encode (json_decode ("{}"));
}
?>