<?php
  require("./config/config.php");
  require("./lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

  extract($_POST);

  session_start();

  $sql="SELECT * FROM user WHERE email='$user_email'";
  $result = mysqli_query($conn, $sql);

  if($result->num_rows==1) {
    //해당 ID 의 회원이 존재할 경우
    // 암호가 맞는지를 확인

    $encryped_pw = sha1($user_pw);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if( $row['password'] == $encryped_pw ) {
        // 올바른 정보
        $_SESSION['is_logged'] = 'YES';
        $_SESSION['user_email'] = $user_email;
        header("Location: ./logincomplete.php");
        exit();
    }
    else {
        // 암호가 틀렸음
        $_SESSION['is_logged'] = 'NO';
        $_SESSION['user_email'] = '';
        header("Location: ./logincomplete.php");
    }

}
else {
    // 없거나, 비정상

}
?>
