<?php
	if($_SERVER['HTTP_HOST'] == 'www.way.co.kr' || $_SERVER['HTTP_HOST'] == 'way.co.kr' ) {
		echo "<script>alert('본 사이트는 WAY.CO.KR 사이트와 관련 없는 사이트 입니다.\\n\\n만약 WAY.CO.KR 사이트 관리자라면 DNS를 다시 한번 체크 바랍니다.');
		history.go(-1);</script>
		";
	} else if(in_array($_SERVER['HTTP_HOST'], array("www.kormi.or.kr", "kormi.or.kr")))
		header('Location: http://www.kormi.org') ;

//	header('Location: main/main.php') 

?>
<html>
<head>
<title>::한국인 급성심근경색증의 현황에 대한 등록연구::</title>
<script language="javascript">
/*
if(document.location.host == "kamir3.kamir.or.kr") {
	alert("2008년 2월 1일부터 새로운환자는 kormi.org에서 입력하여주십시오");
	document.location.href = "http://kormi.org";
}
*/
function getCookie( name ){
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 ) break;
	}
	return "";
}
<?php include 'popup.php'; ?>
</script>
</head>
<frameset rows="100%, 0" cols="*" border="0" style="color:silver;" frameborder="0">
    <frame src="main/main.php" name="main" scrolling="auto" marginwidth="10" marginheight="0">
    <frame src="_index.html" name="blank" scrolling="no" marginwidth="0" marginheight="0">
    <noframes>
    <body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
    <p>이 페이지를 보려면, 프레임을 볼 수 있는 브라우저가 필요합니다.</p>
</body>
</noframes>
</frameset>
</html>