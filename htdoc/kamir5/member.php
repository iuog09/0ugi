<?php include 'header.php' ?>
<?php
if (is_null($q)) $q = 'list';
?>
<div id="submenu_box" style="">
	<a href="member.php?q=list">���������</a>
	<a href="member.php?q=reg">���������</a>
	<a href="member.php?q=mail">���Ϲ߼�</a>
	<a href="member.php?q=sms">SMS�߼�</a>
	<a href="member.php?q=hosp">��������</a>
</div>
<div id="content_box">
	<?php include 'member_'.$q.'.php' ?>
</div>
<?php include 'footer.php'?>
