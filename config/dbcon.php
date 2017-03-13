<?php
header('X-Frame-Options: DENY');
$mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
}
?>

