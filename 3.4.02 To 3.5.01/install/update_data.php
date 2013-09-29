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
$nv_update_config['lang']['vi']['info_continue_singer'] = 'Cập nhật cho ngôn ngữ %s, module: %s lần: %s';

$nv_update_config['lang']['vi']['nv_up_deletefile'] = 'Xóa các file chức năng lấy nhạc từ site khác và các file thừa của nó';
$nv_update_config['lang']['vi']['nv_up_dbtype'] = 'Cập nhật CSDL phần ca sĩ';
$nv_update_config['lang']['vi']['nv_up_dbtypeauthor'] = 'Cập nhật CSDL phần nhạc sĩ';
$nv_update_config['lang']['vi']['nv_up_dbsong'] = 'Cập nhật bảng bài hát';
$nv_update_config['lang']['vi']['nv_up_tagsong'] = 'Xóa bỏ phần quản lý block tags song trong admin';

$nv_update_config['lang']['vi']['nv_up_version'] = 'Cập nhật phiên bản';

// English
$nv_update_config['lang']['en']['info_continue_singer'] = 'Update for lang: %s, module: %s time: %s';

$nv_update_config['lang']['en']['nv_up_deletefile'] = 'Delete get song from others site files';
$nv_update_config['lang']['en']['nv_up_dbtype'] = 'Update database type of singer';
$nv_update_config['lang']['en']['nv_up_dbtypeauthor'] = 'Update database type of authors';
$nv_update_config['lang']['en']['nv_up_dbsong'] = 'Update song table';
$nv_update_config['lang']['vi']['nv_up_tagsong'] = 'Delete tags song block management';

$nv_update_config['lang']['en']['nv_up_version'] = 'Updated version';

// Require level: 0: Khong bat buoc hoan thanh; 1: Canh bao khi that bai; 2: Bat buoc hoan thanh neu khong se dung nang cap.
// r: Revision neu la nang cap site, phien ban neu la nang cap module

$nv_update_config['tasklist'] = array();

$nv_update_config['tasklist'][] = array( 'r' => '3.5.01', 'rq' => 2, 'l' => 'nv_up_deletefile', 'f' => 'nv_up_deletefile' );
$nv_update_config['tasklist'][] = array( 'r' => '3.5.01', 'rq' => 2, 'l' => 'nv_up_dbtype', 'f' => 'nv_up_dbtype' );
$nv_update_config['tasklist'][] = array( 'r' => '3.5.01', 'rq' => 2, 'l' => 'nv_up_dbtypeauthor', 'f' => 'nv_up_dbtypeauthor' );
$nv_update_config['tasklist'][] = array( 'r' => '3.5.01', 'rq' => 2, 'l' => 'nv_up_dbsong', 'f' => 'nv_up_dbsong' );
$nv_update_config['tasklist'][] = array( 'r' => '3.5.01', 'rq' => 2, 'l' => 'nv_up_tagsong', 'f' => 'nv_up_tagsong' );

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
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/addsong.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/addalbum.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/findasongtoalbum.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/findsongtoalbum.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/addvideo.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/addauthor.php" );
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/addsinger.php" );
	@nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/music/nhaccuatui.tpl" );
	@nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/music/findasongtoalbum.tpl" );
	@nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/music/findsongtoalbum.tpl" );
	@nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/music/video.tpl" );
	
	return $return;
}

