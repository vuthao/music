<?php

/**
 * @Project NUKEVIET_MUSIC
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 9-8-2010 14:43
 */
if ( ! defined( 'NV_IS_MUSIC_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['video_list_comment'];
$contents = '' ;

// lay du lieu 
$now_page = $nv_Request->get_int( 'now_page', 'get', 0 );
$link = "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=commentvideo" ;

if (!$now_page) 
{
	$now_page = 1 ;
	$first_page = 0 ;
}
else 
{
	$first_page = ($now_page -1)*100;
}	


// tinh so trang
$num_page = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data."_comment_video" ;
$num = mysql_query($num_page);
$output = mysql_num_rows($num);
$ts = 1;
while ( $ts * 100 < $output ) {$ts ++ ;}

// ket qua
$xtpl = new XTemplate("comment_video.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('URL_DEL_BACK', $link);
$xtpl->assign('URL_DEL', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=delall&where=_comment_video");

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_comment_video ORDER BY ID DESC LIMIT ".$first_page.",100";
$result = mysql_query( $sql );

$link_del = "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=del";
$link_edit = "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=editcomment&where=video";
$link_active = "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=active&where=_comment_video&id=";

while($rs = $db->sql_fetchrow($result))
{	
	$body = substr($rs['body'], 0, 94) ;
	$xtpl->assign('id', $rs['id']);
	$xtpl->assign('body', $body);
	$xtpl->assign('name', $rs['name']);
	
	$videoname = getvideobyID( $rs['what'] );
	$xtpl->assign('song', $videoname['tname']);
	
	$class = ($i % 2) ? " class=\"second\"" : "";
	$xtpl->assign('class', $class);
	$xtpl->assign('URL_DEL_ONE', $link_del . "&where=_comment_video&id=" . $rs['id']);
	$xtpl->assign('URL_EDIT', $link_edit . "&id=" . $rs['id']);
	
	$str_ac = ($rs['active'] == 1) ? $lang_module['active_yes'] : $lang_module['active_no'];
	$xtpl->assign('active', $str_ac);
	$xtpl->assign('URL_ACTIVE', $link_active . $rs['id']);
	
	$xtpl->parse('main.row');
}

$xtpl->parse('main');
$contents .= $xtpl->text('main');
$contents .= "<div align=\"center\" style=\"width:300px;margin:0px auto 0px auto;\">\n ";
$contents .= new_page_admin( $ts, $now_page, $link);
$contents .= "</div>\n";

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");

?>