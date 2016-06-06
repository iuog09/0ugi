<?php
  require("./config/config.php");
  require("./lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
?>
<?php
  session_start();
    $is_logged = $_SESSION['is_logged'];
    if($is_logged=='YES') {
        $user_email = $_SESSION['user_email'];
        $message = $user_email . ' 님, 환영합니다.';
    }
    else {
        $message = '로그인에 실패했습니다.';
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>공동학습</title>
    <link href="/bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
  </head>
  <body>
    <div class="whole-wrap">
      <div class="jumbotron">
        <header>
          <h2><a href="./index.php">공동학습</a></h2>
          <p id="sub-title">Collaborative Learning</p>
        </header>
      </div>

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">학습분류</a>
          </div>
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">학년별 학과수업
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="./index.php?grade=1">1학년</a></li>
                  <li><a href="./index.php?grade=2">2학년</a></li>
                  <li><a href="./index.php?grade=3">3학년</a></li>
                  <li><a href="./index.php?grade=4">4학년</a></li>
                </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">언어
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="./index.php?lang=1">C</a></li>
                  <li><a href="./index.php?lang=2">C++</a></li>
                  <li><a href="./index.php?lang=3">JAVA</a></li>
                  <li><a href="./index.php?lang=4">Python</a></li>
                </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">정보처리기사
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="./index.php?gisa=1">정보처리기사 필기</a></li>
                  <li><a href="./index.php?gisa=2">정보처리기사 실기</a></li>
                </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">토익
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="./index.php?toeic=1">RC</a></li>
                  <li><a href="./index.php?toeic=2">LC</a></li>
                </ul>
            </li>
            <li><a href="./index.php?etc=1">기타학습</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php
              if($is_logged=='YES') {
                  echo '<li><a href="#">'.$message.'</a></li>';
                  echo '<li><a href="'.'./logout.php"><span class="glyphicon glyphicon-log-in"></span> 로그아웃</a></li>';
              }
              else {
                 echo '<li><a href="'.'./signin.php"><span class="glyphicon glyphicon-user"></span> 회원가입</a></li>';
                 echo '<li><a href="'.'./login.php"><span class="glyphicon glyphicon-log-in"></span> 로그인</a></li>';
              }
            ?>
          </ul>
        </div>
      </nav>
      <div class="contents-wrap" align="center" style="margin-top:200px">
        <?php
          echo "'<h1>$message</h1>'";
        ?>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
  </body>
</html>
