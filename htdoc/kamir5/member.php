<?php include 'header.php' ?>
<?php
if (is_null($q)) $q = 'list';
?>
<div id="submenu_box" style="">
	<a href="member.php?q=list">연구원목록</a>
	<a href="member.php?q=reg">연구원등록</a>
	<a href="member.php?q=mail">메일발송</a>
	<a href="member.php?q=sms">SMS발송</a>
	<a href="member.php?q=hosp">병원관리</a>
</div>
<div id="content_box">
	<?php include 'member_'.$q.'.php' ?>
</div>
<?php include 'footer.php'?>
