<?php
	if($_SERVER['HTTP_HOST'] == 'www.way.co.kr' || $_SERVER['HTTP_HOST'] == 'way.co.kr' ) {
		echo "<script>alert('�� ����Ʈ�� WAY.CO.KR ����Ʈ�� ���� ���� ����Ʈ �Դϴ�.\\n\\n���� WAY.CO.KR ����Ʈ �����ڶ�� DNS�� �ٽ� �ѹ� üũ �ٶ��ϴ�.');
		history.go(-1);</script>
		";
	} else if(in_array($_SERVER['HTTP_HOST'], array("www.kormi.or.kr", "kormi.or.kr")))
		header('Location: http://www.kormi.org') ;

//	header('Location: main/main.php') 

?>
<html>
<head>
<title>::�ѱ��� �޼��ɱٰ������ ��Ȳ�� ���� ��Ͽ���::</title>
<script language="javascript">
/*
if(document.location.host == "kamir3.kamir.or.kr") {
	alert("2008�� 2�� 1�Ϻ��� ���ο�ȯ�ڴ� kormi.org���� �Է��Ͽ��ֽʽÿ�");
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
    <p>�� �������� ������, �������� �� �� �ִ� �������� �ʿ��մϴ�.</p>
</body>
</noframes>
</frameset>
</html>