function nv_up_dbtype()
{
	global $nv_update_baseurl, $db, $db_config, $old_module_version, $array_lang_music_update, $nv_Request, $lang_module, $language_array;
	$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );

	// Xac dinh URL
	$didlang = $nv_Request->get_string( 'didlang', 'get', '' );
	$didmod = $nv_Request->get_string( 'didmod', 'get', '' );
	$didlang = $didlang ? unserialize( nv_base64_decode( $didlang ) ) : array();
	$didmod = $didmod ? unserialize( nv_base64_decode( $didmod ) ) : array();
	$loopcount = $nv_Request->get_int( 'loopcount', 'get', 0 );
	$time = $nv_Request->get_int( 'time', 'get', 1 );
	
	// Thay doi kieu du lieu - Chi lam lan dau tien
	if( empty( $didlang ) and empty( $didmod ) and empty( $loopcount ) )
	{
		foreach( $array_lang_music_update as $lang => $array_mod )
		{
			foreach( $array_mod['mod'] as $module_info )
			{
				$prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
				
				$db->sql_query( "ALTER TABLE `" . $prefix . "` CHANGE `casi` `casi` varchar( 255 ) NOT NULL DEFAULT ''" ); // Bang nhac
				$db->sql_query( "ALTER TABLE `" . $prefix . "_album` CHANGE `casi` `casi` varchar( 255 ) NOT NULL DEFAULT ''" ); // Bang album
				$db->sql_query( "ALTER TABLE `" . $prefix . "_video` CHANGE `casi` `casi` varchar( 255 ) NOT NULL DEFAULT ''" ); // Bang video
			}
		}
	}
	
	$loopcount ++;
	
	// Cap nhat lai ca si bang cach
	foreach( $array_lang_music_update as $lang => $array_mod )
	{
		if( in_array( $lang, $didlang ) )
		{
			continue; // Thuc hien roi thi bo qua
		}
		
		if( ! isset( $didmod[$lang] ) ) $didmod[$lang] = array(); // Tao bien rong neu khong ton tai
		
		foreach( $array_mod['mod'] as $module_info )
		{
			if( in_array( $module_info['module_data'], $didmod[$lang] ) )
			{
				$time = 1; // Set lai cho module lan 1
				continue; // Thuc hien roi thi bo qua
			}
			
			$prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
			
			// Moi lan cap nhat 50 ca si
			$sql = "SELECT `id`, `tenthat` FROM `" . $prefix . "_singer` WHERE `tenthat` LIKE '% ft. %' ORDER BY `id` DESC LIMIT 0,50";
			$resultLEV1 = $db->sql_query( $sql );
			
			if( ! $db->sql_numrows( $resultLEV1 ) )
			{
				// Khong con ca si nao can xu ly nua thi luu vao bien thong tin
				$didmod[$lang][] = $module_info['module_data'];
			}
			else // Xu ly du lieu
			{
				while( $singer = $db->sql_fetch_assoc( $resultLEV1 ) )
				{
					$singer['tenthat'] = str_replace( array( ' FT. ', ' Ft. ', ' fT. ' ), array( ' ft. ', ' ft. ', ' ft. ' ), $singer['tenthat'] );
					$singer['tenthat'] = array_filter( array_unique( array_map( "trim", explode( " ft. ", $singer['tenthat'] ) ) ) );
					
					$array_singer_id = array();

					// Neu ton tai ca si thu nhat thi xoa luon ca si, nguoc lai thi cap nhat
					$sql = "SELECT `id` FROM `" . $prefix . "_singer` WHERE `tenthat`=" . $db->dbescape( $singer['tenthat'][0] ) . " LIMIT 1";
					$result = $db->sql_query( $sql );
					
					if( $db->sql_numrows( $result ) )
					{
						$db->sql_query( "DELETE FROM `" . $prefix . "_singer` WHERE `id`=" . $singer['id'] );
						$tmp = $db->sql_fetch_assoc( $result );
						$array_singer_id[] = $tmp['id'];
					}
					else
					{
						$array_singer_id[] = $singer['id'];
						$db->sql_query( "UPDATE `" . $prefix . "_singer` SET `tenthat`=" . $db->dbescape( $singer['tenthat'][0] ) . ", `ten`=" . $db->dbescape( change_alias( $singer['tenthat'][0] ) ) . " WHERE `id`=" . $singer['id'] );
					}
					
					unset( $singer['tenthat'][0] );
					
					foreach( $singer['tenthat'] as $tenthat )
					{
						// Neu ton tai ca si thi lay ID nguoc lai thi them ca si moi
						$sql = "SELECT `id` FROM `" . $prefix . "_singer` WHERE `tenthat`=" . $db->dbescape( $tenthat ) . " LIMIT 1";
						$result = $db->sql_query( $sql );
						
						if( $db->sql_numrows( $result ) )
						{
							$tmp = $db->sql_fetch_assoc( $result );
							$array_singer_id[] = $tmp['id'];
						}
						else
						{
							$sql = "INSERT INTO `" . $prefix . "_singer` ( `id`, `ten`, `tenthat`, `thumb`, `introduction`, `numsong`, `numalbum`, `numvideo` ) VALUES ( NULL, " . $db->dbescape( change_alias( $tenthat ) ) . ", " . $db->dbescape( $tenthat ) . ", '', '', 0, 0, 0 )";
							$array_singer_id[] = $db->sql_query_insert_id( $sql );
						}
					}
					
					$array_singer_id = $db->dbescape( implode( ",", $array_singer_id ) );
					
					// Cap nhat cho bai hat
					$sql = "UPDATE `" . $prefix . "` SET `casi`=" . $array_singer_id . " WHERE `casi`=" . $db->dbescape( $singer['id'] );
					$db->sql_query( $sql );
					
					// Cap nhat cho album
					$sql = "UPDATE `" . $prefix . "_album` SET `casi`=" . $array_singer_id . " WHERE `casi`=" . $db->dbescape( $singer['id'] );
					$db->sql_query( $sql );
					
					// Cap nhat cho video
					$sql = "UPDATE `" . $prefix . "_video` SET `casi`=" . $array_singer_id . " WHERE `casi`=" . $db->dbescape( $singer['id'] );
					$db->sql_query( $sql );
				}
			}
			
			// Neu thuc hien xong het module thi co nghia thuc hien xong cho ngon ngu
			if( sizeof( $didmod[$lang] ) == sizeof( $array_mod['mod'] ) )
			{
				$didlang[] = $lang;
			}
			
			break; // Chi chay mot vong lap
		}
		
		break; // Chi chay mot vong lap
	}
	
	// Kiem tra het chua neu het roi thi tra ve hoan thanh, nguoc lai xuat duong dan de tiep tuc
	if( sizeof( $didlang ) == sizeof( $array_lang_music_update ) )
	{
		$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );
	}
	else
	{
		// Xac dinh ngon ngu va module cho lan thuc hien tiep theo
		$next_lang = '';
		$next_mod = '';
		
		foreach( $array_lang_music_update as $lang => $array_mod )
		{
			if( ! in_array( $lang, $didlang ) )
			{
				foreach( $array_mod['mod'] as $module_info )
				{
					if( ! in_array( $module_info['module_data'], $didmod[$lang] ) )
					{
						$next_mod = $module_info['module_title'];
						break;
					}
				}
			
				$next_lang = $language_array[$lang]['name'];
				break;
			}
		}
		
		$message = sprintf( $lang_module['info_continue_singer'], $next_lang, $next_mod, ++ $time );
		$link = $nv_update_baseurl . "&didlang=" . nv_base64_encode( serialize( $didlang ) ) . "&didmod=" . nv_base64_encode( serialize( $didmod ) ) . "&loopcount=" . $loopcount. "&time=" . $time;
		$return = array( 'status' => 1, 'complete' => 0, 'next' => 0, 'link' => 'NO', 'lang' => 'NO', 'message' => $message, );
	}
	
	return $return;
}

