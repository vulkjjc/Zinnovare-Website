<?php
include("connection/connect.php"); //connection to db
error_reporting(0);
session_start();


// sending query
mysqli_query($db,"update users_orders set status='rejected' where o_id='".$_GET['order_del']."'");
// deletig records on the bases of ID
header("location:order_history.php");  //once deleted success redireted back to current page

?>
