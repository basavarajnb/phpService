<?php
    require("config/configuration.php");

$link = mysql_connect(SERVER, USER, PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
} 
if (!mysql_select_db(DATABASE)) {
    die('Could not select database: ' . mysql_error());
}
print "Connection Success";
$result = mysql_query('SELECT * FROM `flipkart_mobiles`');
if (!$result) {
    die('Could not query:' . mysql_error());
}

?>
<table border="2">
  <tbody>
<?php
while( $row = mysql_fetch_assoc( $result) ){
          echo "<tr><td>{$row['flipkartMobileId']}</td><td>{$row['flipkartMobilePrice']}</td></tr>\n";
        }
?>
  </tbody>
</table>
<?php
echo mysql_query($result, 0); // outputs third employee's name
print "query executed";
mysql_close($link);

?>

<?php
$con=mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM `flipkart_mobiles`");

echo "<table border='1'>
<tr>
<th>ID</th>
<th>Price</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['flipkartMobileId'] . "</td>";
echo "<td>" . $row['flipkartMobilePrice'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>




