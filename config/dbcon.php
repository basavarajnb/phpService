<?php
header('X-Frame-Options: DENY');
$mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>

