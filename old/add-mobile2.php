<?php
    require("config/configuration.php");
    require("config/dbcon.php");

    $id      = "AAA";
    $name      = "OnePlus 3T";
    $price      = 29999;
    $rating      = "5";
    $reviewCount      = "1222";
    $url      = "URL";
    $reviewUrl      = "RURL";
    $imageUrl      = "IURL";
$siteName = "Flipkart";

    if( isset($id) && isset($price)){
        if (isset($siteName) && ($siteName == "Amazon")) {
            $stmt = $mysqli->prepare("INSERT INTO amazon_mobiles(`amazonMobileId`, `amazonMobileName`, `amazonMobilePrice`, `amazonMobileRating`, `amazonMobileReviewCount`, `amazonMobileUrl`, `amazonMobileReviewUrl`, `amazonMobileImageUrl`) VALUES (?,?,?,?,?,?,?)");
        }
        else if (isset($siteName) && ($siteName == "Flipkart")) {
            $stmt = $mysqli->prepare("INSERT INTO flipkart_mobiles (`flipkartMobileId`, `flipkartMobilePrice`, `flipkartMobileName`, `flipkartMobileRating`, `flipkartMobileReviewCount`, `flipkartMobileUrl`, `flipkartMobileReviewUrl`, `flipkartMobileImageUrl`) VALUES (?,?,?,?,?,?,?,?)");

        }
else {
echo json_encode("SITENAME NOT SET");
}
        $stmt->bind_param('sissssss', $id, $price, $name, $rating, $reviewCount, $url, $reviewUrl, $imageUrl);

        /* execute prepared statement */
        $stmt->execute();
echo json_encode("EXECUTED QUERY");

        if (isset($stmt->error)) {
            echo json_encode($stmt->error);
        }
        else {
            echo json_encode("success");
        }
        /* close statement and connection */
        $stmt->close();
    }
else {
echo json_encode("The ID and Price are NOT SET");
}
 
?>	