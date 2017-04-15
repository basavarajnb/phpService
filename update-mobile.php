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

if ( $id != "''" && isset($id) && $siteName  != "''" && isset($siteName))
{
    $price = (int) $price;
    $str= "";
    $sqlStmt = NULL;
    $mainTableName = NULL;
    $historyTableName = NULL;
    
    if ( $price != "''" && isset($price)) {
        if ($str == "") {
            $str = " `productPrice` = ".$price." , ";
        }
        else {
            $str = $str." `productPrice` = ".$price." , ";
        }
    }
    
    if ( $name != "''" && isset($name)) {
        if ($str == "") {
            $str = " `productName` = ".$name." , ";
        }
        else {
            $str = $str." `productName` = ".$name." , ";
        }
    }
    
    if ( $rating != "''" && isset($rating)) {
        if ($str == "") {
            $str = " `productRating` = ".$rating." , ";
        }
        else {
            $str = $str." `productRating` = ".$rating." , ";
        }
    }
    
    if ( $reviewCount != "''" && isset($reviewCount)) {
        if ($str == "") {
            $str = " `productReviewCount` = ".$reviewCount." , ";
        }
        else {
            $str = $str." `productReviewCount` = ".$reviewCount." , ";
        }
    }
    
    if ( $url != "''" && isset($url)) {
        if ($str == "") {
            $str = " `productUrl` = ".$url." , ";
        }
        else {
            $str = $str." `productUrl` = ".$url." , ";
        }
    }
    
    if ( $reviewUrl != "''" && isset($reviewUrl)) {
        if ($str == "") {
            $str = " `productReviewUrl` = ".$reviewUrl." , ";
        }
        else {
            $str = $str." `productReviewUrl` = ".$reviewUrl." , ";
        }
    }
    
    if ( $imageUrl != "''" && isset($imageUrl)) {
        if ($str == "") {
            $str = " `productImageUrl` = ".$imageUrl;
        }
        else {
            $str = $str." `productImageUrl` = ".$imageUrl;
        }
    }
    
    if ($siteName == "'Amazon'") {
        $mainTableName = "`amazon_mobiles`";
        $historyTableName = "`amazon_price_history`";
    } else if ($siteName == "'Flipkart'") {
        $mainTableName = "`flipkart_mobiles`";
        $historyTableName = "`flipkart_price_history`";
    }

    if ($str != "" ) {
        $str = rtrim($str,', ');
        if ($siteName == "'Amazon'") {
            $sqlStmt = "UPDATE ".$mainTableName." SET ".$str." WHERE `productId` = ".$id;
        }
        else if ($siteName == "'Flipkart'") {
            $sqlStmt = "UPDATE ".$mainTableName." SET ".$str." WHERE `productId` = ".$id;
        }
    }
    
    if (isset($sqlStmt)) {
        $selectRowSql = "SELECT * FROM ".$mainTableName." WHERE `productId` = ".$id." LIMIT 1";
        $currentRow = $db -> select($selectRowSql);
        $currentRow = is_array($currentRow) ? $currentRow[0] : NULL;
        
        $result = $db -> query($sqlStmt);
        
        if (isset($price)) {
            if (isset($mainTableName) && isset($historyTableName)) {
                $lowestValue = (int)$currentRow['productLowestPrice'];
                $dateTimeVal = "'".date("Y-m-d H:i:s")."'";
                if ($lowestValue == 0 || $lowestValue > $price) {
                    $lowestValueInsertSql = "UPDATE ".$mainTableName." SET  `productLowestPrice`= ".$price.", `lowestPriceDate` = ". $dateTimeVal ." WHERE `productId`= ".$id;
                    $result = $db -> query($lowestValueInsertSql);
                }
                
                $productPriceVal = (int)$currentRow['productPrice'];;
                if ($productPriceVal != $price) {
                    $historyInsertSql = "INSERT INTO ".$historyTableName." (`productId`, `productPrice`, `updatedDate`) VALUES (".$id.",".$price.",".$dateTimeVal.")";
                    $result = $db -> query($historyInsertSql);
                }
            }
        }
    }
}
echo json_encode (json_decode ("{}"));
?>