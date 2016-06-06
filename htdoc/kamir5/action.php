<?php
if(($_POST['action']?$_POST['action']:$_GET['action']) == 'excel')
	set_time_limit(0);

ob_start();
include $_SERVER['DOCUMENT_ROOT'].'/include/header.php';

$action = $_POST['action']?$_POST['action']:$_GET['action'];

switch($action)
{
	//{{{로그인관련
	case 'login':
		if (!$_POST['id']) alert('사용자 아이디를 입력하세요.', true, 'parent.document.forms["f"].elements["id"].focus();');
		if (!$_POST['pwd']) alert('패스워드를 입력하세요.', true, 'parent.document.forms["f"].elements["pwd"].focus();');

		$_POST['pwd'] = md5($_POST['pwd']);

		// check admin
		$INI->Load('config.ini.php');
		if ($INI->getData('admin','id')===$_POST['id'] && $INI->getData('admin','passwd')===$_POST['pwd']) {
			$_SESSION['admin'] = 99;
		} else if ($INI->getData('admin1','id')===$_POST['id'] && $INI->getData('admin1','passwd')===$_POST['pwd']) {
			$_SESSION['admin'] = 1;
		} else {
			$data = $DB->GetRow('SELECT * FROM doctor WHERE doc_id=\''.$_POST['id'].'\' AND doc_active=1');
			if (!$data) alert('존재하지 않는 아이디입니다.22', true, 'parent.document.forms["f"].elements["id"].focus();');
			if ($data['doc_pwd'] != $_POST['pwd']) alert('패스워드가 올바르지 않습니다.', true);
		}

		$_SESSION['uid'] = $data['doc_uid'];
		$_SESSION['userid'] = $data['doc_id'];
		$_SESSION['name'] = $data['doc_name'];
		$_SESSION['parent'] = $data['doc_parent']?$data['doc_parent']:$data['doc_uid'];
		$_SESSION['hash'] = md5($_SESSION['uid'].$_SESSION['name'].'__'.$_SESSION['admin']);

		if ($_SESSION['admin']) {
			move('admin/index.php','parent');
		} else {
			move('member/index.php','parent');
		}
		break;
	//}}}
	//{{{배너관리
	case 'banner_add':
	case 'banner_edit':
		if (!$_SESSION['admin']) alert('권한이 없습니다!', true);
		if (!$_POST['title']) alert('배너 제목을 입력하세요.', true);
		if (!$_POST['url']) alert('배너 링크를 입력하세요.', true);
		if (!$_FILES['img']) alert('이미지를 업로드하세요.', true);
		if ($action=='banner_add'&&!is_uploaded_file($_FILES['img']['tmp_name'])) alert('파일이 업로드되지 않았습니다.', true);
		if ($_FILES['img']['tmp_name']&&!preg_match('/\.(png|gif|jpg)$/i',$_FILES['img']['name'])) alert('이미지 파일만 가능합니다.', true);

		if ($action == 'banner_add') {
			$order = intval($DB->GetOne('SELECT MAX(ba_order) FROM banner'))+1;
			$img_no = intval($DB->GetOne('SELECT MAX(ba_uid) FROM banner'))+1;
			$sql = 'INSERT INTO banner (ba_title,ba_url,ba_order) VALUES (\''.$_POST['title'].'\', \''.$_POST['url'].'\', \''.$order.'\')';
		} elseif($action == 'banner_edit') {
			$img_no = $_POST['uid'];
			$sql = 'UPDATE banner SET ba_title=\''.$_POST['title'].'\', ba_url=\''.$_POST['url'].'\' WHERE ba_uid='.$_POST['uid'];
			if ($_FILES['img']['tmp_name']) unlink('data/banner/'.$img_no.'.gif');
		}

		$DB->Execute($sql);
		if ($_FILES['img']['tmp_name']) move_uploaded_file($_FILES['img']['tmp_name'], 'data/banner/'.$img_no.'.gif');
		move('admin/banner.php?q=list','parent');
		break;
	case 'banner_delete':
		if (!$_SESSION['admin']) alert('권한이 없습니다!', true);
		$DB->Execute('DELETE FROM banner WHERE ba_uid='.$_GET['uid']);
		move('admin/banner.php?q=list','parent');
		break;
	case 'banner_order':
		$from_order = $DB->GetOne('SELECT ba_order FROM banner WHERE ba_uid='.$_GET['from']);
		$to_order = $DB->GetOne('SELECT ba_order FROM banner WHERE ba_uid='.$_GET['to']);
		$DB->Execute('UPDATE banner SET ba_order='.$from_order.' WHERE ba_uid='.$_GET['to']);
		$DB->Execute('UPDATE banner SET ba_order='.$to_order.' WHERE ba_uid='.$_GET['from']);
		move('admin/banner.php?q=list','parent');
		break;
	//}}}
	//{{{팝업관리
	case 'popup_add':
	case 'popup_edit':
		if (!$_SESSION['admin']) alert('권한이 없습니다!', true);
		if (!$_POST['title']) alert('배너 제목을 입력하세요.', true);
		if (!$_POST['skin']) alert('스킨을 선택하세요.', true);
		if (!$_POST['content']) alert('내용을 입력하세요.', true);
		if (!$_POST['expire']) alert('만료일자를 입력하세요.', true);
		if (!preg_match('/\d{6}/',$_POST['expire'])) alert('만료일자는 숫자 6자리로 입력하세요.', true);

		$_POST['top']    = intval($_POST['top']);
		$_POST['left']   = intval($_POST['left']);
		$_POST['active'] = intval($_POST['active']);
		$_POST['scroll'] = intval($_POST['scroll']);

		if ($action === 'popup_add') {
			$sql = 'INSERT INTO popup (po_title,po_top,po_left,po_width,po_height,po_scroll,po_skin,po_content,po_expire,po_active) VALUES (\''.$_POST['title'].'\','.$_POST['top'].','.$_POST['left'].', '.$_POST['width'].', '.$_POST['height'].', '.$_POST['scroll'].' \''.$_POST['skin'].'\', \''.$_POST['content'].'\', \''.$_POST['expire'].'\', '.$_POST['active'].')';

			$DB->Execute($sql);
			move('admin/popup.php?q=list','parent');
		} elseif($action === 'popup_edit') {
			$sql = 'UPDATE popup SET po_title=\''.$_POST['title'].'\', po_top='.$_POST['top'].', po_left='.$_POST['left'].', po_width='.$_POST['width'].', po_height='.$_POST['height'].', po_scroll='.$_POST['scroll'].', po_skin=\''.$_POST['skin'].'\', po_content=\''.$_POST['content'].'\', po_expire=\''.$_POST['expire'].'\', po_active='.$_POST['active'].' WHERE po_uid='.$_POST['uid'];

			$DB->Execute($sql);
			move('admin/popup.php?q=reg&u='.$_POST['uid'],'parent');
		}
		break;
	case 'popup_delete':
		if (!$_SESSION['admin']) alert('권한이 없습니다!', true);
		$DB->Execute('DELETE FROM popup WHERE po_uid='.$_GET['uid']);
		move('admin/popup.php?q=list','parent');
		break;
	//}}}
	//{{{연구원관련
	case 'member_add':
	case 'member_edit':
		if (!$_POST['id']) alert('사용자 아이디를 입력하세요.', true);
		if ($action=='member_add'&&!$_POST['pwd']) alert('패스워드를 입력하세요.', true);
		if (!$_POST['name']) alert('이름을 입력하세요.', true);
		if (!$_POST['hospital']) alert('병원을 선택하세요.', true);
		//if (!$_POST['part']) alert('직위를 입력하세요..', true);
		//if (!$_POST['mail']) alert('메일 주소를 입력하세요..', true);
		//if (!preg_match('/[a-z0-9_\-]+@[a-z0-9_\-]+(\.[a-z0-9_\-]+){1,2}/i',$_POST['mail'])) alert('메일 형식이 맞지 않습니다.', true);
		if ($action == 'member_add') {
			if ($DB->GetOne('SELECT count(*) FROM doctor WHERE doc_id=\''.$_POST['id'].'\'')) alert('이미 존재하는 아이디입니다.',true);
			$code = intval($DB->GetOne('SELECT MAX(doc_code) FROM doctor WHERE hs_code=\''.$_POST['hospital'].'\''))+1;

			$sql = 'INSERT INTO doctor (hs_code, doc_id, doc_pwd, doc_name, doc_addr, doc_mail, doc_tel, doc_fax, doc_mobile, doc_school, doc_part, doc_zipcode, doc_region, doc_gubun, doc_intro, doc_code) VALUES';
			$sql .= '(\''.$_POST['hospital'].'\',\''.$_POST['id'].'\',\''.md5($_POST['pwd']).'\',\''.$_POST['name'].'\',\''.$_POST['address'].'\',\''.$_POST['mail'].'\',\''.$_POST['tel'].'\', \''.$_POST['fax'].'\', \''.$_POST['mobile'].'\', \''.$_POST['school'].'\', \''.$_POST['part'].'\', \''.$_POST['zipcode'].'\', '.$_POST['region'].', '.$_POST['gubun'].', \''.$_POST['intro'].'\', '.$code.')';
			$u = $DB->GetOne('SELECT MAX(doc_uid) FROM doctor');
		} else {
			$sql = 'UPDATE doctor SET hs_code=\''.$_POST['hospital'].'\', doc_name=\''.$_POST['name'].'\',';
			$sql .= ' doc_addr=\''.$_POST['address'].'\', doc_mail=\''.$_POST['mail'].'\', doc_tel=\''.$_POST['tel'].'\', doc_mobile=\''.$_POST['mobile'].'\', doc_school=\''.$_POST['school'].'\', doc_part=\''.$_POST['part'].'\', doc_zipcode=\''.$_POST['zipcode'].'\', doc_region='.$_POST['region'].', doc_gubun='.$_POST['gubun'].', doc_intro=\''.$_POST['intro'].'\', doc_fax=\''.$_POST['fax'].'\' ';
			if ($_POST['pwd']) $sql .= ',doc_pwd=\''.md5($_POST['pwd']).'\' ';
			$sql .= ' WHERE doc_uid='.$_POST['uid'];
			$u = $_POST['uid'];
		}
		$bool = $DB->Execute($sql);
		
		// 사진이 있을 경우
		if ($_FILES['photo'] && is_uploaded_file($_FILES['photo']['tmp_name'])) {
			move_uploaded_file($_FILES['photo']['tmp_name'], 'data/photo/'.$u.'.jpg');
		}

		if (!$_SESSION['admin']) { alert('정보를 변경했습니다.'); move('member/modify.php?u=','parent'); }
		elseif ($_POST['continue']) move('admin/member_reg.php','parent');
		else move('admin/m_all.php','parent');
		break;
	case 'member_deactive'://	탈퇴
		$DB->Execute('UPDATE doctor SET doc_active=0 WHERE doc_uid='.$_GET['u']);
		move('admin/m_all.php?p='.$p, 'parent');
		break;
	case 'member_del'://	삭제
		$DB->Execute('DELETE FROM doctor WHERE doc_uid='.$_GET['u'].' AND doc_parent='.intval($_GET['parent']));//보조연구원
		$DB->Execute('DELETE FROM doctor WHERE doc_parent='.$_GET['u']);//교수
/*
		//	1. 보조연구원에 대한 환자를 추출하여 pa_delcheck = 0으로 만든다.
		$DB->Execute('UPDATE patient set pa_delcheck = 0 WHERE doc_uid='.$_GET['u']);//환자데이터
		//	2. 보조연구원에 대한 정보를 doc_active=2 으로 만든다.
		$DB->Execute('UPDATE doctor SET doc_active=2 WHERE doc_uid='.$_GET['u'].' AND doc_parent='.intval($_GET['parent']));//교수
		$DB->Execute('UPDATE doctor SET doc_active=2 WHERE doc_parent='.$_GET['u']);//보조연구원
*/
		if ($_SESSION['admin']) move('admin/m_all.php?p='.$p, 'parent');
		else move('member/modify.php?u='.$_SESSION['id'], 'parent');
		break;
	//}}}
	//{{{ 하위 연구원 등록
	case 'assist_add':
	case 'assist_edit':
		if (!$_POST['id']) alert('사용자 아이디를 입력하세요.', true);
		if (!$_POST['name']) alert('이름을 입력하세요.', true);
		if ($action == 'assist_add') {
			if (!$_POST['pwd']) alert('패스워드를 입력하세요.', true);
			if ($DB->GetOne('SELECT count(*) FROM doctor WHERE doc_id=\''.$_POST['id'].'\'')) alert('이미 존재하는 아이디입니다.',true);
			$sql = 'INSERT INTO doctor (hs_code,doc_id, doc_pwd, doc_name, doc_parent) VALUES (\''.$_POST['hospital'].'\',\''.$_POST['id'].'\',\''.md5($_POST['pwd']).'\',\''.$_POST['name'].'\', \''.$_POST['parent'].'\')';

			$DB->Execute($sql);
		} else {
			$sql = 'UPDATE doctor SET doc_name=\''.$_POST['name'].'\' '.($_POST['pwd']?',doc_pwd=\''.md5($_POST['pwd']).'\'':'').' WHERE doc_uid='.$_POST['uid'];

			if ($DB->Execute($sql)) {
				$_SESSION['name'] = $_POST['name'];
				$_SESSION['hash'] = md5($_SESSION['uid'].$_SESSION['name'].'__'.$_SESSION['admin']);
			}
		}

		move('member/modify.php?u='.$_SESSION['id'], 'parent');
		break;
	//}}}
	//{{{ 관리자정보
	case 'admininfo':
		if ($_POST['passwd']) {
			if (md5($_POST['oldpass']) !== $INI->getData('admin','passwd')) alert('기존 패스워드가 맞지 않습니다', true);
			if ($_POST['passwd'] !== $_POST['passwd2']) alert('새 패스워드가 잘못 입력되었습니다.', true);
			$INI->setData('admin','passwd',md5($_POST['passwd']));
		}

		$INI->setData('admin', 'name', $_POST['name']);
		$INI->setData('admin', 'email', $_POST['email']);
		$INI->setData('admin', 'phone', $_POST['phone']);
		$INI->Save(dirname(__FILE__).'/config.ini.php');

		alert('관리자 정보가 변경되었습니다.', true);
		move('admin/admin_info.php','parent');
		break;
	//}}}
	//{{{병원관련
	case 'hosp_add':
	case 'hosp_edit':
		if (!$_POST['code']) alert('병원코드를 입력하세요.', true);
		if (strlen($_POST['code']) != 3) alert('병원코드는 세자리로 입력하세요.', true);
		if (!$_POST['name']) alert('병원명을 입력하세요.', true);
		if ($_POST['omacor'] == '') $_POST['omacor'] = '0';
		if ($_POST['action'] == 'hosp_add') {
			$cnt = $DB->GetOne('SELECT count(*) FROM hospital WHERE hs_code=\''.$_POST['code'].'\'');
			if (intval($cnt) > 0) alert('중복된 코드는 사용할 수 없습니다.', true);
			$sql = 'INSERT INTO hospital (hs_code, hs_name, hs_tel, hs_omacor) VALUES (\''.$_POST['code'].'\', \''.$_POST['name'].'\', \''.$_POST['tel'].'\', \''.$_POST['omacor'].'\')';
		} else {
			$sql = 'UPDATE hospital SET hs_name=\''.$_POST['name'].'\', hs_tel= \''.$_POST['tel'].'\', hs_omacor = \''.$_POST['omacor'].'\' WHERE hs_code=\''.$_POST['code'].'\'';
		}
		$bool = $DB->Execute($sql);
		move('admin/hosp.php', 'parent');
		break;
	case 'hosp_del':
		$DB->Execute('DELETE FROM hospital WHERE hs_code=\''.$_GET['code'].'\'');
		move('admin/hosp.php', 'parent');
		break;
	//}}}
	//{{{단계별제목관리
	case 'titleman':
		for($i=1; $i<=10; $i++) {
			$INI->SetData('step', $i, $_POST['step'.$i]);
		}
		$INI->Save('./config.ini.php');
		move('admin/titleman.php', 'parent');
		break;
	//}}}
	//{{{환자관련
	case 'patient_add':
	case 'patient_edit':
		if (!$_POST['name']) alert('등록번호를 입력하세요!',true);
		if (!$_POST['jumin1']||!$_POST['jumin1']) alert('주민번호를 입력하세요!',true);
		if (!$_POST['chart']) alert('차트번호를 입력하세요!',true);

		$date = date('Ymd');
		$jumin = base64_encode($_POST['jumin1'].'-'.$_POST['jumin2']);

		$_POST['chart'] = base64_encode($_POST['chart']);
		if ($action == 'patient_add') {
			$code = $DB->GetOne('SELECT MAX(pa_code) FROM patient WHERE doc_uid='.$_SESSION['parent']);
			$code = intval($code)+1;

			$sql = 'INSERT INTO patient (doc_uid, pa_code, pa_name, pa_gender, pa_jumin, pa_chart, pa_laststep, pa_date, pa_update) VALUES ';
			$sql .= '('.$_SESSION['parent'].','.$code.', \''.$_POST['name'].'\', '.($_POST['jumin2']{0}).', \''.$jumin.'\',\''.$_POST['chart'].'\',1,'.$date.','.$date.')';
		} else {
			$sql = 'UPDATE patient SET pa_name=\''.$_POST['name'].'\', pa_gender=\''.($_POST['jumin2']{0}).'\', pa_jumin=\''.$jumin.'\', pa_chart=\''.$_POST['chart'].'\', pa_update='.$date.' WHERE pa_uid='.$_POST['uid'];
		}
		$bool = $DB->Execute($sql);
		move('member/questionnair.php?q=patient&p='.$_POST['p'], 'parent');
	case 'patient_del':
		//	삭제된 정보를 슈퍼관리자가 보기 위한 수정(pa_delcheck필드 추가 0이면 비삭제)
		$DB->Execute('UPDATE patient SET pa_delcheck=1 WHERE pa_uid=\''.$_GET['uid'].'\'');
//		$DB->Execute('DELETE FROM patient WHERE pa_uid=\''.$_GET['uid'].'\'');//	원본
		move('member/questionnair.php?q=patient&p='.$_GET['p'], 'parent');
		break;
	//}}}
	//{{{설문내용
	case 'ques_add':
	case 'ques_edit':
		if (!$_POST['ques']) alert('질문을 입력하세요.', true);
		if ($_POST['omacor'] != "Y") $_POST['omacor'] = "N";
		$_POST['ques'] = trim($_POST['ques']);
		$_POST['values'] = preg_replace("/[\r\n]+/", "\n", trim($_POST['values']));

		if ($action == 'ques_add') {
			if ($_POST['parent']) {
				$num = $DB->GetOne('SELECT it_num FROM items WHERE it_uid='.$_POST['parent']);
			} else {
				$num = $DB->GetOne('SELECT MAX(it_num) FROM items WHERE it_step='.$_POST['step']);
				$num = intval($num)+1;
			}
				
			$sql = 'INSERT INTO items (it_step, it_num, it_type, it_ques, it_values, it_parent, it_condition, it_omacor, it_notcon) VALUES ';
			$sql .= '('.$_POST['step'].','.$num.','.$_POST['type'].',\''.$_POST['ques'].'\',\''.$_POST['values'].'\', '.$_POST['parent'].', \''.$_POST['condition'].'\', \''.$_POST['omacor'].'\', \''.$_POST['notcon'].'\')';
		} else {
			$sql = 'UPDATE items SET ';
			$sql .= 'it_type='.$_POST['type'].',it_ques=\''.$_POST['ques'].'\',it_values=\''.$_POST['values'].'\', it_omacor=\''.$_POST['omacor'].'\', it_notcon=\''.$_POST['notcon'].'\'';
			if ($_POST['condition']) $sql .= ',it_condition=\''.$_POST['condition'].'\'';
			$sql .= ' WHERE it_uid='.$_POST['uid'];
		}
		$bool = $DB->Execute($sql);
		if ($bool && $_POST['parent'] && $action == 'ques_add') $DB->Execute('UPDATE items SET it_subitems=it_subitems+1 WHERE it_uid='.$_POST['parent']);
		move('admin/ques.php?step='.$_POST['step'].'&q='.($_POST['continue']?'make':'qlist'), 'parent');
		break;
	case 'ques_del':
		$data = $DB->GetRow('SELECT * FROM items WHERE it_uid='.$_GET['uid']);
		if (!$data) alert('잘못된 데이타입니다.', true);
		$DB->Execute('DELETE FROM items WHERE it_uid='.$_GET['uid'].' OR it_parent='.$_GET['uid']);
		$DB->Execute('UPDATE items SET it_num=it_num-1 WHERE it_step='.$data['it_step'].' AND it_parent='.$data['it_parent'].' AND it_num>'.$data['it_num']);
		if ($data['it_parent']) { // for parent node
			$DB->Execute('UPDATE items SET it_subitems=it_subitems-1 WHERE it_uid='.$data['it_parent']);
		}
		move('admin/ques.php?step='.$_GET['step'], 'parent');
		break;
	case 'ques_exchange':
		$DB->Execute('UPDATE items SET it_num=100 WHERE it_step='.$_GET['step'].' AND it_num='.$_GET['to']);
		$DB->Execute('UPDATE items SET it_num='.$_GET['to'].' WHERE it_step='.$_GET['step'].' AND it_num='.$_GET['from']);
		$DB->Execute('UPDATE items SET it_num='.$_GET['from'].' WHERE it_step='.$_GET['step'].' AND it_num=100');
		move('admin/all_list.php?step='.$_GET['step'], 'parent');
		break;
	//}}}
	//{{{설문처리
	case 'ques_process':
/*
		- 환자에 대한 문항정보
		patient.pa_uid	:	환자고유번호
		items.it_uid			:	문항고유번호
*/
		$uids = array();
		$sql = 'INSERT INTO questionnaire (it_uid, pa_uid, qs_input, qs_date, qs_value) VALUES ';
		$now = time();

		foreach ($_POST as $k=>$p) {
			if (substr($k,0,5) !== 'item_') continue;
			if (is_array($p)) $p = implode("\n", $p);
			if (!strlen(trim($p))) continue;
			
			if ($_POST['_'.$k]) { // 기타 옵션텍스트가 있을때
				$p = explode("\n", $p);
				$p[count($p)-1] = '['.$p[count($p)-1].'|'.$_POST['_'.$k].']';
				$p = implode("\n", $p);
			}

			$uids[] = $uid_ = substr($k,5);
			if ($p) {
				$sql .= '('.$uid_.','.$_POST['patient'].','.$_SESSION['uid'].','.$now.',\''.$p.'\'),';
			}
		}
		$sql = substr($sql,0,-1);
		
/*		if(!strcmp($_SERVER['REMOTE_ADDR'],"211.108.151.44")) {
			echo "
				<script language='javascript'>
					alert(\"".$sql."\")
				</script>
			";
			exit;
		}*/
		//$DB->Execute('DELETE FROM questionnaire WHERE pa_uid='.$_POST['patient'].' AND it_uid IN ('.implode(',', $uids).')');
		$DB->Execute('DELETE FROM questionnaire WHERE pa_uid='.$_POST['patient']);
		$bool = $DB->Execute($sql);
		if ($bool) {
			$max_step = $DB->GetOne('SELECT MAX(it_step) FROM items WHERE it_uid IN ('.implode(',', $uids).')');
			$DB->Execute('UPDATE patient SET pa_laststep='.$max_step.' WHERE pa_uid='.$_POST['patient'].' AND pa_laststep < '.$max_step);
			$DB->Execute('UPDATE patient SET pa_update='.date('Ymd',$now).' WHERE pa_uid='.$_POST['patient']);
		}
		if ($_POST['refresh']) move('member/questionnair.php?q=step&u='.$_POST['patient'], 'parent');
		if (str_replace(' ', '', $_POST['complete']) == '완료') {
			$DB->Execute('UPDATE patient SET pa_complete=1 WHERE pa_uid='.$_POST['patient']);
		}
		break;
	//}}}
	//{{{ 링크 처리
	case 'ques_process_view':
/*
		- 환자에 대한 문항정보
		patient.pa_uid	:	환자고유번호
		items.it_uid			:	문항고유번호
*/

		if ($_POST['refresh']) move('member/questionnair.php?q=step&u='.$_POST['patient'], 'parent');
		break;
	case 'link_add':
	case 'link_edit':
		if (!$_POST['name']) alert(($_POST['type']==3?'관련사이트':'학회').' 이름을 입력하세요.', true);
		$_POST['name'] = addslashes(stripslashes(trim($_POST['name'])));
		$_POST['url']  = addslashes(preg_replace('@^http://@i','',stripslashes(trim($_POST['url']))));
		$types = array(1=>'internal','expatriate','link');

		if ($action == 'link_add') {
			$sql = 'INSERT INTO links (ln_type,ln_name,ln_url) VALUES ('.$_POST['type'].',\''.$_POST['name'].'\', \''.$_POST['url'].'\') ';
		} else {
			$sql = 'UPDATE links SET ln_name=\''.$_POST['name'].'\', ln_url=\''.$_POST['url'].'\' WHERE ln_uid='.$_POST['uid'];
		}

		$bool = $DB->Execute($sql);
		move('admin/'.$types[intval($_POST['type'])].'.php', 'parent');
		break;
	case 'link_del':
		$types = array(1=>'internal','expatriate','link');
		$DB->Execute('DELETE FROM links WHERE ln_uid='.$_GET['uid']);
		move('admin/'.$types[intval($_GET['type'])].'.php', 'parent');
		break;
	//}}}
	//{{{ 데이터베이스 백업
	case 'db_backup':
		if (!$_SESSION['admin']) alert('권한이 없습니다!', true);
		$dbinfo = $INI->getArray('dbinfo');
		$file = dirname(__FILE__).'/data/backup.sql';

		switch ($_POST['type']) {
			case 'all':$tables='doctor items patient questionnaire hospital gee_board_free gee_board_notice links gee_member banner popup calendar';break;
			case 'member':$tables='doctor hospital';break;
			case 'ques':$tables='items patient questionnaire';break;
		}

		$cmd = '/usr/local/mysql/bin/mysqldump -u'.$dbinfo['user'].' -p'.$dbinfo['pass'].' '.$dbinfo['db'].' '.$tables.' > '.$file;
		exec($cmd); exec('chmod 707 '.$file);

		download($file, 'backup_'.date('Ymd').'.sql');
		break;
	//}}}
	//{{{ 전체메일
	case 'mailing':
		if (!$_SESSION['admin']) alert('권한이 없습니다!', true);
		if (!trim($_POST['cc']) && strlen(trim($_POST['to'])) == 0) alert('받을 사람을 입력하세요!', true);
		if (strlen(trim($_POST['subject'])) == 0) alert('제목을 입력하세요!', true);
		if (strlen(trim($_POST['content'])) == 0) alert('내용을 입력하세요!', true);
		if ($_POST['cc']) $recipients = array('To'=>$_POST['to'], 'Cc'=>$_POST['cc']);
		else $recipients = $_POST['to'];

		require_once 'Mail.php'; // pear mail
		$mail =& Mail::factory('sendmail');

		$headers['From'] = 'KAMIR <admin@kamir.or.kr>';
		$headers['To'] = $_POST['to'];
		$headers['Subject'] = $_POST['subject'];
		$headers['Content-Type'] = 'text/html';

		$bool = $mail->send($recipients, $headers, $_POST['content']);
		if ($bool) alert('메일을 성공적으로 발송했습니다.');
		else alert('메일발송에 실패했습니다.');
		break;
	//}}}
	//{{{ 고객지원
	case 'support':
		if (!$_SESSION['admin']) alert('권한이 없습니다!', true);
		if (strlen(trim($_POST['subject'])) == 0) alert('제목을 입력하세요!', true);
		if (strlen(trim($_POST['content'])) == 0) alert('내용을 입력하세요!', true);
		require_once 'Mail.php'; // pear mail
		$mail =& Mail::factory('sendmail');

		$headers['From'] = 'KAMIR <admin@kamir.or.kr>';
		$headers['To'] = 'djkang@dainit.com';
		$headers['Subject'] = $_POST['subject'];

		$bool = $mail->send('djkang@dainit.com', $headers, $_POST['content']);
		if ($bool) alert('메일을 성공적으로 발송했습니다.');
		else alert('메일발송에 실패했습니다.');
		break;
	//}}}
	//{{{ 일정관리
	case 'calendar_add':
	case 'calendar_edit':
		if (!$_POST['title']) alert('제목을 입력하세요.',true);
		if (!$_POST['content']) alert('내용을 입력하세요.', true);
		if ($_POST['allday']) $_POST['time'] = 0;
		elseif (!strlen($_POST['hour'])||!strlen($_POST['min'])) alert('시간을 입력하세요.',true);
		else $_POST['time'] = sprintf('%d%02d',$_POST['hour'],$_POST['min']);

		$_POST['public'] = intval($_POST['public']);

		if ($action == 'calendar_add') {
			$sql = 'INSERT INTO calendar (cal_date,cal_time,doc_uid,cal_title,cal_content,cal_public) VALUES (';
			$sql .= $_POST['date'].','.$_POST['time'].','.$_SESSION['parent'].',\''.$_POST['title'].'\',\''.$_POST['content'].'\',';
			$sql .= $_POST['public'].')';
		} else {
			$sql = 'UPDATE calendar SET cal_time='.$_POST['time'].',cal_title=\''.$_POST['title'].'\',cal_content=\''.$_POST['content'].'\',cal_public='.$_POST['public'].' WHERE cal_uid='.$_POST['uid'];
		}
		$DB->Execute($sql);
		move('member/calendar.php?y='.substr($_POST['date'],0,4).'&m='.intval(substr($_POST['date'],4,2)), 'parent');
		break;
	case 'calendar_del':
		$DB->Execute('DELETE FROM calendar WHERE cal_uid='.$_GET['uid']);
		move('member/calendar.php?y='.$_GET['y'].'&m='.$_GET['m'], 'parent');
		break;
	//}}}
	//{{{ 엑셀로 자료받기 (total-trend)
	case 'excel_trend':
		require_once "lib/class.writeexcel_workbook.inc.php";
		require_once "lib/class.writeexcel_worksheet.inc.php";

		$file = dirname(__FILE__).'/data/'.$_SESSION['parent'].'_trend.xls';
		$workbook =& new writeexcel_workbook($file);
		$worksheet1 =& $workbook->addworksheet('병원별');
		$worksheet2 =& $workbook->addworksheet('진단명별');
		$worksheet3 =& $workbook->addworksheet('연령별');
		$worksheet4 =& $workbook->addworksheet('성별');

		// 병원별
		$data = array(); $sum1 = 0; $sum2 = 0;
		$tmp = $DB->GetAll("SELECT h.hs_name,p.pa_complete,pa_uid,count(*) as cnt FROM patient as p, doctor as d, hospital as h WHERE p.doc_uid=d.doc_uid AND d.hs_code=h.hs_code AND d.doc_active=1 and p.pa_delcheck <> '1'  GROUP BY h.hs_name,p.pa_complete ORDER BY h.hs_name");
		for($i=0; $i<count($tmp); $i+=2) {
			$key = 1; $val = (int)$tmp[$i+1]['cnt'];
			if ($tmp[$i]['hs_name'] !== $tmp[$i+1]['hs_name']) {
				$key = abs($tmp[$i]['pa_complete']-1);
				$val = 0;
			}
			$data[$tmp[$i]['hs_name']] = array($tmp[$i]['pa_complete']=>(int)$tmp[$i]['cnt'],$key=>$val);
			if ($tmp[$i]['hs_name'] !== $tmp[$i+1]['hs_name']) $i--;
		}
		$row_num = 2;
		$worksheet1->write_row('A1', array('병원명','진행','완료','합계'));
		foreach ($data as $k=>$v){
			$sum1+=(int)$v[0];$sum2+=(int)$v[1];
			$worksheet1->write_row('A'.$row_num++, array($k,$v[0],$v[1],$v[0]+$v[1]));
		}
		$worksheet1->write_row('A'.$row_num, array('총계',$sum1,$sum2,$sum1+$sum2));

		// 진단명별
		$data = array(); $sum1 = 0; $sum2 = 0;
		$tmp = $DB->GetAll('SELECT q.qs_value,p.pa_complete,count(*) as cnt FROM patient as p,questionnaire as q,items as i,doctor as d WHERE q.pa_uid=p.pa_uid AND q.it_uid=i.it_uid AND p.doc_uid=d.doc_uid AND d.doc_active=1 and p.pa_delcheck <> \'1\' AND i.it_ques=\'Final diagnosis\' GROUP BY q.qs_value,p.pa_complete ORDER BY q.qs_value');
		for($i=0; $i<count($tmp); $i+=2) {
			$key = 1; $val = (int)$tmp[$i+1]['cnt'];
			if ($tmp[$i]['qs_value'] !== $tmp[$i+1]['qs_value']) {
				$key = abs($tmp[$i]['pa_complete']-1);
				$val = 0;
			}
			$data[$tmp[$i]['qs_value']] = array($tmp[$i]['pa_complete']=>(int)$tmp[$i]['cnt'],$key=>$val);
			if ($tmp[$i]['qs_value'] !== $tmp[$i+1]['qs_value']) $i--;
		}
		$row_num = 2;
		$worksheet2->write_row('A1', array('진단명','진행','완료','합계'));
		foreach ($data as $k=>$v){
			$sum1+=(int)$v[0];$sum2+=(int)$v[1];
			$worksheet2->write_row('A'.$row_num++, array($k,$v[0],$v[1],$v[0]+$v[1]));
		}
		$worksheet2->write_row('A'.$row_num, array('총계',$sum1,$sum2,$sum1+$sum2));

		// 연령별
		$data = array(
			'20대 이전'=>array(0,0),'20대~30대'=>array(0,0),'30대~40대'=>array(0,0),'30대~40대'=>array(0,0),
			'40대~50대'=>array(0,0),'50대~60대'=>array(0,0),'60대~70대'=>array(0,0),'70대 이후'=>array(0,0)
		);
		$sum1 = 0; $sum2 = 0;
		$tmp = $DB->GetAll('SELECT q.qs_value,p.pa_complete FROM patient as p,questionnaire as q,items as i,doctor as d WHERE q.pa_uid=p.pa_uid AND q.it_uid=i.it_uid AND p.doc_uid=d.doc_uid AND d.doc_active=1 and p.pa_delcheck <> \'1\'  AND i.it_step=1 AND i.it_num=1');
		list($cy, $cm, $cd) = explode(' ', date('Y g j', time()));
		for($i=0; $i<count($tmp); $i++) {
			preg_match('/(\d+)\s*(\d+)\s*(\d+)/s', $tmp[$i]['qs_value'], $match);
			$y = (int)$match[1]; $m = (int)$match[2]; $d = (int)$match[3];
			$age = ($cy - $y) + (($m*100+$d<=$cm*100+$cd)?1:0);
			$key = floor($age/10)*10;
			
			if ($key >= 70) $key = '70대 이후';
			elseif ($key < 20) $key = '20대 이전';
			else $key = $key.'대~'.($key+10).'대';

			$complete = $tmp[$i]['pa_complete'];
			$data[$key][$complete] = intval($data[$key][$complete]) + 1;
		}
		$row_num = 2;
		$worksheet3->write_row('A1', array('연령별','진행','완료','합계'));
		foreach ($data as $k=>$v){
			$sum1+=(int)$v[0];$sum2+=(int)$v[1];
			$worksheet3->write_row('A'.$row_num++, array($k,$v[0],$v[1],$v[0]+$v[1]));
		}
		$worksheet3->write_row('A'.$row_num, array('총계',$sum1,$sum2,$sum1+$sum2));

		// 성별
		$data = array(); $sum1 = 0; $sum2 = 0;
		$tmp = $DB->GetAll('SELECT q.qs_value,p.pa_complete,count(*) as cnt FROM patient as p,questionnaire as q,items as i,doctor as d WHERE q.pa_uid=p.pa_uid AND q.it_uid=i.it_uid AND p.doc_uid=d.doc_uid AND d.doc_active=1 and p.pa_delcheck <> \'1\'  AND i.it_ques=\'Gender\' GROUP BY q.qs_value,p.pa_complete ORDER BY q.qs_value DESC');
		for($i=0; $i<count($tmp); $i+=2) {
			$key = 1; $val = (int)$tmp[$i+1]['cnt'];
			if ($tmp[$i]['qs_value'] !== $tmp[$i+1]['qs_value']) {
				$key = abs($tmp[$i]['pa_complete']-1);
				$val = 0;
			}
			$data[$tmp[$i]['qs_value']] = array($tmp[$i]['pa_complete']=>(int)$tmp[$i]['cnt'],$key=>$val);
			if ($tmp[$i]['qs_value'] !== $tmp[$i+1]['qs_value']) $i--;
		}
		$row_num = 2;
		$worksheet4->write_row('A1', array('성별','진행','완료','합계'));
		foreach ($data as $k=>$v){
			$sum1+=(int)$v[0];$sum2+=(int)$v[1];
			$worksheet4->write_row('A'.$row_num++, array($k,$v[0],$v[1],$v[0]+$v[1]));
		}
		$worksheet4->write_row('A'.$row_num, array('총계',$sum1,$sum2,$sum1+$sum2));


		$workbook->close();
		download($file, basename($file));
		break;
	//}}}
	//{{{ 엑셀로 자료받기 (환자데이터)
	case 'excel':

		if ($_GET['mode'] == 'all') {
			if (!$_SESSION['admin']) alert('관리자만 사용할 수 있습니다.',true);
			$excel_cron_file = dirname(__FILE__).'/data/'.date("Ymd").'_tmp.xls';
			download($excel_cron_file, 'Date_'.date('Ymd').'.xls');
			exit;
		}

		require_once "lib/class.writeexcel_workbook.inc.php";
		require_once "lib/class.writeexcel_worksheet.inc.php";
		include '_process_func.php';

		$file = dirname(__FILE__).'/data/'.$_SESSION['parent'].'_tmp.xls';
		$workbook =& new writeexcel_workbook($file);
		$worksheet1 =& $workbook->addworksheet('Question');
		$worksheet2 =& $workbook->addworksheet('Data');

		$format = array();

		// 문항정보
		$item = array(); $row_num  = 1;
		$depth1 = $DB->GetAll('SELECT it_uid,it_step,it_num,it_subitems,it_ques FROM items WHERE it_parent=0 ORDER BY it_step,it_num');
		foreach ($depth1 as $k1=>$d1) {
			$item[$d1['it_uid']] = 'Q'.($k1+1);
			$worksheet1->write_row('A'.$row_num++, array($item[$d1['it_uid']],$d1['it_ques']));
			
			// depth 2
			if ($d1['it_subitems'] > 0) {
				$depth2 = $DB->GetAll('SELECT it_uid,it_subitems,it_ques FROM items WHERE it_parent='.$d1['it_uid']);
				foreach ($depth2 as $k2=>$d2) {
					$item[$d2['it_uid']] = $item[$d1['it_uid']].'-'.($k2+1);
					$worksheet1->write_row('A'.$row_num++, array('',$item[$d2['it_uid']],$d2['it_ques']));
					
					// depth 3
					if ($d2['it_subitems'] > 0) {
						$depth3 = $DB->GetAll('SELECT it_uid,it_subitems,it_ques FROM items WHERE it_parent='.$d2['it_uid']);
						foreach ($depth3 as $k3=>$d3) {
							$item[$d3['it_uid']] = $item[$d2['it_uid']].'-'.($k3+1);
							$worksheet1->write_row('A'.$row_num++, array('','',$item[$d3['it_uid']],$d3['it_ques']));

							// depth 4
							if ($d3['it_subitems'] > 0) {
								$depth4 = $DB->GetAll('SELECT it_uid,it_subitems,it_ques FROM items WHERE it_parent='.$d3['it_uid']);
								foreach ($depth3 as $k4=>$d4) {
									$item[$d3['it_uid']] = $item[$d3['it_uid']].'-'.($k4+1);
									$worksheet1->write_row('A'.$row_num++, array('','',$item[$d4['it_uid']],$d4['it_ques']));
								}
							}

						}
					}
				}
			}
		}

		// mode 조건에 따라 쿼리조건을 달리 한다.
		$sql = 'SELECT d.doc_uid,d.doc_name,d.doc_code,d.hs_code,p.* FROM patient as p, doctor as d '."\n";
		switch ($_GET['mode']) {
			case 'all': // 전체리스트 (관리자)
				if (!$_SESSION['admin']) alert('관리자만 사용할 수 있습니다.',true);
				$excel_cron_file = dirname(__FILE__).'/data/'.date("Ymd").'_tmp.xls';
				download($excel_cron_file, 'Date_'.date('Ymd').'.xls');
				exit;
				$sql .= 'WHERE p.doc_uid=d.doc_uid AND d.doc_active=1';
				$header = array('Code','Name','Step');
				break;
			case 'member': // 연구원별리스트 (관리자)
				if (!$_SESSION['admin']) alert('관리자만 사용할 수 있습니다.',true);
				$sql .= 'WHERE p.doc_uid='.$_GET['doctor'].' AND d.doc_uid='.$_GET['doctor'];
				$header = array('Code','Name','Step');
				break;
			case 'recent': // 최근작성자료 (관리자)
				if (!$_SESSION['admin']) alert('관리자만 사용할 수 있습니다.',true);
				$sql .= 'WHERE p.pa_update>='.(date('Ymd', time()-3600*24*$_GET['day']))." \n".' AND p.doc_uid=d.doc_uid AND d.doc_active=1';
				$header = array('Code','Name','Step');
				break;
			case 'doctor': // 환자조회 (회원)
			default:
				$sql .= 'WHERE p.doc_uid='.$_SESSION['parent'].' AND d.doc_uid=p.doc_uid';
				if (strlen($_GET['complete'])) $sql .= ' AND p.pa_complete='.$_GET['complete'];
				$header = array('Code','Name','Chart No','Step');
				break;
		}
		set_time_limit(0);

		// header 출력
		$header = array_merge($header, array_values($item));
		$worksheet2->write_row('A1', $header);
		
		// 관련된 환자에 대한 정보를 가져온다.
		$patient = $DB->GetAll($sql);
		set_time_limit(0);

		$row_num = 2; $format = array();
		foreach ($patient as $p) {
			set_time_limit(0);
			$row = array(
				$p['hs_code'].'-'.$p['doc_code'].'-'.$p['pa_code'],
				$p['pa_name']
			);

			if ($_SESSION['admin']) {
				$row[] = $p['pa_laststep'].'단계('.($p['pa_complete']?'완료':'진행').')';
			} else {
				$row[] = base64_decode($p['pa_chart']);
				$row[] = $p['pa_laststep'].'단계('.($p['pa_complete']?'완료':'진행').')';
			}

			// get data
			$ques = array();
			$tmp = $DB->GetAll('SELECT it_uid,qs_value FROM questionnaire WHERE pa_uid='.$p['pa_uid']);
			foreach ($tmp as $t) {
				// TODO : 문항처리(특수처리 포함)
				$t['qs_value'] = preg_replace('/\[(.+)\|(.+)\]$/U', '$1, $2', $t['qs_value']);

				$func = str_replace('-', '_', $item[$t['it_uid']]);
				if (function_exists($func)) {
					$t['qs_value'] = call_user_func($func, $t['qs_value']);
				}
				//davej..............modify 2005-08-10
				$t['qs_value'] = str_replace("\n", " | ", $t['qs_value']);
				$ques[$t['it_uid']] = $t['qs_value'];
			}
			
			foreach ($item as $k=>$v) {
				$row[] = $ques[$k];
			}

			$worksheet2->write_row('A'.$row_num++, $row);
		}
		$workbook->close();

		download($file, 'Date_'.date('Ymd').'.xls');
		break;
	//}}}
}


