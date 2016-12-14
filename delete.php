<?php
if (isset($_GET['id'])) {
    $id=$_GET['id'];
    include ("dbconnect.php");
    mysqli_query($connection, "DELETE FROM `tst_gbook` WHERE `id` = " . $id);
    $connection->close();  
}
header("location: /tst/index.php");
?>
