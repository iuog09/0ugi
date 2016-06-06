<?php
if (!$_SESSION['admin']) exit('올바르지 않은 접근입니다.');

// hospital data
$hosp = array();
$rs = $DB->Execute('SELECT * FROM hospital');
while (!$rs->EOF) {
	$hosp[$rs->fields['hs_code']] = $rs->fields['hs_name'];
	$rs->MoveNext();
}

$p = $_GET['p']?intval($_GET['p']):1; $psize = 15; $offset = ($p-1)*$psize;
$total = $DB->GetOne('SELECT count(*) FROM doctor WHERE doc_parent=0');
$list = $DB->GetAll('SELECT * FROM doctor WHERE doc_parent=0 ORDER BY doc_uid DESC LIMIT '.$offset.','.$psize);
?>
<h3>연구원목록</h3>
<script language="javascript" type="text/javascript" src="/kamir/paging.js"></script>
<table border="0" width="98%" cellpadding="0" cellspacing="1" class="tbl_list" style="margin-bottom:20px;">
<tr>
	<th width="50">번호</th>
	<th>이름</th>
	<th>소속</th>
	<th width="120">아이디</th>
	<th width="150">연락처</th>
	<th width="150">핸드폰</th>
	<th width="50">수정</th>
	<th width="50">삭제</th>
	<th width="80">보조연구원</th>
</tr>
<? foreach ($list as $k=>$l){ ?>
<tr height="25" align="center">
	<td><?=$total-$offset-$k?></td>
	<td><?=$l['doc_name']?></td>
	<td><?=$hosp[$l['hs_code']]?></td>
	<td><?=$l['doc_id']?></td>
	<td><?=$l['doc_tel']?$l['doc_tel']:'-'?></td>
	<td><?=$l['doc_mobile']?$l['doc_tel']:'-'?></td>
	<td><a href="member.php?q=reg&u=<?=$l['doc_uid']?>">수정</a></td>
	<td><a href="#click" onclick="delIt(<?=$l['doc_uid']?>)">삭제</a></td>
	<td><a href="">보조 등록</a></td>
</tr>
<tr><td colspan="9" class="line"></td></tr>
<? } if (!count($list)) { ?>
<tr height="50">
	<td align="center" colspan="9">등록된 연구원이 없습니다.</td>
</tr>
<tr><td colspan="9" class="line"></td></tr>
<? } ?>
<tr height="50">
	<td>&nbsp;</td>
	<td colspan="7" align="center"><script type="text/javascript">document.write(paging(<?=$total?>,<?=$psize?>))</script></td>
	<td align="right" colspan="2">
		<a href="member.php?q=reg">연구원등록</a>
	</td>
</tr>
</table>

<script language="javascript" type="text/javascript">
function delIt(uid)
{
	if (!confirm("삭제하시겠습니까?")) return false;
	document.frames["action_iframe"].document.location.href = "action.php?action=member_del&u="+uid+"&p=<?=$k>0?$p:$p==1?1:$p-1?>";
}
</script>