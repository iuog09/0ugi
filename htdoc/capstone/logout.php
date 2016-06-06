<?php
  require("./config/config.php");
  require("./lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
?>
<?php
  session_start();
  $_SESSION['is_logged'] = 'NO';
  $_SESSION['user_email'] = '';

  session_unset($_SESSION['user_email']);

  header('Location: ./index.php');
 ?>
