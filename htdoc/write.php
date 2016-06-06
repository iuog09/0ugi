<?php
  require("config/config.php");
  require("lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
  $result = mysqli_query($conn,"SELECT * FROM topic");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <link rel="stylesheet" type="text/css" href="/style.css">
  <link href="/bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="target">
  <div class = "container">
    <header class="jumbotron text-center">
    <img id = "logo" class="img-circle" src="https://s3-ap-northeast-1.amazonaws.com/opentutorialsfile/course/94.png" alt="생활코딩">
        <h1><a href="/index.php">JavaScript</a></h1>
  </header>
    <div class="row">
      <nav class="col-md-3">
          <ol class="nav nav-pills nav-stacked">
            <?php
              while( $row = mysqli_fetch_assoc($result)){
                echo '<li><a href = "/index.php?id='.$row['id'].'">'.htmlspecialchars($row['title']).'</li></a>'."\n";
              }
            ?>
          </ol>
      </nav>
    <div class="col-md-9">

      <article>
        <form action="process.php" method="post">

          <div class="form-group">
            <label for="form-title">제  목</label>
            <input type="text" class="form-control" name="title" id="form-title" placeholder="제목을 적어주세요.">
          </div>

          <div class="form-group">
            <label for="form-author">작성자</label>
            <input type="text" class="form-control" name="author" id="form-author" placeholder="작성자를 적어주세요.">
          </div>

          <div class="form-group">
            <label for="form-author">본  문</label>
            <textarea name="description" rows="10" class="form-control" id="form-author" placeholder="본문을 적어주세요."></textarea>
          </div>

          <input class="btn btn-default btn-lg" type="submit" name="name">
        </form>
      </article>
      <hr>
      <div id="control">
        <div class="btn-group" role="group" aria-label="...">
          <input class="btn btn-default btn-lg" type="button" value="white" onclick="document.getElementById('target').className='white'"/>
          <input class="btn btn-default btn-lg" type="button" value="black" onclick="document.getElementById('target').className='black'" />
        </div>
        <a href="/write.php" class="btn btn-default btn-success btn-lg" >쓰기</a>
      </div>

    </div>

  </div>
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
</body>
</html>
