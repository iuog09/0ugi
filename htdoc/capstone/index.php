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

      <div class="contents-wrap">
        <nav id="left-nav" class="col-sm-2">
          <ol class="nav nav-pills nav-stacked">
            <?php
              if(empty($_GET['grade']) === FALSE){
                echo '<h3 align="center">'."학습목록".'</h3><hr>';
                $sql = "SELECT gradetable.id,gradetable.title,gradetable.grade FROM gradetable WHERE gradetable.grade=".$_GET['grade'];
                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result)){
                  echo '<li><a href="./index.php?id='.$row['id'].'&grade='.$row['grade'].'">'.htmlspecialchars($row['title']).'</a></li>';}
                }elseif(empty($_GET['lang']) === FALSE){
                  echo '<h3 align="center">'."학습목록".'</h3><hr>';
                  $sql = "SELECT langtable.id,langtable.title,langtable.lang FROM langtable WHERE langtable.lang=".$_GET['lang'];
                  $result = mysqli_query($conn, $sql);
                  while($row=mysqli_fetch_assoc($result)){
                    echo '<li><a href="./index.php?id='.$row['id'].'&lang='.$row['lang'].'">'.htmlspecialchars($row['title']).'</a></li>';}
                  }elseif(empty($_GET['gisa']) === FALSE){
                    echo '<h3 align="center">'."학습목록".'</h3><hr>';
                    $sql = "SELECT gisatable.id,gisatable.title,gisatable.gisa FROM gisatable WHERE gisatable.gisa=".$_GET['gisa'];
                    $result = mysqli_query($conn, $sql);
                    while($row=mysqli_fetch_assoc($result)){
                      echo '<li><a href="./index.php?id='.$row['id'].'&gisa='.$row['gisa'].'">'.htmlspecialchars($row['title']).'</a></li>';}
                    }elseif(empty($_GET['toeic']) === FALSE){
                      echo '<h3 align="center">'."학습목록".'</h3><hr>';
                      $sql = "SELECT toeictable.id,toeictable.title,toeictable.toeic FROM toeictable WHERE toeictable.toeic=".$_GET['toeic'];
                      $result = mysqli_query($conn, $sql);
                      while($row=mysqli_fetch_assoc($result)){
                        echo '<li><a href="./index.php?id='.$row['id'].'&toeic='.$row['toeic'].'">'.htmlspecialchars($row['title']).'</a></li>';}
                      }elseif(empty($_GET['etc']) === FALSE){
                        echo '<h3 align="center">'."학습목록".'</h3><hr>';
                        $sql = "SELECT etctable.id,etctable.title,etctable.etc FROM etctable WHERE etctable.etc=".$_GET['etc'];
                        $result = mysqli_query($conn, $sql);
                        while($row=mysqli_fetch_assoc($result)){
                          echo '<li><a href="./index.php?id='.$row['id'].'&etc='.$row['etc'].'">'.htmlspecialchars($row['title']).'</a></li>';}
                      }
            ?>
          </ol>
        </nav>
        <article id="center-article" class="col-sm-6">
          <?php
            if(empty($_GET['id']&$_GET['grade']) === FALSE){
              $sql = "SELECT gradetable.id,title,vodurl,author,created,name,description FROM gradetable LEFT JOIN user ON gradetable.author = user.id WHERE gradetable.id=".$_GET['id'];
              $result = mysqli_query($conn, $sql);
              $row = mysqli_fetch_assoc($result);
              echo '<h2>'.htmlspecialchars($row['title']).'</h2>';
              echo '<p>'.htmlspecialchars($row['created']).'&nbsp;&nbsp;|&nbsp;&nbsp;'.htmlspecialchars($row['name']).'</p>';
              echo '<iframe  id="vod" width = "80%"  height = "70%"  src = "'.$row['vodurl'].'"  frameborder = "0"  allowfullscreen ></iframe>';
              echo '<p>'.strip_tags($row['description'], '<a><h1><h2><h3><h4><h5><ul><ol><li>').'</p>';
                  }elseif(empty($_GET['id']&$_GET['lang']) === FALSE){
                          $sql = "SELECT langtable.id,title,vodurl,author,created,name,description FROM langtable LEFT JOIN user ON langtable.author = user.id WHERE langtable.id=".$_GET['id'];
                          $result = mysqli_query($conn, $sql);
                          $row = mysqli_fetch_assoc($result);
                          echo '<h2>'.htmlspecialchars($row['title']).'</h2>';
                          echo '<p>'.htmlspecialchars($row['created']).'&nbsp;&nbsp;|&nbsp;&nbsp;'.htmlspecialchars($row['name']).'</p>';
                          echo '<iframe  id="vod" width = "80%"  height = "70%"  src = "'.$row['vodurl'].'"  frameborder = "0"  allowfullscreen ></iframe>';
                          echo '<p>'.strip_tags($row['description'], '<a><h1><h2><h3><h4><h5><ul><ol><li>').'</p>';
                        }elseif(empty($_GET['id']&$_GET['gisa']) === FALSE){
                                  $sql = "SELECT gisatable.id,title,vodurl,author,created,name,description FROM gisatable LEFT JOIN user ON gisatable.author = user.id WHERE gisatable.id=".$_GET['id'];
                                  $result = mysqli_query($conn, $sql);
                                  $row = mysqli_fetch_assoc($result);
                                  echo '<h2>'.htmlspecialchars($row['title']).'</h2>';
                                  echo '<p>'.htmlspecialchars($row['created']).'&nbsp;&nbsp;|&nbsp;&nbsp;'.htmlspecialchars($row['name']).'</p>';
                                  echo '<iframe  id="vod" width = "80%"  height = "70%"  src = "'.$row['vodurl'].'"  frameborder = "0"  allowfullscreen ></iframe>';
                                  echo '<p>'.strip_tags($row['description'], '<a><h1><h2><h3><h4><h5><ul><ol><li>').'</p>';
                                }elseif(empty($_GET['id']&$_GET['toeic']) === FALSE){
                                            $sql = "SELECT toeictable.id,title,vodurl,author,created,name,description FROM toeictable LEFT JOIN user ON toeictable.author = user.id WHERE toeictable.id=".$_GET['id'];
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            echo '<h2>'.htmlspecialchars($row['title']).'</h2>';
                                            echo '<p>'.htmlspecialchars($row['created']).'&nbsp;&nbsp;|&nbsp;&nbsp;'.htmlspecialchars($row['name']).'</p>';
                                            echo '<iframe  id="vod" width = "80%"  height = "70%"  src = "'.$row['vodurl'].'"  frameborder = "0"  allowfullscreen ></iframe>';
                                            echo '<p>'.strip_tags($row['description'], '<a><h1><h2><h3><h4><h5><ul><ol><li>').'</p>';
                                          }elseif(empty($_GET['id']&$_GET['etc']) === FALSE){
                                                        $sql = "SELECT etctable.id,title,vodurl,author,created,name,description FROM etctable LEFT JOIN user ON etctable.author = user.id WHERE etctable.id=".$_GET['id'];
                                                        $result = mysqli_query($conn, $sql);
                                                        $row = mysqli_fetch_assoc($result);
                                                        echo '<h2>'.htmlspecialchars($row['title']).'</h2>';
                                                        echo '<p>'.htmlspecialchars($row['created']).'&nbsp;&nbsp;|&nbsp;&nbsp;'.htmlspecialchars($row['name']).'</p>';
                                                        echo '<iframe  id="vod" width = "80%"  height = "70%"  src = "'.$row['vodurl'].'"  frameborder = "0"  allowfullscreen ></iframe>';
                                                        echo '<p>'.strip_tags($row['description'], '<a><h1><h2><h3><h4><h5><ul><ol><li>').'</p>';
                                                        }else{
                                                  echo file_get_contents("./title/title.txt");
                                                }
          ?>
        </article>
        <aside id="right-aside" class="col-sm-4">
          커뮤니티공간
        </aside>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
  </body>
</html>