function alert($msg, $exit=false, $extra='')
{
	echo '<script langauge="javascript" type="text/javascript">';
	echo 'alert("'.str_replace("\n",'\\n',$msg).'");';
	echo $extra;
	echo '</script>';
	if ($exit) exit;
}

function download($file, $filename)
{
	ob_end_clean();
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D,d M YH:i:s').' GMT');
	header ('Cache-Control: cache, must-revalidate');
	header ('Pragma: no-cache');
	header ('Content-Type: application/octet-stream');
	header ('Content-Disposition: attachment; filename="'.$filename.'"' );
	header ('Content-Transfer-Encoding: binary');
	header ('Content-Length: '.(string)(filesize($file))); 
	header ('Content-Description: PHP Generated Data');
	readfile($file);
	
/*	$fh = fopen($file, 'rb');
	fpassthru($fh);	*/
	if($_GET['mode'] != 'all')
		@unlink($file);
	exit;
}

function excel($file, $filename)
{
	ob_end_clean();
	header("Content-Type: application/x-msexcel");
	header ('Content-Disposition: attachment; filename="'.$filename.'"' );
	header ('Content-Length: '.(string)(filesize($file))); 
	$fh = fopen($file, 'rb');
	fpassthru($file);
	if($_GET['mode'] != 'all')
		@unlink($file);
	exit;
}

include 'footer.php';
?>
