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


if (isset($id))
{
 if (isset($siteName) &&  $siteName == "Amazon")
 {
 $str= "";
 if (isset($price))
 {
   if ($str == "")
   {
    $str = " `amazonMobilePrice` = ? ,";
   }
   else
   {
    $str = $str." `amazonMobilePrice` = ? ,";
   }
 }

 if (isset($name))
 {
   if ($str == "")
   {
    $str = " `amazonMobileName` = '".$name."' , ";
   }
   else
   {
    $str = $str." `amazonMobileName` = '".$name."' , ";
   }
 }

 if (isset($rating))
 {
   if ($str == "")
   {
    $str = " `amazonMobileRating` = '".$rating."' , ";
   }
   else
   {
    $str = $str." `amazonMobileRating` = '".$rating."' , ";
   }
 }

 if (isset($reviewCount))
 {
   if ($str == "")
   {
    $str = " `amazonMobileReviewCount` = '".$reviewCount."' , ";
   }
   else
   {
    $str = $str." `amazonMobileReviewCount` = '".$reviewCount."' , ";
   }
 }

 if (isset($url))
 {
   if ($str == "")
   {
    $str = " `amazonMobileUrl` = '".$url."' , ";
   }
   else
   {
    $str = $str." `amazonMobileUrl` = '".$url."' , ";
   }
 }

 if (isset($reviewUrl))
 {
   if ($str == "")
   {
    $str = " `amazonMobileReviewUrl` = '".$reviewUrl."' , ";
   }
   else
   {
    $str = $str." `amazonMobileReviewUrl` = '".$reviewUrl."' , ";
   }
 }

 if (isset($imageUrl))
 {
   if ($str == "")
   {
    $str = " `amazonMobileImageUrl` = '".$imageUrl."'";
   }
   else
   {
    $str = $str." `amazonMobileImageUrl` = '".$imageUrl."'";
   }
 }

 if ($str != "")
 {
$str = rtrim($str,', ');
  $sqlStmt = "UPDATE `amazon-mobiles` SET ".$str." WHERE `amazonMobileId` = '".$id."'";

  if ($stmt = $mysqli->prepare($sqlStmt)) 
    {

    /* bind parameters for markers */
    if (isset($price)) 
    {
    $stmt->bind_param('i', $price);
    }   

    /* execute query */
    $stmt->execute();

    /* close statement */
    $stmt->close();
    } 
 }
 
 }


 else if (isset($siteName) && $siteName == "Flipkart")
 {
 $str= "";

 if (isset($price))
 {
   if ($str == "")
   {
    $str = " `flipkartMobilePrice` = ? ,";
   }
   else
   {
    $str = $str." `flipkartMobilePrice` = ? ,";
   }
 }

 if (isset($name))
 {
   if ($str == "")
   {
    $str = " `flipkartMobileName` = '".$name."' , ";
   }
   else
   {
    $str = $str." `flipkartMobileName` = '".$name."' , ";
   }
 }

 if (isset($rating))
 {
   if ($str == "")
   {
    $str = " `flipkartMobileRating` = '".$rating."' , ";
   }
   else
   {
    $str = $str." `flipkartMobileRating` = '".$rating."' , ";
   }
 }

 if (isset($reviewCount))
 {
   if ($str == "")
   {
    $str = " `flipkartMobileReviewCount` = '".$reviewCount."' , ";
   }
   else
   {
    $str = $str." `flipkartMobileReviewCount` = '".$reviewCount."' , ";
   }
 }

 if (isset($url))
 {
   if ($str == "")
   {
    $str = " `flipkartMobileUrl` = '".$url."' , ";
   }
   else
   {
    $str = $str." `flipkartMobileUrl` = '".$url."' , ";
   }
 }

 if (isset($reviewUrl))
 {
   if ($str == "")
   {
    $str = " `flipkartMobileReviewUrl` = '".$reviewUrl."' , ";
   }
   else
   {
    $str = $str." `flipkartMobileReviewUrl` = '".$reviewUrl."' , ";
   }
 }

 if (isset($imageUrl))
 {
   if ($str == "")
   {
    $str = " `flipkartMobileImageUrl` = '".$imageUrl."' , ";
   }
   else
   {
    $str = $str." `flipkartMobileImageUrl` = '".$imageUrl."' , ";
   }
 }

 if ($str != "")
 {
$str = rtrim($str,', ');
  $sqlStmt = "UPDATE `flipkart-mobiles` SET ".$str." WHERE `flipkartMobileId` = '".$id."'";
   if ($stmt = $mysqli->prepare($sqlStmt)) 
   {

    /* bind parameters for markers */
    if (isset($price)) 
    {
    $stmt->bind_param('i', $price);
    }

    /* execute query */
    $stmt->execute();

    /* close statement */
    $stmt->close();
   } 
 }
 }
}

/* close connection */
$mysqli->close(); 
?>	