<?php

/**
 * @Project NUKEVIET MUSIC 4.X
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 26 Feb 2017 14:04:32 GMT
 */

if (!defined('NV_IS_MOD_MUSIC')) {
    die('Stop!!!');
}

/**
 * nv_theme_gird_albums()
 * 
 * @param mixed $array
 * @return
 */
function nv_theme_gird_albums($array)
{
    global $module_file, $lang_module, $lang_global, $module_info, $global_array_config, $module_upload, $op;

    $xtpl = new XTemplate('gird-albums.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('UNIQUEID', nv_genpass(6));

    foreach ($array as $row) {
        $row['resource_avatar'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['resource_avatar'];
        
        $xtpl->assign('ROW', $row);
        
        $num_singers = sizeof($row['singers']);
        if ($num_singers > $global_array_config['limit_singers_displayed']) {
            $xtpl->assign('VA_SINGERS', $global_array_config['various_artists']);
            
            foreach ($row['singers'] as $singer) {
                $xtpl->assign('SINGER', $singer);
                $xtpl->parse('main.loop.va_singer.loop');
            }
            
            $xtpl->parse('main.loop.va_singer');
        } elseif (!empty($row['singers'])) {
            $i = 0;
            foreach ($row['singers'] as $singer) {
                $i++;
                $xtpl->assign('SINGER', $singer);
                
                if ($i > 1) {
                    $xtpl->parse('main.loop.show_singer.loop.separate');
                }
                $xtpl->parse('main.loop.show_singer.loop');
            }
            $xtpl->parse('main.loop.show_singer');
        } else {
            $xtpl->assign('UNKNOW_SINGER', $global_array_config['unknow_singer']);
            $xtpl->parse('main.loop.no_singer');
        }
        
        $xtpl->parse('main.loop');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_list_songs()
 * 
 * @param mixed $array
 * @return
 */
function nv_theme_list_songs($array)
{
    global $module_file, $lang_module, $lang_global, $module_info, $global_array_config, $module_upload;

    $xtpl = new XTemplate('list-songs.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('UNIQUEID', nv_genpass(6));
    
    foreach ($array as $row) {
        $xtpl->assign('ROW', $row);
        
        $num_singers = sizeof($row['singers']);
        if ($num_singers > $global_array_config['limit_singers_displayed']) {
            $xtpl->assign('VA_SINGERS', $global_array_config['various_artists']);
            
            foreach ($row['singers'] as $singer) {
                $xtpl->assign('SINGER', $singer);
                $xtpl->parse('main.loop.va_singer.loop');
            }
            
            $xtpl->parse('main.loop.va_singer');
        } elseif (!empty($row['singers'])) {
            $i = 0;
            foreach ($row['singers'] as $singer) {
                $i++;
                $xtpl->assign('SINGER', $singer);
                
                if ($i > 1) {
                    $xtpl->parse('main.loop.show_singer.loop.separate');
                }
                $xtpl->parse('main.loop.show_singer.loop');
            }
            $xtpl->parse('main.loop.show_singer');
        } else {
            $xtpl->assign('UNKNOW_SINGER', $global_array_config['unknow_singer']);
            $xtpl->parse('main.loop.no_singer');
        }
        
        $xtpl->parse('main.loop');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_main()
 * 
 * @param mixed $content_albums
 * @param mixed $content_videos
 * @param mixed $content_singers
 * @param mixed $content_songs
 * @return
 */
function nv_theme_main($content_albums, $content_videos, $content_singers, $content_songs)
{
    global $module_file, $lang_module, $lang_global, $module_info, $global_array_config, $module_upload;
    
    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    
    $contents = array();
    
    if (!empty($content_albums)) {
        $xtpl->assign('ALBUMS_LINK', NV_MOD_FULLLINK_AMP . $module_info['alias']['list-albums']);
        $xtpl->assign('ALBUMS_HTML', nv_theme_gird_albums($content_albums));
        $xtpl->parse('albums');
        $contents[$global_array_config['home_albums_weight']] = $xtpl->text('albums');
    }
    
    if (!empty($content_singers)) {
        $xtpl->assign('SINGERS_LINK', NV_MOD_FULLLINK_AMP . $module_info['alias']['list-singers']);
        
        $i = 0;
        foreach ($content_singers as $singer) {
            $singer['resource_avatar'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $singer['resource_avatar'];
            
            $xtpl->assign('SINGER', $singer);
            
            if ($i++ % 9 == 0) {
                $xtpl->parse('singers.loop.x2');
            } else {
                $xtpl->parse('singers.loop.x1');
            }
            
            $xtpl->parse('singers.loop');
        }
        
        $xtpl->parse('singers');
        $contents[$global_array_config['home_singers_weight']] = $xtpl->text('singers');
    }
    
    if (!empty($content_songs)) {
        foreach ($content_songs as $row) {
            $row['resource_avatar'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['resource_avatar'];
            
            $xtpl->assign('ROW', $row);
            
            $num_singers = sizeof($row['singers']);
            if ($num_singers > $global_array_config['limit_singers_displayed']) {
                $xtpl->assign('VA_SINGERS', $global_array_config['various_artists']);
                
                foreach ($row['singers'] as $singer) {
                    $xtpl->assign('SINGER', $singer);
                    $xtpl->parse('songs.loop.va_singer.loop');
                }
                
                $xtpl->parse('songs.loop.va_singer');
            } elseif (!empty($row['singers'])) {
                $i = 0;
                foreach ($row['singers'] as $singer) {
                    $i++;
                    $xtpl->assign('SINGER', $singer);
                    
                    if ($i > 1) {
                        $xtpl->parse('songs.loop.show_singer.loop.separate');
                    }
                    $xtpl->parse('songs.loop.show_singer.loop');
                }
                $xtpl->parse('songs.loop.show_singer');
            } else {
                $xtpl->assign('UNKNOW_SINGER', $global_array_config['unknow_singer']);
                $xtpl->parse('songs.loop.no_singer');
            }
            
            $xtpl->parse('songs.loop');
        }
        
        $xtpl->parse('songs');
        $contents[$global_array_config['home_songs_weight']] = $xtpl->text('songs');
    }
    
    if (!empty($content_videos)) {
        $xtpl->parse('videos');
        $contents[$global_array_config['home_videos_weight']] = $xtpl->text('videos');
    }
    
    // Sắp xếp lại theo thứ tự cấu hình
    ksort($contents);
    return implode("\n", $contents);
}

function nv_theme_list_albums($array, $is_detail_cat = false, $generate_page)
{
    global $module_file, $lang_module, $lang_global, $module_info, $global_array_config;
    
    $xtpl = new XTemplate('list-albums.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    foreach ($array as $cat) {
        $xtpl->assign('CAT', $cat['cat']);
        $xtpl->assign('ALBUMS_HTML', nv_theme_gird_albums($cat['albums']));
        
        if (empty($is_detail_cat)) {
            $xtpl->assign('CAT_LINK', NV_MOD_FULLLINK_AMP . $module_info['alias']['list-albums'] . '/' . $cat['cat']['cat_alias'] . '-' . $global_array_config['code_prefix']['cat'] . $cat['cat']['cat_code']);
            $xtpl->parse('main.loopcat.cat_link');
        } else {
            $xtpl->parse('main.loopcat.cat_text');
        }
        
        $xtpl->parse('main.loopcat');
    }

    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_view_singer()
 * 
 * @param mixed $data_singer
 * @param mixed $request_tab
 * @param mixed $array_songs
 * @param mixed $array_videos
 * @param mixed $array_albums
 * @param mixed $generate_page
 * @return
 */
function nv_theme_view_singer($data_singer, $request_tab, $array_songs, $array_videos, $array_albums, $generate_page)
{
    global $module_file, $lang_module, $lang_global, $module_info, $global_array_config, $global_array_nation;
    
    $xtpl = new XTemplate('view-singer.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    
    $xtpl->assign('SINGER', $data_singer);
    
    // Hiển thị phần thông tin đầu
    if (!empty($global_array_config['view_singer_show_header'])) {
        $xtpl->assign('HEADER_HTML', nv_theme_view_singer_header($data_singer, $request_tab));
        $xtpl->parse('main.header');
    }
    
    // Xem tiểu sử
    if ($request_tab == 'profile') {
        $num_info_had = 0;
        if (!empty($data_singer['singer_nickname'])) {
            $num_info_had++;
            $xtpl->parse('main.profile.singer_nickname');
        }
        if (!empty($data_singer['singer_realname'])) {
            $num_info_had++;
            $xtpl->parse('main.profile.singer_realname');
        }
        if (!empty($data_singer['singer_hometown'])) {
            $num_info_had++;
            $xtpl->parse('main.profile.singer_hometown');
        }
        if (!empty($data_singer['singer_prize'])) {
            $num_info_had++;
            $xtpl->parse('main.profile.singer_prize');
        }
        if (!empty($data_singer['singer_info'])) {
            $num_info_had++;
            $xtpl->parse('main.profile.singer_info');
        }
        
        if (isset($global_array_nation[$data_singer['nation_id']])) {
            $num_info_had++;
            $xtpl->assign('NATION_NAME', $global_array_nation[$data_singer['nation_id']]['nation_name']);
            $xtpl->parse('main.profile.nation');
        }
        
        if (!empty($data_singer['singer_birthday']) and !empty($data_singer['singer_birthday_lev'])) {
            $num_info_had++;
            if ($data_singer['singer_birthday_lev'] == 3) {
                $format_date = 'd/m/Y';
            } elseif ($data_singer['singer_birthday_lev'] == 2) {
                $format_date = 'm/Y';
            } else {
                $format_date = 'Y';
            }
            $xtpl->assign('SINGER_BIRTHDAY', nv_date($format_date, $data_singer['singer_birthday']));
            $xtpl->parse('main.profile.singer_birthday');
        }
        
        if (empty($num_info_had)) {
            $xtpl->assign('EMPTY_MESSAGE', sprintf($lang_module['view_singer_empty_profile'], $data_singer['singer_name']));
            $xtpl->parse('main.profile.empty');
        }
        
        $xtpl->parse('main.profile');
    }
    
    if (!empty($array_albums)) {
        $xtpl->assign('ALBUM_HTML', nv_theme_gird_albums($array_albums));
        $xtpl->parse('main.albums');
    }
    
    if (!empty($array_songs)) {
        $xtpl->assign('SONG_HTML', nv_theme_list_songs($array_songs));
        $xtpl->parse('main.songs');
    }

    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_view_singer_header()
 * 
 * @param mixed $data_singer
 * @param mixed $request_tab
 * @return
 */
function nv_theme_view_singer_header($data_singer, $request_tab)
{
    global $module_file, $lang_module, $lang_global, $module_info, $module_upload, $global_array_config;
    
    $xtpl = new XTemplate('view-singer-header.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    
    $xtpl->assign('LINK_PROFILE_TAB', nv_get_view_singer_link($data_singer, true, 'profile'));
    $xtpl->assign('LINK_DEFAULT_TAB', nv_get_view_singer_link($data_singer));
    if (empty($request_tab)) {
        $xtpl->parse('main.active_default_tab');
    }
    
    // Các TAB
    foreach ($global_array_config['view_singer_tabs_alias'] as $tab_key => $tab_alias) {
        $xtpl->assign('TAB_TITLE', $lang_module['view_singer_tab_' . $tab_key]);
        $xtpl->assign('TAB_LINK', nv_get_view_singer_link($data_singer, true, $tab_key));
        
        if ($request_tab == $tab_key) {
            $xtpl->parse('main.tabloop.active');
        }
        
        $xtpl->parse('main.tabloop');
    }
    
    $data_singer['resource_avatar'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data_singer['resource_avatar'];
    $data_singer['resource_cover'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data_singer['resource_cover'];
    $xtpl->assign('SINGER', $data_singer);
    
    if (!empty($data_singer['singer_info'])) {
        $xtpl->assign('HEADTEXT', nv_clean60(strip_tags($data_singer['singer_info']), $global_array_config['view_singer_headtext_length']));
        $xtpl->parse('main.headtext');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

