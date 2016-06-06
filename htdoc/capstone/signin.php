<?php
  require("./config/config.php");
  require("./lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
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
    <link rel="stylesheet" href="./css/signin.css" type="text/css">
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
            <li><a href="./signin.php"><span class="glyphicon glyphicon-user"></span> 회원가입</a></li>
            <li><a href="./login.php"><span class="glyphicon glyphicon-log-in"></span> 로그인</a></li>
          </ul>
        </div>
      </nav>

      <div class="contents-wrap">

        <article id="center-article" class="col-sm-12">


            <div class="container">

              <form class="form-signin" method="post" action="./signinprocess.php">
                <h2 class="form-signin-heading">회원가입</h2>
                <label for="inputName" class="sr-only">Name</label>
                <input type="name" id="inputName" class="form-control" name="user_name" placeholder="이름을 입력하세요" required="" autofocus="">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" name="user_email" placeholder="이메일 주소를 입력하세요" required="" autofocus="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" name="user_pw" placeholder="암호를 입력하세요" required="">
                <label for="inputPassword2" class="sr-only">Password2</label>
                <input type="password" id="inputPassword" class="form-control" name="user_pw2" placeholder="암호를 한번 더 입력하세요" required="">
                <button class="btn btn-lg btn-primary btn-block" type="submit">회원가입</button>
              </form>

            </div> <!-- /container -->


            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->



        </article>

      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
  </body>
</html>
