<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>공동학습</title>
    <link href="/bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/signin.css" rel="stylesheet">
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
                  <li><a href="#">1학년</a></li>
                  <li><a href="#">2학년</a></li>
                  <li><a href="#">3학년</a></li>
                  <li><a href="#">4학년</a></li>
                </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">언어
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">C</a></li>
                  <li><a href="#">C++</a></li>
                  <li><a href="#">JAVA</a></li>
                  <li><a href="#">Python</a></li>
                </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">정보처리기사
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">정보처리기사 필기</a></li>
                  <li><a href="#">정보처리기사 실기</a></li>
                </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">토익
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">RC</a></li>
                  <li><a href="#">LC</a></li>
                </ul>
            </li>
            <li><a href="#">기타학습</a></li>
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

      <div class="contents-wrap">

        <article id="center-article" class="col-sm-12">


            <div class="container">

              <form class="form-signin" name="login-form" method="post" action="./loginprocess.php">
                <h2 class="form-signin-heading">로그인</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" name="user_email" placeholder="이메일 주소를 입력하세요" required="" autofocus="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" name="user_pw" placeholder="암호를 입력하세요" required="">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="remember-me"> 로그인 상태 유지
                  </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">로그인</button>
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
