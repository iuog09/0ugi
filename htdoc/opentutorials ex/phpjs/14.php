<?php
  $conn = mysqli_connect("localhost","root",111111);
  mysqli_select_db($conn,"opentutorials");
  $name = mysqli_real_escape_string($conn,$_GET['name']);
  $password = mysqli_real_escape_string($conn,$_GET['password']);
  $sql = "SELECT * FROM user WhERE name='".$name."' AND password='".$password."'";
  echo $sql;
  $result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    if($result->num_rows =="0"){
      echo "뉘신지?";
    } else {
      echo "안녕하세요 주인님";
    }
     ?>
  </body>
</html>
