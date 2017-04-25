<?php
require("config/configuration.php");
require("config/dbcon.php");

$db = new Db();

$brand = $db -> quote($_GET["brand"]);
$model = $db -> quote($_GET["model"]);

$sql = NULL;
if (($brand != "''") && ($model != "''")) {
    $sql = "SELECT  `temp`.`mobileId`, `amazonMobileId`, `flipkartMobileId`, `brandName`, `modelName`, `storage`, `color` , `modelPopularity` , `productId`, `productPrice`, `productLowestPrice`, `productName`,`productRating`,`productReviewCount`,`productUrl`,`productReviewUrl`,`productImageUrl`,`lowestPriceDate`
    from (
    SELECT `ma`.`mobileId`, `amazonMobileId`, `flipkartMobileId`, `brandName`, `modelName`, `storage`, `color` , `modelPopularity` , `productId`, `productPrice`, `productLowestPrice`, `productName`,`productRating`,`productReviewCount`,`productUrl`    ,`productReviewUrl`,`productImageUrl`,`lowestPriceDate`
    FROM `mobiles_association` `ma`
    INNER JOIN (select `mp`.`mobileId` AS `mobileId`,`b`.`brandName` AS `brandName`,`m`.`modelName` AS `modelName`,`mp`.`storage` AS `storage`,`mp`.`color` AS `color` , `m`.`modelPopularity`
    from `mobile_products` `mp`
    INNER JOIN ( select * from `mobile_models` where `modelName` = ".$model.") AS `m` on `mp`.`modelId` =  `m`.`modelId`
    INNER JOIN ( select `brandId`, `brandName` from `brand` where `brandName` = ".$brand.") AS `b` on `b`.`brandId` = `m`.`brandId`
    order by `m`.`modelName`,`m`.`modelPopularity` desc) `temp1`
    ON `ma`.`mobileId` = `temp1`.`mobileId`
    INNER JOIN `amazon_mobiles` `ama` on `ma`.`amazonMobileId` = `ama`.`productId`
    
    UNION
    
    SELECT  `ma`.`mobileId`, `amazonMobileId`, `flipkartMobileId`, `brandName`, `modelName`, `storage`, `color` , `modelPopularity` , `productId`, `productPrice`, `productLowestPrice`, `productName`,`productRating`,`productReviewCount`,`productUrl`,`productReviewUrl`,`productImageUrl`,`lowestPriceDate`
    FROM `mobiles_association`  `ma`
    INNER JOIN (select `mp`.`mobileId` AS `mobileId`,`b`.`brandName` AS `brandName`,`m`.`modelName` AS `modelName`,`mp`.`storage` AS `storage`,`mp`.`color` AS `color` , `m`.`modelPopularity`
    from `mobile_products` `mp`
    INNER JOIN ( select * from `mobile_models` where `modelName` = ".$model.") AS `m` on `mp`.`modelId` =  `m`.`modelId`
    INNER JOIN ( select `brandId`, `brandName` from `brand` where `brandName` = ".$brand.") AS `b` on `b`.`brandId` = `m`.`brandId`
    order by `m`.`modelName`,`m`.`modelPopularity` desc) AS `temp2`
    ON `ma`.`mobileId` = `temp2`.`mobileId`
    INNER JOIN `flipkart_mobiles` `fl` on `ma`.`flipkartMobileId` = `fl`.`productId`
    ) as `temp`";
}

if (($brand != "''")) {
    $sql = "SELECT  `temp`.`mobileId`, `amazonMobileId`, `flipkartMobileId`, `brandName`, `modelName`, `storage`, `color` , `modelPopularity` , `productId`, `productPrice`, `productLowestPrice`, `productName`,`productRating`,`productReviewCount`,`productUrl`,`productReviewUrl`,`productImageUrl`,`lowestPriceDate`
    from (
    SELECT `ma`.`mobileId`, `amazonMobileId`, `flipkartMobileId`, `brandName`, `modelName`, `storage`, `color` , `modelPopularity` , `productId`, `productPrice`, `productLowestPrice`, `productName`,`productRating`,`productReviewCount`,`productUrl`    ,`productReviewUrl`,`productImageUrl`,`lowestPriceDate`
    FROM `mobiles_association` `ma`
    INNER JOIN (select `mp`.`mobileId` AS `mobileId`,`b`.`brandName` AS `brandName`,`m`.`modelName` AS `modelName`,`mp`.`storage` AS `storage`,`mp`.`color` AS `color` , `m`.`modelPopularity`
    from `mobile_products` `mp`
    INNER JOIN ( select * from `mobile_models`) AS `m` on `mp`.`modelId` =  `m`.`modelId`
    INNER JOIN ( select `brandId`, `brandName` from `brand` where `brandName` = ".$brand.") AS `b` on `b`.`brandId` = `m`.`brandId`
    order by `m`.`modelName`,`m`.`modelPopularity` desc) `temp1`
    ON `ma`.`mobileId` = `temp1`.`mobileId`
    INNER JOIN `amazon_mobiles` `ama` on `ma`.`amazonMobileId` = `ama`.`productId`
    
    UNION
    
    SELECT  `ma`.`mobileId`, `amazonMobileId`, `flipkartMobileId`, `brandName`, `modelName`, `storage`, `color` , `modelPopularity` , `productId`, `productPrice`, `productLowestPrice`, `productName`,`productRating`,`productReviewCount`,`productUrl`,`productReviewUrl`,`productImageUrl`,`lowestPriceDate`
    FROM `mobiles_association`  `ma`
    INNER JOIN (select `mp`.`mobileId` AS `mobileId`,`b`.`brandName` AS `brandName`,`m`.`modelName` AS `modelName`,`mp`.`storage` AS `storage`,`mp`.`color` AS `color` , `m`.`modelPopularity`
    from `mobile_products` `mp`
    INNER JOIN ( select * from `mobile_models`) AS `m` on `mp`.`modelId` =  `m`.`modelId`
    INNER JOIN ( select `brandId`, `brandName` from `brand` where `brandName` = ".$brand.") AS `b` on `b`.`brandId` = `m`.`brandId`
    order by `m`.`modelName`,`m`.`modelPopularity` desc) AS `temp2`
    ON `ma`.`mobileId` = `temp2`.`mobileId`
    INNER JOIN `flipkart_mobiles` `fl` on `ma`.`flipkartMobileId` = `fl`.`productId`
    ) as `temp`";
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