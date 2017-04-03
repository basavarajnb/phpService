<?php
require("config/configuration.php");
require("config/dbcon.php");

if (isset($_POST["id"])) {
    $id = $_POST["id"];
}
if (isset($_POST["name"])) {
    $name = $_POST["name"];
}
if (isset($_POST["price"])) {
    $price = $_POST["price"];
}
if (isset($_POST["rating"])) {
    $rating = $_POST["rating"];
}
if (isset($_POST["reviewCount"])) {
    $reviewCount = $_POST["reviewCount"];
}
if (isset($_POST["url"])) {
    $url = $_POST["url"];
}

if (isset($_POST["reviewUrl"])) {
    $reviewUrl = $_POST["reviewUrl"];
}

if (isset($_POST["imageUrl"])) {
    $imageUrl = $_POST["imageUrl"];
}

if (isset($_POST["siteName"])) {
    $siteName = $_POST["siteName"];
}
if (isset($id) && isset($siteName))
{
    $mainTableName = NULL;
    $historyTableName = NULL;
    if ($siteName == "Amazon") {
        $mainTableName = "amazon_mobiles";
        $historyTableName = "amazon_price_history";
    } else if ($siteName == "Flipkart") {
        $mainTableName = "flipkart_mobiles";
        $historyTableName = "flipkart_price_history";
    }
    $str= "";
    $sqlStmt = NULL;
    if (isset($price)) {
        if ($str == "") {
            $str = " `productPrice` = ? ,";
        }
        else {
            $str = $str." `productPrice` = ? ,";
        }
    }
    
    if (isset($name)) {
        if ($str == "") {
            $str = " `productName` = '".$name."' , ";
        }
        else {
            $str = $str." `productName` = '".$name."' , ";
        }
    }
    
    if (isset($rating)) {
        if ($str == "") {
            $str = " `productRating` = '".$rating."' , ";
        }
        else {
            $str = $str." `productRating` = '".$rating."' , ";
        }
    }
    
    if (isset($reviewCount)) {
        if ($str == "") {
            $str = " `productReviewCount` = '".$reviewCount."' , ";
        }
        else {
            $str = $str." `productReviewCount` = '".$reviewCount."' , ";
        }
    }
    
    if (isset($url)) {
        if ($str == "") {
            $str = " `productUrl` = '".$url."' , ";
        }
        else {
            $str = $str." `productUrl` = '".$url."' , ";
        }
    }
    
    if (isset($reviewUrl)) {
        if ($str == "") {
            $str = " `productReviewUrl` = '".$reviewUrl."' , ";
        }
        else {
            $str = $str." `productReviewUrl` = '".$reviewUrl."' , ";
        }
    }
    
    if (isset($imageUrl)) {
        if ($str == "") {
            $str = " `productImageUrl` = '".$imageUrl."'";
        }
        else {
            $str = $str." `productImageUrl` = '".$imageUrl."'";
        }
    }
    if ($str != "" ) {
        $str = rtrim($str,', ');
        if ($siteName == "Amazon") {
            $sqlStmt = "UPDATE `".$mainTableName."` SET ".$str." WHERE `productId` = '".$id."'";
        }
        else if ($siteName == "Flipkart") {
            $sqlStmt = "UPDATE `".$mainTableName."` SET ".$str." WHERE `productId` = '".$id."'";
        }
    }
    
    if (isset($sqlStmt)) {
        $currentRow = getValue($mysqli,"SELECT * FROM `".$mainTableName."` WHERE `productId` = '".$id."' LIMIT 1");
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
            if (isset($mainTableName) && isset($historyTableName)) {
                $lowestValue = (int)$currentRow['productLowestPrice'];
                $price = (int)$price;
                $dateTimeVal = date("Y-m-d H:i:s");
                if ($lowestValue == 0 || $lowestValue > $price) {
                    $lowestValueInsertSql = "UPDATE `".$mainTableName."` SET  `productLowestPrice`= ".$price.", `lowestPriceDate` = '". $dateTimeVal ."' WHERE `productId`= '".$id."'";
                    if ($result = $mysqli->query($lowestValueInsertSql)) {
                        $rowsEffected =  $result->num_rows;
                        /* free result set */
                    }
                }
                $productPriceVal = (int)(int)$currentRow['productPrice'];;
                
                if ($productPriceVal != $price) {
                    $historyInsertSql = "INSERT INTO `".$historyTableName."`(`productId`, `productPrice`, `updatedDate`) VALUES ('".$id."',".$price.",'".$dateTimeVal."')";
                    if ($result = $mysqli->query($historyInsertSql)) {
                        /* free result set */
                    }
                }
            }
        }
    }
}
echo json_encode (json_decode ("{}"));
/* close connection */
$mysqli->close();

function getValue($mysqli, $sql) {
    $result = $mysqli->query($sql);
    $rows = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($rows , $row);
        }
    }
    return is_array($rows) ? $rows[0] : "";
}
?>