<?php
  require("./config/config.php");
  require("./lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
?>
    <?php
      extract($_POST);

    if($user_pw == $user_pw2){
      $encrypted_pw = sha1($user_pw);
      $sql = "INSERT INTO user ( name, email, password ) VALUES ( '$user_name', '$user_email', '$encrypted_pw' )";
      $result = mysqli_query($conn,$sql);
      header("Location:./signincomplete.php");
    }else{
      echo "<script>alert(\"입력된 비밀번호가 서로 다릅니다.\");history.go(-1);</script>";

    }

    ?>
