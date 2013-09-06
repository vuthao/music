<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung (phantandung92@gmail.com)
 * @Copyright (C) 2011 Freeware
 * @Createdate 06-09-2013 22:29
 */

if( ! defined( 'NV_IS_UPDATE' ) ) die( 'Stop!!!' );
 
$nv_update_config = array();

$nv_update_config['type'] = 1; // Kieu nang cap 1: Update; 2: Upgrade
$nv_update_config['packageID'] = 'NVUDMUSIC3501'; // ID goi cap nhat
$nv_update_config['formodule'] = "music"; // Cap nhat cho module nao, de trong neu la cap nhat NukeViet, ten thu muc module neu la cap nhat module

// Thong tin phien ban, tac gia, ho tro
$nv_update_config['release_date'] = 1363499027;
$nv_update_config['author'] = "Phan Tan Dung (phantandung92@gmail.com)";
$nv_update_config['support_website'] = "http://nukeviet.vn/phpbb/viewforum.php?f=118";
$nv_update_config['to_version'] = "3.5.01";
$nv_update_config['allow_old_version'] = array( "3.4.02" );
$nv_update_config['update_auto_type'] = 1; // 0:Nang cap bang tay, 1:Nang cap tu dong, 2:Nang cap nua tu dong

$nv_update_config['lang'] = array();
$nv_update_config['lang']['vi'] = array();
$nv_update_config['lang']['en'] = array();

// Tiếng Việt
$nv_update_config['lang']['vi']['nv_up_deletefile'] = 'Xóa các file chức năng lấy nhạc từ site khác và các file thừa của nó';

$nv_update_config['lang']['vi']['nv_up_version'] = 'Cập nhật phiên bản';

// English
$nv_update_config['lang']['en']['nv_up_deletefile'] = 'Delete get song from others site files';

$nv_update_config['lang']['en']['nv_up_version'] = 'Updated version';

// Require level: 0: Khong bat buoc hoan thanh; 1: Canh bao khi that bai; 2: Bat buoc hoan thanh neu khong se dung nang cap.
// r: Revision neu la nang cap site, phien ban neu la nang cap module

$nv_update_config['tasklist'] = array();

$nv_update_config['tasklist'][] = array( 'r' => '3.5.01', 'rq' => 2, 'l' => 'nv_up_deletefile', 'f' => 'nv_up_deletefile' );

$nv_update_config['tasklist'][] = array( 'r' => '3.5.01', 'rq' => 2, 'l' => 'nv_up_version', 'f' => 'nv_up_version' );

// Danh sach cac function
/*
Chuan hoa tra ve:
array(
	'status' =>
	'complete' => 
	'next' =>
	'link' =>
	'lang' =>
	'message' =>
);

status: Trang thai tien trinh dang chay
- 0: That bai
- 1: Thanh cong

complete: Trang thai hoan thanh tat ca tien trinh
- 0: Chua hoan thanh tien trinh nay
- 1: Da hoan thanh tien trinh nay

next:
- 0: Tiep tuc ham nay voi "link"
- 1: Chuyen sang ham tiep theo

link:
- NO
- Url to next loading

lang:
- ALL: Tat ca ngon ngu
- NO: Khong co ngon ngu loi
- LangKey: Ngon ngu bi loi vi,en,fr ...

message:
- Any message

Duoc ho tro boi bien $nv_update_baseurl de load lai nhieu lan mot function
Kieu cap nhat module duoc ho tro boi bien $old_module_version
*/

$array_lang_music_update = array();
// Lay danh sach ngon ngu
$result = $db->sql_query( "SELECT `lang` FROM `" . $db_config['prefix'] . "_setup_language` WHERE `setup`=1" );
while( list( $_tmp ) = $db->sql_fetchrow( $result ) )
{
	$array_lang_music_update[$_tmp] = array( "lang" => $_tmp, "mod" => array() );
	
	// Get all module of music
	$result1 = $db->sql_query( "SELECT `title`, `module_data` FROM `" . $db_config['prefix'] . "_" . $_tmp . "_modules` WHERE `module_file`='music'" );
	while( list( $_modt, $_modd ) = $db->sql_fetchrow( $result1 ) )
	{
		$array_lang_music_update[$_tmp]['mod'][] = array( "module_title" => $_modt, "module_data" => $_modd );
	}
}

function nv_up_deletefile()
{
	global $nv_update_baseurl, $db, $db_config, $old_module_version, $array_lang_music_update;
	$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );

	// Xoa cac file thua
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/getnhaccuatui.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/getnhacso.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/getnhacvui.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/getzing.php" );
	@nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/music/nhaccuatui.tpl" );
	
	return $return;
}

function nv_up_version()
{
	global $nv_update_baseurl, $db, $db_config, $old_module_version, $array_lang_music_update;
	$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );

	// Cap nhat lai revision va version cua module
	foreach( $array_lang_music_update as $lang => $array_mod )
	{
		foreach( $array_mod['mod'] as $module_info )
		{
			$table = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'] . "_setting";
			$db->sql_query( "UPDATE `" . $table . "` SET `value`=500 WHERE `key`='revision'" );				
			$db->sql_query( "UPDATE `" . $table . "` SET `char`='3.5.01' WHERE `key`='version'" );				
		}
	}
	
	$mod_version = "3.5.01 1363499027";
	$db->sql_query( "UPDATE `" . $db_config['prefix'] . "_setup_modules` SET `mod_version`='" . $mod_version . "', `author`='PHAN TAN DUNG (phantandung92@gmail.com)' WHERE `module_file`='music'" );
	
	nv_delete_all_cache();
	
	return $return;
}

?>