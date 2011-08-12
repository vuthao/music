<?php

/**
 * @Project NUKEVIET 3.0
 * @Author Phan Tan Dung (phantandung@gmail.com)
 * @Createdate Dec 3, 2010  11:32:04 AM 
 */

if ( ! defined( 'NV_IS_MOD_MUSIC' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$category = get_category() ;
$allsinger = getallsinger();
    
// xu li
$type = isset( $array_op[1] ) ?  $array_op[1]  : 'name';
$now_page = isset( $array_op[3] ) ?  $array_op[3]  : 1;
$key = isset( $array_op[2] ) ?  $array_op[2]  : '-';

// xu li thong tin submit
if ( ( $nv_Request->get_int( 'block_sed', 'post', 0 ) == 1 ) or ( $nv_Request->isset_request( 'q', 'get' ) ) )
{
	$type = filter_text_input( 'type', 'post', 'name' );
	$key =  ( filter_text_input( 'key', 'post', '' ) == '' ) ? '-' : change_alias( filter_text_input( 'key', 'post', '' ) );
	$q = filter_text_input( 'key', 'post', '' );
	
	if( ( $key == "-" ) and ( $nv_Request->isset_request( 'q', 'get' ) ) )
	{
		$q = filter_text_input( 'q', 'get', '' );
		$key = ( filter_text_input( 'q', 'get', '' ) == '' ) ? '-' : change_alias( filter_text_input( 'q', 'get', '' ) );
	}
	
	$nv_Request->set_session( 'music_search_type', $type );
	$nv_Request->set_session( 'music_search_key', $q );
	
	if ( $type == 'album' )
	{
		Header( "Location: " . nv_url_rewrite ( $main_header_URL . "=album/id/" . $key, true ) ) ;  
		die();	
	}
	
	if ( $type == 'playlist' )
	{
		Header( "Location: " . nv_url_rewrite ( $main_header_URL . "=allplaylist/id/" . $key, true ) ) ;  
		die();	
	}
	
	Header( "Location: " . nv_url_rewrite ( $main_header_URL . "=search/" . $type . "/" . $key, true ) ) ;  
	die();
}

$g_array = array();
$g_array['type'] = $type;
$g_array['key'] = $key;

$link = $mainURL . "=search/" . $type . "/" . $key ;
$data = '';

if ( $type == "name" )
{
	$data = "WHERE `ten` LIKE '%". $db->dblikeescape( $key ) ."%'";
	$video = "WHERE `name` LIKE '%". $db->dblikeescape( $key ) ."%'";
}
elseif ( $type == "singer" )
{
	$data = "WHERE `casi` LIKE '%". $db->dblikeescape( $key ) ."%'";
	$video = "WHERE `casi` LIKE '%". $db->dblikeescape( $key ) ."%'";
}
elseif ( $type == "category" )
{
	$data = "WHERE `theloai` =". $key ;
	$video = "WHERE `theloai` =". $key ;
}
elseif ( $type == "upload" )
{
	$data = "WHERE `upboi` =\"". $key."\"" ;
	$video = "WHERE `id` = 0" ;
}
// xu li du lieu
if ( $now_page == 1) 
{
	$first_page = 0 ;
}
else 
{
	$first_page = ($now_page -1)*20;
}	

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . " " . $data . " AND `active` = 1 ORDER BY id DESC LIMIT " . $first_page . ",20";
$sqlnum = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . " " . $data . " AND `active` = 1 ";

// tinh so trang
$num = $db->sql_query( $sqlnum );
$output = $db->sql_numrows( $num );
$ts = 1;
while ( $ts * 20 < $output ) {$ts ++ ;}

// ket qua
$result = $db->sql_query( $sql );

$g_array['num'] = $output;
$g_array['now_page'] = $now_page;

$array_song = array();
$array_album = array();
$array_video = array();

if( $now_page == 1 )
{
	$sqlvideo = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_video " . $video . " AND `active` = 1 ORDER BY id DESC LIMIT 0,3";
	$sqlalbum = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_album " . $video . " AND `active` = 1 ORDER BY id DESC LIMIT 0,4";
		
	$resultvideo = $db->sql_query( $sqlvideo );
	$resultalbum = $db->sql_query( $sqlalbum );
	
	if ( $db->sql_numrows( $resultvideo ) > 0 )
	{
		while( $rsv = $db->sql_fetchrow( $resultvideo ) )
		{
			$array_video[] = array(
				"videoname" => $rsv['tname'],  //
				"videosinger" => $allsinger[$rsv['casi']],  //
				"thumb" => $rsv['thumb'],  //
				"videoview" => $mainURL . "=viewvideo/" .$rsv['id']. "/" . $rsv['name'],  //
				"s_video" => $mainURL . "=searchvideo/singer/" . $rsv['casi']  //
			);
		}
	}
	if ( $db->sql_numrows( $resultalbum ) > 0 )
	{
		while( $rsa = $db->sql_fetchrow( $resultalbum ) )
		{
			$array_album[] = array(
				"albumname" => $rsa['tname'],  //
				"albumsinger" => $allsinger[$rsa['casi']],  //
				"thumb" => $rsa['thumb'],  //
				"albumview" => $mainURL . "=listenlist/" .$rsa['id']. "/" . $rsa['name'],  //
				"url_search_singer" => $mainURL . "=search/singer/" . $rsa['casi']  //
			);
		}
	}
}

while( $row = $db->sql_fetchrow( $result ) )
{
	$checkhit = explode ( "-", $row['hit'] );
	$checkhit = $checkhit[0];
	if ( $checkhit >= 20 )
	{
		$checkhit = true;
	}
	else
	{
		$checkhit = false;
	}
	
	$array_song[] = array(
		"id" => $row['id'],  //
		"name" => $row['tenthat'],  //
		"singer" => $allsinger[$row['casi']],  //
		"upload" => $row['upboi'],  //
		"category" => $category[$row['theloai']],  //
		"view" => $row['numview'],  //
		"bitrate" => $row['bitrate'],  //
		"size" => $row['size'],  //
		"duration" => $row['duration'],  //
		"url_listen" => $mainURL . "=listenone/".$row['id'] . "/" . $row['ten'],  //
		"url_search_singer" => $mainURL . "=search/singer/" . $row['casi'],  //
		"url_search_category" => $mainURL . "=search/category/" . $row['theloai'],  //
		"url_search_upload" => $mainURL . "=search/upload/" . $row['upboi'],  //
		"checkhit" => $checkhit  //
	);
}

$contents = nv_music_search( $g_array, $array_song, $array_album, $array_video );
$contents .= new_page( $ts, $now_page, $link);

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>