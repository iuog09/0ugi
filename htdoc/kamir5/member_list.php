<?php
if (!$_SESSION['admin']) exit('�ùٸ��� ���� �����Դϴ�.');

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
<h3>���������</h3>
<script language="javascript" type="text/javascript" src="/kamir/paging.js"></script>
<table border="0" width="98%" cellpadding="0" cellspacing="1" class="tbl_list" style="margin-bottom:20px;">
<tr>
	<th width="50">��ȣ</th>
	<th>�̸�</th>
	<th>�Ҽ�</th>
	<th width="120">���̵�</th>
	<th width="150">����ó</th>
	<th width="150">�ڵ���</th>
	<th width="50">����</th>
	<th width="50">����</th>
	<th width="80">����������</th>
</tr>
<? foreach ($list as $k=>$l){ ?>
<tr height="25" align="center">
	<td><?=$total-$offset-$k?></td>
	<td><?=$l['doc_name']?></td>
	<td><?=$hosp[$l['hs_code']]?></td>
	<td><?=$l['doc_id']?></td>
	<td><?=$l['doc_tel']?$l['doc_tel']:'-'?></td>
	<td><?=$l['doc_mobile']?$l['doc_tel']:'-'?></td>
	<td><a href="member.php?q=reg&u=<?=$l['doc_uid']?>">����</a></td>
	<td><a href="#click" onclick="delIt(<?=$l['doc_uid']?>)">����</a></td>
	<td><a href="">���� ���</a></td>
</tr>
<tr><td colspan="9" class="line"></td></tr>
<? } if (!count($list)) { ?>
<tr height="50">
	<td align="center" colspan="9">��ϵ� �������� �����ϴ�.</td>
</tr>
<tr><td colspan="9" class="line"></td></tr>
<? } ?>
<tr height="50">
	<td>&nbsp;</td>
	<td colspan="7" align="center"><script type="text/javascript">document.write(paging(<?=$total?>,<?=$psize?>))</script></td>
	<td align="right" colspan="2">
		<a href="member.php?q=reg">���������</a>
	</td>
</tr>
</table>

<script language="javascript" type="text/javascript">
function delIt(uid)
{
	if (!confirm("�����Ͻðڽ��ϱ�?")) return false;
	document.frames["action_iframe"].document.location.href = "action.php?action=member_del&u="+uid+"&p=<?=$k>0?$p:$p==1?1:$p-1?>";
}
</script>