function nv_up_dbtypeauthor()
{
	global $nv_update_baseurl, $db, $db_config, $old_module_version, $array_lang_music_update, $nv_Request, $lang_module, $language_array;
	$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );

	// Xac dinh URL
	$didlang = $nv_Request->get_string( 'didlang', 'get', '' );
	$didmod = $nv_Request->get_string( 'didmod', 'get', '' );
	$didlang = $didlang ? unserialize( nv_base64_decode( $didlang ) ) : array();
	$didmod = $didmod ? unserialize( nv_base64_decode( $didmod ) ) : array();
	$loopcount = $nv_Request->get_int( 'loopcount', 'get', 0 );
	$time = $nv_Request->get_int( 'time', 'get', 1 );
	
	// Thay doi kieu du lieu - Chi lam lan dau tien
	if( empty( $didlang ) and empty( $didmod ) and empty( $loopcount ) )
	{
		foreach( $array_lang_music_update as $lang => $array_mod )
		{
			foreach( $array_mod['mod'] as $module_info )
			{
				$prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
				
				$db->sql_query( "ALTER TABLE `" . $prefix . "` CHANGE `nhacsi` `nhacsi` varchar( 255 ) NOT NULL DEFAULT ''" ); // Bang nhac
				$db->sql_query( "ALTER TABLE `" . $prefix . "_video` CHANGE `nhacsi` `nhacsi` varchar( 255 ) NOT NULL DEFAULT ''" ); // Bang video
			}
		}
	}
	
	$loopcount ++;
	
	// Cap nhat lai ca si bang cach
	foreach( $array_lang_music_update as $lang => $array_mod )
	{
		if( in_array( $lang, $didlang ) )
		{
			continue; // Thuc hien roi thi bo qua
		}
		
		if( ! isset( $didmod[$lang] ) ) $didmod[$lang] = array(); // Tao bien rong neu khong ton tai
		
		foreach( $array_mod['mod'] as $module_info )
		{
			if( in_array( $module_info['module_data'], $didmod[$lang] ) )
			{
				$time = 1; // Set lai cho module lan 1
				continue; // Thuc hien roi thi bo qua
			}
			
			$prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
			
			// Moi lan cap nhat 50 nhac si
			$sql = "SELECT `id`, `tenthat` FROM `" . $prefix . "_author` WHERE `tenthat` LIKE '% ft. %' ORDER BY `id` DESC LIMIT 0,50";
			$resultLEV1 = $db->sql_query( $sql );
			
			if( ! $db->sql_numrows( $resultLEV1 ) )
			{
				// Khong con nhac si nao can xu ly nua thi luu vao bien thong tin
				$didmod[$lang][] = $module_info['module_data'];
			}
			else // Xu ly du lieu
			{
				while( $author = $db->sql_fetch_assoc( $resultLEV1 ) )
				{
					$author['tenthat'] = str_replace( array( ' FT. ', ' Ft. ', ' fT. ' ), array( ' ft. ', ' ft. ', ' ft. ' ), $author['tenthat'] );
					$author['tenthat'] = array_filter( array_unique( array_map( "trim", explode( " ft. ", $author['tenthat'] ) ) ) );
					
					$array_author_id = array();

					// Neu ton tai nhac si thu nhat thi xoa luon nhac si, nguoc lai thi cap nhat
					$sql = "SELECT `id` FROM `" . $prefix . "_author` WHERE `tenthat`=" . $db->dbescape( $author['tenthat'][0] ) . " LIMIT 1";
					$result = $db->sql_query( $sql );
					
					if( $db->sql_numrows( $result ) )
					{
						$db->sql_query( "DELETE FROM `" . $prefix . "_author` WHERE `id`=" . $author['id'] );
						$tmp = $db->sql_fetch_assoc( $result );
						$array_author_id[] = $tmp['id'];
					}
					else
					{
						$array_author_id[] = $author['id'];
						$db->sql_query( "UPDATE `" . $prefix . "_author` SET `tenthat`=" . $db->dbescape( $author['tenthat'][0] ) . ", `ten`=" . $db->dbescape( change_alias( $author['tenthat'][0] ) ) . " WHERE `id`=" . $author['id'] );
					}
					
					unset( $author['tenthat'][0] );
					
					foreach( $author['tenthat'] as $tenthat )
					{
						// Neu ton tai nhac si thi lay ID nguoc lai thi them nhac si moi
						$sql = "SELECT `id` FROM `" . $prefix . "_author` WHERE `tenthat`=" . $db->dbescape( $tenthat ) . " LIMIT 1";
						$result = $db->sql_query( $sql );
						
						if( $db->sql_numrows( $result ) )
						{
							$tmp = $db->sql_fetch_assoc( $result );
							$array_author_id[] = $tmp['id'];
						}
						else
						{
							$sql = "INSERT INTO `" . $prefix . "_author` ( `id`, `ten`, `tenthat`, `thumb`, `introduction`, `numsong`, `numvideo` ) VALUES ( NULL, " . $db->dbescape( change_alias( $tenthat ) ) . ", " . $db->dbescape( $tenthat ) . ", '', '', 0, 0 )";
							$array_author_id[] = $db->sql_query_insert_id( $sql );
						}
					}
					
					$array_author_id = $db->dbescape( implode( ",", $array_author_id ) );
					
					// Cap nhat cho bai hat
					$sql = "UPDATE `" . $prefix . "` SET `nhacsi`=" . $array_author_id . " WHERE `nhacsi`=" . $db->dbescape( $author['id'] );
					$db->sql_query( $sql );
					
					// Cap nhat cho video
					$sql = "UPDATE `" . $prefix . "_video` SET `nhacsi`=" . $array_author_id . " WHERE `nhacsi`=" . $db->dbescape( $author['id'] );
					$db->sql_query( $sql );
				}
			}
			
			// Neu thuc hien xong het module thi co nghia thuc hien xong cho ngon ngu
			if( sizeof( $didmod[$lang] ) == sizeof( $array_mod['mod'] ) )
			{
				$didlang[] = $lang;
			}
			
			break; // Chi chay mot vong lap
		}
		
		break; // Chi chay mot vong lap
	}
	
	// Kiem tra het chua neu het roi thi tra ve hoan thanh, nguoc lai xuat duong dan de tiep tuc
	if( sizeof( $didlang ) == sizeof( $array_lang_music_update ) )
	{
		$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );
	}
	else
	{
		// Xac dinh ngon ngu va module cho lan thuc hien tiep theo
		$next_lang = '';
		$next_mod = '';
		
		foreach( $array_lang_music_update as $lang => $array_mod )
		{
			if( ! in_array( $lang, $didlang ) )
			{
				foreach( $array_mod['mod'] as $module_info )
				{
					if( ! in_array( $module_info['module_data'], $didmod[$lang] ) )
					{
						$next_mod = $module_info['module_title'];
						break;
					}
				}
			
				$next_lang = $language_array[$lang]['name'];
				break;
			}
		}
		
		$message = sprintf( $lang_module['info_continue_singer'], $next_lang, $next_mod, ++ $time );
		$link = $nv_update_baseurl . "&didlang=" . nv_base64_encode( serialize( $didlang ) ) . "&didmod=" . nv_base64_encode( serialize( $didmod ) ) . "&loopcount=" . $loopcount. "&time=" . $time;
		$return = array( 'status' => 1, 'complete' => 0, 'next' => 0, 'link' => 'NO', 'lang' => 'NO', 'message' => $message, );
	}
	
	return $return;
}

function nv_up_dbsong()
{
	global $nv_update_baseurl, $db, $db_config, $old_module_version, $array_lang_music_update;
	$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );

	foreach( $array_lang_music_update as $lang => $array_mod )
	{
		foreach( $array_mod['mod'] as $module_info )
		{
			$table = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
			
			$db->sql_query( "ALTER TABLE `" . $table . "` ADD `is_official` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1: Chính thức, 0: Thành viên đăng' AFTER `hit`" );				
		}
	}
	
	return $return;
}

function nv_up_tagsong()
{
	global $nv_update_baseurl, $db, $db_config, $old_module_version, $array_lang_music_update;
	$return = array( 'status' => 1, 'complete' => 1, 'next' => 1, 'link' => 'NO', 'lang' => 'NO', 'message' => '', );

	// Xoa file thua
	@nv_deletefile( NV_ROOTDIR . "/modules/music/admin/fourcategory.php" );
	@nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/music/cat_tags.tpl" );

	foreach( $array_lang_music_update as $lang => $array_mod )
	{
		foreach( $array_mod['mod'] as $module_info )
		{
			$db->sql_query( "DROP TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'] . "_4category`" );				
		}
	}
	
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