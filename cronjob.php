<!doctype html>
<?php include_once("database/phpmyadmin/connection.php"); ?>
<html lang="en">

<head>
  <?php
  $query = "SELECT * FROM `payment`";
  $result = mysqli_query($conn, $query);

  while ($rows = mysqli_fetch_assoc($result)) {
    $id = $rows['id'];
    $name = $rows['name'];
    $email = $rows['email'];
    echo $days = $rows['days'];
  }
  $query_delete = "DELETE FROM `payment` WHERE `days` = '0'";
  $result_delete = mysqli_query($conn, $query_delete);
  $days_less = $days - 1;
  $quesry_less = "UPDATE `payment` SET `days`='$days_less'";
  $result_less = mysqli_query($conn, $quesry_less);
  ?>