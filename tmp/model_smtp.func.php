<?php



// 用配置文件来保存 smtp 列表数据
$smtplist = array();
function smtp_create($arr) {
	
	global $smtplist;
	$smtplist[] = $arr;
	smtp_save();
	
	return count($smtplist);
}

function smtp_update($id, $arr) {
	
	global $smtplist;
	if(!isset($smtplist[$id])) return FALSE;
	foreach($arr as $k=>$v) {
		$smtplist[$id][$k] = $v;
	}
	smtp_save();
	
	return TRUE;
}

function smtp_read($id) {
	
	global $smtplist;
	
	return isset($smtplist[$id]) ? $smtplist[$id] : array();
}

function smtp_delete($id) {
	
	global $smtplist;
	unset($smtplist[$id]);
	smtp_save();
	
	return TRUE;
}

function smtp_save() {
	
	global $smtplist;
	
	file_put_contents(APP_PATH.'conf/smtp.conf.php', "<?php\r\nreturn ".var_export($smtplist,true).";\r\n?>");
}

function smtp_init($confile) {
	$list = array(
		array(
		'email'=>'',
		'host'=>'',
		'port'=>'',
		'user'=>'',
		'pass'=>'',
	));
	if(!is_file($confile)) {
		touch($confile);
		return $list;
	} else {
		$arr = include $confile;
		if(!is_array($arr)) {
			return $list;
		}
		return $arr;
	}
}

function smtp_find() {
	
	
	global $smtplist;
	return $smtplist;
}

function smtp_count() {
	
	global $smtplist;
	$n = count($smtplist);
	
	return $n;
}

function smtp_maxid() {
	
	
	return smtp_count() - 1;
}




?>