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


if (isset($id) && isset($siteName))
{
    $str= "";
    $sqlStmt = NULL;
    if (isset($price)) {
        if ($str == "") {
            $str = " `mobilePrice` = ? ,";
        }
        else {
            $str = $str." `mobilePrice` = ? ,";
        }
    }
    
    if (isset($name)) {
        if ($str == "") {
            $str = " `mobileName` = '".$name."' , ";
        }
        else {
            $str = $str." `mobileName` = '".$name."' , ";
        }
    }
    
    if (isset($rating)) {
        if ($str == "") {
            $str = " `mobileRating` = '".$rating."' , ";
        }
        else {
            $str = $str." `mobileRating` = '".$rating."' , ";
        }
    }
    
    if (isset($reviewCount)) {
        if ($str == "") {
            $str = " `mobileReviewCount` = '".$reviewCount."' , ";
        }
        else {
            $str = $str." `mobileReviewCount` = '".$reviewCount."' , ";
        }
    }
    
    if (isset($url)) {
        if ($str == "") {
            $str = " `mobileUrl` = '".$url."' , ";
        }
        else {
            $str = $str." `mobileUrl` = '".$url."' , ";
        }
    }
    
    if (isset($reviewUrl)) {
        if ($str == "") {
            $str = " `mobileReviewUrl` = '".$reviewUrl."' , ";
        }
        else {
            $str = $str." `mobileReviewUrl` = '".$reviewUrl."' , ";
        }
    }
    
    if (isset($imageUrl)) {
        if ($str == "") {
            $str = " `mobileImageUrl` = '".$imageUrl."'";
        }
        else {
            $str = $str." `mobileImageUrl` = '".$imageUrl."'";
        }
    }
    if ($str != "" ) {
        $str = rtrim($str,', ');
        if ($siteName == "Amazon") {
            $sqlStmt = "UPDATE `amazon_mobiles` SET ".$str." WHERE `mobileId` = '".$id."'";
        }
        else if ($siteName == "Flipkart") {
            $sqlStmt = "UPDATE `flipkart_mobiles` SET ".$str." WHERE `mobileId` = '".$id."'";
        }
    }
    
    if (isset($sqlStmt)) {
        if (!($stmt = $mysqli->prepare($sqlStmt))) {
            $prepareErrorStr =  "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            exit();
        } else {
            /* bind parameters for markers */
            if (isset($price)) {
                if (!($stmt->bind_param('i', $price))) {
                    $prepareErrorStr =  "bind_param failed: (" . $mysqli->errno . ") " . $mysqli->error;
                    exit();
                }
            }
            /* execute query */
            if (!($stmt->execute())) {
                $prepareErrorStr =  "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
                exit();
            }
            $errorStr = $stmt->error;
            
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
                $historyInsertSql = "INSERT INTO `".$historyTableName."`(`productId`, `productPrice`, `updatedDate`) VALUES ('".$id."',".$price.",'".date("Y-m-d H:i:s")."')";
                if ($result = $mysqli->query($historyInsertSql)) {
                    /* free result set */
                }
            }
        }
    }
}
echo json_encode (json_decode ("{}"));
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