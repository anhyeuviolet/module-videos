<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */
if (! defined('NV_IS_MOD_VIDEOS'))
    die('Stop!!!');

function viewcat_grid_new($array_catpage, $catid, $generate_page)
{
    global $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_cat, $global_array_cat, $catid, $page;
    
    $xtpl = new XTemplate('viewcat_grid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('IMGWIDTH', $module_config[$module_name]['homewidth']);
    $xtpl->assign('IMGHEIGHT', $module_config[$module_name]['homeheight']);
    $xtpl->assign('MODULE_NAME', $module_file);
    $per_line = 24 / $module_config[$module_name]['per_line'];
    $xtpl->assign('PER_LINE', $per_line);
    
    if (($global_array_cat[$catid]['viewdescription'] and $page == 1) or $global_array_cat[$catid]['viewdescription'] == 2) {
        $xtpl->assign('CONTENT', $global_array_cat[$catid]);
        if ($global_array_cat[$catid]['image']) {
            $xtpl->assign('HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $global_array_cat[$catid]['image']);
            $xtpl->parse('main.viewdescription.image');
        }
        $xtpl->parse('main.viewdescription');
    }
    
    if (! empty($catid)) {
        $xtpl->assign('CAT', $global_array_cat[$catid]);
        $xtpl->parse('main.cattitle');
    }
    
    foreach ($array_catpage as $array_row_i) {
        $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
        $array_row_i['publtime'] = humanTiming($array_row_i['publtime']);
        $xtpl->clear_autoreset();
        $array_row_i['title_cut'] = nv_clean60($array_row_i['title'], $module_config[$module_name]['titlecut'], true);
        $xtpl->assign('CONTENT', $array_row_i);
        
        if (defined('NV_IS_MODADMIN')) {
            $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
            $xtpl->parse('main.viewcatloop.adminlink');
        }
        if ($array_row_i['imghome'] != '') {
            $xtpl->assign('HOMEIMG1', $array_row_i['imghome']);
            $xtpl->assign('HOMEIMGALT1', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['title']);
            $xtpl->parse('main.viewcatloop.image');
        }
        
        if ($newday >= NV_CURRENTTIME) {
            $xtpl->parse('main.viewcatloop.newday');
        }
        
        if ($array_row_i['hitstotal'] > 0) {
            $xtpl->parse('main.viewcatloop.hitstotal');
        }
        
        $xtpl->set_autoreset();
        $xtpl->parse('main.viewcatloop');
    }
    
    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function viewcat_page_new($array_catpage, $generate_page)
{
    global $global_array_cat, $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_cat, $catid, $page;
    
    $xtpl = new XTemplate('viewcat_page.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);
    
    if (($global_array_cat[$catid]['viewdescription'] and $page == 1) or $global_array_cat[$catid]['viewdescription'] == 2) {
        $xtpl->assign('CONTENT', $global_array_cat[$catid]);
        if ($global_array_cat[$catid]['image']) {
            $xtpl->assign('HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $global_array_cat[$catid]['image']);
            $xtpl->parse('main.viewdescription.image');
        }
        $xtpl->parse('main.viewdescription');
    }
    
    foreach ($array_catpage as $array_row_i) {
        $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
        $array_row_i['publtime'] = humanTiming($array_row_i['publtime']);
        $array_row_i['listcatid'] = explode(',', $array_row_i['listcatid']);
        $num_cat = sizeof($array_row_i['listcatid']);
        $array_row_i['title_cut'] = nv_clean60($array_row_i['title'], $module_config[$module_name]['titlecut'], true);
        
        $n = 1;
        foreach ($array_row_i['listcatid'] as $listcatid) {
            $listcat = array(
                'title' => $global_array_cat[$listcatid]['title'],
                "link" => $global_array_cat[$listcatid]['link']
            );
            $xtpl->assign('CAT', $listcat);
            (($n < $num_cat) ? $xtpl->parse('main.viewcatloop.cat.comma') : '');
            $xtpl->parse('main.viewcatloop.cat');
            ++ $n;
        }
        $xtpl->clear_autoreset();
        $xtpl->assign('CONTENT', $array_row_i);
        
        if (defined('NV_IS_MODADMIN')) {
            $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
            $xtpl->parse('main.viewcatloop.news.adminlink');
        }
        
        if ($array_row_i['imghome'] != '') {
            $xtpl->assign('HOMEIMG1', $array_row_i['imghome']);
            $xtpl->assign('HOMEIMGALT1', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['title']);
            $xtpl->parse('main.viewcatloop.news.image');
        }
        
        if ($newday >= NV_CURRENTTIME) {
            $xtpl->parse('main.viewcatloop.news.newday');
        }
        
        if ($array_row_i['hitstotal'] > 0) {
            $xtpl->parse('main.viewcatloop.news.hitstotal');
        }
        
        $xtpl->set_autoreset();
        $xtpl->parse('main.viewcatloop.news');
    }
    $xtpl->parse('main.viewcatloop');
    
    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function viewsubcat_main($viewcat, $array_cat)
{
    global $module_name, $module_file, $global_array_cat, $lang_module, $module_config, $module_info;
    
    $xtpl = new XTemplate($viewcat . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('MODULE_NAME', $module_file);
    $xtpl->assign('IMGWIDTH', $module_config[$module_name]['homewidth']);
    $xtpl->assign('IMGHEIGHT', $module_config[$module_name]['homeheight']);
    $per_line = 24 / $module_config[$module_name]['per_line'];
    $xtpl->assign('PER_LINE', $per_line);
    
    // Hien thi cac chu de con
    foreach ($array_cat as $key => $array_row_i) {
        if (isset($array_cat[$key]['content'])) {
            $array_row_i['rss'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $module_info['alias']['rss'] . "/" . $array_row_i['alias'];
            $xtpl->assign('CAT', $array_row_i);
            $catid = intval($array_row_i['catid']);
            
            if ($array_row_i['subcatid'] != '') {
                $_arr_subcat = explode(',', $array_row_i['subcatid']);
                foreach ($_arr_subcat as $catid_i) {
                    if ($global_array_cat[$catid_i]['inhome'] == 1) {
                        $xtpl->assign('SUBCAT', $global_array_cat[$catid_i]);
                        $xtpl->parse('main.listcat.subcatloop');
                    }
                }
            }
            
            foreach ($array_cat[$key]['content'] as $array_row_i) {
                $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
                
                $array_row_i['publtime'] = humanTiming($array_row_i['publtime']);
                $array_row_i['title_cut'] = nv_clean60($array_row_i['title'], $module_config[$module_name]['titlecut'], true);
                
                if ($newday >= NV_CURRENTTIME) {
                    $xtpl->parse('main.listcat.loop.newday');
                }
                $xtpl->assign('CONTENT', $array_row_i);
                
                if ($array_row_i['imghome'] != "") {
                    $xtpl->assign('HOMEIMG', $array_row_i['imghome']);
                    $xtpl->assign('HOMEIMGALT', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['title']);
                    $xtpl->parse('main.listcat.loop.image');
                }
                
                if (defined('NV_IS_MODADMIN')) {
                    $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
                    $xtpl->parse('main.listcat.loop.adminlink');
                }
                
                if ($array_row_i['hitstotal'] > 0) {
                    $xtpl->parse('main.listcat.loop.hitstotal');
                }
                
                $xtpl->set_autoreset();
                $xtpl->parse('main.listcat.loop');
            }
            $xtpl->parse('main.listcat');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function detail_theme($news_contents, $href_vid, $array_keyword, $related_new_array, $related_array, $content_comment, $array_user_playlist)
{
    global $global_config, $module_info, $lang_module, $module_name, $module_file, $module_config, $lang_global, $user_info, $admin_info, $client_info;
    
    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG_GLOBAL', $lang_global);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
	if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/'. $module_file . '/jwplayer/')) {
		$template = $global_config['module_theme'];
	} else {
		$template = 'default';
	}
    $per_line = 24 / $module_config[$module_name]['per_line'];
    $xtpl->assign('PER_LINE', $per_line);

    $xtpl->assign('TEMPLATE', $template);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('MODULE_FILE', $module_file);
    
    $xtpl->assign('IMGWIDTH', $module_config[$module_name]['homewidth']);
    $xtpl->assign('IMGHEIGHT', $module_config[$module_name]['homeheight']);
    
    $news_contents['addtime'] = nv_date('d/m/Y h:i:s', $news_contents['addtime']);
    $news_contents['publtime'] = humanTiming($news_contents['publtime']);
    
    $xtpl->assign('RAND_SS', rand(1000, 9999));
    $xtpl->assign('NEWSID', $news_contents['id']);
    $xtpl->assign('NEWSCHECKSS', $news_contents['newscheckss']);
    $xtpl->assign('DETAIL', $news_contents);
    $xtpl->assign('SELFURL', $client_info['selfurl']);
    
    if (defined('NV_IS_MODADMIN') and (empty($module_config[$module_name]['jwplayer_license']) or ! isset($module_config[$module_name]['jwplayer_license']))) {
        $xtpl->assign('SETTING_LINKS', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=setting#jwplayer_license');
        $xtpl->parse('main.no_jwp_lic_admin');
    } elseif (empty($module_config[$module_name]['jwplayer_license']) or ! isset($module_config[$module_name]['jwplayer_license'])) {
        $xtpl->parse('main.no_jwp_lic');
    }
    
    if (! empty($module_config[$module_name]['jwplayer_logo_file']) and file_exists(NV_ROOTDIR . '/' . $module_config[$module_name]['jwplayer_logo_file'])) {
        $lu = strlen(NV_BASE_SITEURL);
        $module_config[$module_name]['jwplayer_logo_file'] = NV_BASE_SITEURL . $module_config[$module_name]['jwplayer_logo_file'];
    }
    $module_config[$module_name]['site_name'] = $global_config['site_name'];
    $xtpl->assign('VIDEO_CONFIG', $module_config[$module_name]);
    if ($news_contents['allowed_send'] == 1) {
        $xtpl->assign('URL_SENDMAIL', $news_contents['url_sendmail']);
        $xtpl->parse('main.allowed_send');
    }
    if ($news_contents['hitstotal'] > 0) {
        $xtpl->parse('main.hitstotal');
    }
    if (! empty($href_vid)) {
        if ($module_config[$module_name]['jwplayer_logo'] > 0 and ! empty($module_config[$module_name]['jwplayer_logo_file'])) {
            $xtpl->parse('main.jwplayer.player_logo');
        }
        if ($module_config[$module_name]['jwplayer_sharing'] > 0 and ! empty($module_config[$module_name]['jwplayer_sharingsite'])) {
            $module_config[$module_name]['jwplayer_sharingsite'] = explode(',', $module_config[$module_name]['jwplayer_sharingsite']);
            foreach ($module_config[$module_name]['jwplayer_sharingsite'] as $_site) {
                
                $xtpl->assign('SSITE', $_site);
                $xtpl->parse('main.jwplayer.player_sharing.loop');
            }
            $xtpl->parse('main.jwplayer.player_sharing');
        }
        if (! defined('JWPLAYER_JS')) {
            define('JWPLAYER_JS', true);
            $xtpl->parse('main.jwplayer_js');
        }
        $xtpl->parse('main.jwplayer');
        $xtpl->parse('main.vid_jw_content');
    }
    
    if ($news_contents['allowed_save'] == 1) {
        $xtpl->assign('URL_SAVEFILE', $news_contents['url_savefile']);
        $xtpl->parse('main.allowed_save');
    }
    if ($module_config[$module_name]['fb_comm'] == 1) {
        if (empty($meta_property['fb:admins']) and $module_config[$module_name]['fb_admin']) {
            global $meta_property;
            $meta_property['fb:admins'] = $module_config[$module_name]['fb_admin'];
        }
        $xtpl->parse('main.fb_comment');
    }
    
    if ($news_contents['allowed_rating'] == 1) {
        $xtpl->assign('LANGSTAR', $news_contents['langstar']);
        $xtpl->assign('STRINGRATING', $news_contents['stringrating']);
        $xtpl->assign('NUMBERRATING', $news_contents['numberrating']);
        
        if ($news_contents['disablerating'] == 1) {
            $xtpl->parse('main.allowed_rating.disablerating');
        }
        
        if ($news_contents['numberrating'] >= $module_config[$module_name]['allowed_rating_point']) {
            $xtpl->parse('main.allowed_rating.data_rating');
        }
        
        $xtpl->parse('main.allowed_rating');
    }
    
    if (! empty($news_contents['bodyhtml'])) {
        $xtpl->parse('main.bodyhtml');
    }
    
    if (! empty($news_contents['post_name'])) {
        $xtpl->parse('main.post_name');
    }
    
    if (! empty($news_contents['author']) or ! empty($news_contents['source'])) {
        if (! empty($news_contents['author'])) {
            $xtpl->parse('main.author.name');
        }
        
        if (! empty($news_contents['source'])) {
            $xtpl->parse('main.author.source');
        }
        $xtpl->parse('main.author');
    }
    
    if ($news_contents['copyright'] == 1) {
        if (! empty($module_config[$module_name]['copyright'])) {
            $xtpl->assign('COPYRIGHT', $module_config[$module_name]['copyright']);
            $xtpl->parse('main.copyright');
        }
    }
    
    if (! empty($array_keyword)) {
        $t = sizeof($array_keyword) - 1;
        foreach ($array_keyword as $i => $value) {
            $xtpl->assign('KEYWORD', $value['keyword']);
            $xtpl->assign('LINK_KEYWORDS', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . urlencode($value['alias']));
            $xtpl->assign('SLASH', ($t == $i) ? '' : ', ');
            $xtpl->parse('main.keywords.loop');
        }
        $xtpl->parse('main.keywords');
    }
    
    if (defined('NV_IS_MODADMIN')) {
        $xtpl->assign('ADMINLINK', nv_link_edit_page($news_contents['id']) . ' ' . nv_link_delete_page($news_contents['id'], 1));
        $xtpl->parse('main.adminlink');
    }
    
    if ($module_config[$module_name]['socialbutton']) {
        global $meta_property;
        
        if (! empty($module_config[$module_name]['facebookappid'])) {
            $meta_property['fb:app_id'] = $module_config[$module_name]['facebookappid'];
            $meta_property['og:locale'] = (NV_LANG_DATA == 'vi') ? 'vi_VN' : 'en_US';
        }
        $xtpl->parse('main.socialbutton');
    }
    
    if (! empty($related_new_array) or ! empty($related_array)) {
        if (! empty($related_new_array)) {
            foreach ($related_new_array as $key => $related_new_array_i) {
                $related_new_array_i['time'] = humanTiming($related_new_array_i['time']);
				$related_new_array_i['title_cut'] = nv_clean60($related_new_array_i['title'], $module_config[$module_name]['titlecut'], true);
                $xtpl->assign('RELATED_NEW', $related_new_array_i);
                if ($related_new_array_i['imghome'] != ''){
                    $xtpl->parse('main.others.related_new.loop.image');
                }
                $xtpl->parse('main.others.related_new.loop');
            }
            unset($key);
            $xtpl->parse('main.others.related_new');
        }
        
        if (! empty($related_array)) {
            foreach ($related_array as $related_array_i) {
                $newday = $related_array_i['time'] + (86400 * $related_array_i['newday']);
                if ($newday >= NV_CURRENTTIME) {
                    $xtpl->parse('main.others.related.loop.newday');
                }
				$related_array_i['title_cut'] = nv_clean60($related_array_i['title'], $module_config[$module_name]['titlecut'], true);
                $related_array_i['time'] = humanTiming($related_array_i['time']);
                $xtpl->assign('RELATED', $related_array_i);
                
                if ($related_array_i['imghome'] != '') {
                    $xtpl->parse('main.others.related.loop.image');
                }
                $xtpl->parse('main.others.related.loop');
            }
            $xtpl->parse('main.others.related');
        }
        $xtpl->parse('main.others');
    }
    
    if (! empty($content_comment)) {
        $xtpl->assign('CONTENT_COMMENT', $content_comment);
        $xtpl->parse('main.comment');
    }
    
    if ($news_contents['status'] != 1) {
        $xtpl->parse('main.no_public');
    }
    
    if (defined('NV_IS_USER')) {
        $xtpl->parse('main.plist_is_user');
        $xtpl->parse('main.favorite_is_user');
    } else {
        $xtpl->parse('main.not_user');
    }
    $array_reports = array(
        1 => $lang_module['report_notplay'],
        2 => $lang_module['report_content'],
        3 => $lang_module['report_copyright'],
        4 => $lang_module['report_other']
    );
    foreach ($array_reports as $value => $report) {
        
        $xtpl->assign('REPORT', array(
            'value' => $value,
            'title' => $report
        ));
        $xtpl->parse('main.report_videos');
    }
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function no_permission()
{
    global $module_info, $module_file, $lang_module;
    
    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('NO_PERMISSION', $lang_module['no_permission']);
    $xtpl->parse('no_permission');
    return $xtpl->text('no_permission');
}

function playlist_theme($playlist_array, $playlist_info, $playlist_id, $player)
{
    global $global_config, $lang_module, $module_info, $module_name, $module_file, $module_config, $user_info;
    
    $xtpl = new XTemplate('playlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('EXT_URL', $global_config['rewrite_endurl']);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('PLAYLIST_ID', $playlist_id);
    $xtpl->assign('PLAYER', $player);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);
    
    if (! empty($module_config[$module_name]['jwplayer_logo_file']) and file_exists(NV_ROOTDIR . '/' . $module_config[$module_name]['jwplayer_logo_file'])) {
        $lu = strlen(NV_BASE_SITEURL);
        $module_config[$module_name]['jwplayer_logo_file'] = NV_BASE_SITEURL . $module_config[$module_name]['jwplayer_logo_file'];
    }
    $module_config[$module_name]['site_name'] = $global_config['site_name'];
    $xtpl->assign('VIDEO_CONFIG', $module_config[$module_name]);
    
    if (! empty($playlist_info)) {
        if (isset($playlist_info['add_time'])) {
            $playlist_info['add_time'] = nv_date('H:i d/m/Y', $playlist_info['add_time']);
        }
        $xtpl->assign('PLAYLIST_INFO', $playlist_info);
        if (! empty($playlist_info['add_time'])) {
            $xtpl->parse('main.playlist_info.time');
        }
        if (! empty($playlist_info['description'])) {
            $xtpl->parse('main.playlist_info.description');
        }
        
        if (isset($playlist_info['hitstotal']) and $playlist_info['hitstotal'] > 0) {
            $xtpl->parse('main.playlist_info.viewed');
        }
        $xtpl->parse('main.playlist_info');
    }
    
    if (! empty($playlist_array)) // There is playlist or video in playlist
{
        if ($playlist_id > 0) // Single playlist
{
            if ($playlist_info['status'] == 1) // playlist approved
{
                if ($playlist_info['private_mode'] != 1 or $playlist_info['userid'] == $user_info['userid']) // playlist is NOT private
{
                    if (empty($module_config[$module_name]['jwplayer_license']) and defined('NV_IS_MODADMIN')) {
                        $xtpl->assign('SETTING_LINKS', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=setting#jwplayer_license');
                        $xtpl->parse('main.no_jwp_lic_admin');
                    } elseif (empty($module_config[$module_name]['jwplayer_license']) or ! isset($module_config[$module_name]['jwplayer_license'])) {
                        $xtpl->parse('main.no_jwp_lic');
                    }
                    if ($module_config[$module_name]['jwplayer_logo'] > 0 and ! empty($module_config[$module_name]['jwplayer_logo_file'])) {
                        $xtpl->parse('main.player.player_logo');
                    }
                    if ($module_config[$module_name]['jwplayer_sharing'] > 0 and ! empty($module_config[$module_name]['jwplayer_sharingsite'])) {
                        $module_config[$module_name]['jwplayer_sharingsite'] = explode(',', $module_config[$module_name]['jwplayer_sharingsite']);
                        foreach ($module_config[$module_name]['jwplayer_sharingsite'] as $_site) {
                            
                            $xtpl->assign('SSITE', $_site);
                            $xtpl->parse('main.player.player_sharing.loop');
                        }
                        $xtpl->parse('main.player.player_sharing');
                    }
                    if (! defined('JWPLAYER_JS')) {
                        define('JWPLAYER_JS', true);
                        $xtpl->parse('main.jwplayer_js');
                    }
                    $xtpl->parse('main.player');
                } else {
                    $xtpl->parse('main.playlist_is_private');
                }
            } elseif ($playlist_info['status'] == 2) // Playlist is pending
{
                $xtpl->parse('main.pending_playlist');
            }
        } else // List of playlists
{
            foreach ($playlist_array as $playlist_array_i) {
                $xtpl->assign('PLAYLIST_LOOP', $playlist_array_i);
                if ($playlist_array_i['publtime'] > 0) {
                    $xtpl->assign('DATE', date('d/m/Y', $playlist_array_i['publtime']));
                    $xtpl->parse('main.playlist_loop.publtime');
                }
                
                if (! empty($playlist_array_i['num_items'])) {
                    $xtpl->parse('main.playlist_loop.num_items');
                }
                
                if (! empty($playlist_array_i['src'])) {
                    $xtpl->parse('main.playlist_loop.homethumb');
                }
                
                if (defined('NV_IS_MODADMIN')) {
                    $xtpl->assign('ADMINLINK', nv_link_edit_playlist($playlist_array_i['id'])); // Go to ACP to delete playlist
                    $xtpl->parse('main.playlist_loop.adminlink');
                }
                $xtpl->parse('main.playlist_loop');
            }
        }
    } else // No video or Playlist
{
        if ($playlist_id > 0) {
            $xtpl->parse('main.no_video_inlist');
        } else {
            $xtpl->parse('main.no_playlist_inlist');
        }
    }
    
    if (! empty($playlist_other_array)) {
        foreach ($playlist_other_array as $playlist_other_array_i) {
            $playlist_other_array_i['publtime'] = nv_date('d/m/Y', $playlist_other_array_i['publtime']);
            
            $xtpl->assign('PLAYLIST_OTHER', $playlist_other_array_i);
            $xtpl->parse('main.other.loop');
        }
        $xtpl->parse('main.other');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function sendmail_themme($sendmail)
{
    global $module_info, $module_file, $global_config, $lang_module, $lang_global;
    
    $xtpl = new XTemplate('sendmail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('SENDMAIL', $sendmail);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('GFX_NUM', NV_GFX_NUM);
    
    if ($global_config['gfx_chk'] > 0) {
        $xtpl->assign('CAPTCHA_REFRESH', $lang_global['captcharefresh']);
        $xtpl->assign('CAPTCHA_REFR_SRC', NV_BASE_SITEURL . NV_FILES_DIR . '/images/refresh.png');
        $xtpl->assign('N_CAPTCHA', $lang_global['securitycode']);
        $xtpl->assign('GFX_WIDTH', NV_GFX_WIDTH);
        $xtpl->assign('GFX_HEIGHT', NV_GFX_HEIGHT);
        $xtpl->parse('main.content.captcha');
    }
    
    $xtpl->parse('main.content');
    
    if (! empty($sendmail['result'])) {
        $xtpl->assign('RESULT', $sendmail['result']);
        $xtpl->parse('main.result');
        
        if ($sendmail['result']['check'] == true) {
            $xtpl->parse('main.close');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function news_print($result)
{
    global $module_info, $module_file, $lang_module;
    
    $xtpl = new XTemplate('print.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('CONTENT', $result);
    $xtpl->assign('LANG', $lang_module);
    
    if (! empty($result['image']['width'])) {
        if ($result['image']['position'] == 1) {
            if (! empty($result['image']['note'])) {
                $xtpl->parse('main.image.note');
            }
            
            $xtpl->parse('main.image');
        } elseif ($result['image']['position'] == 2) {
            if ($result['image']['note'] > 0) {
                $xtpl->parse('main.imagefull.note');
            }
            $xtpl->parse('main.imagefull');
        }
    }
    
    if ($result['copyright'] == 1) {
        $xtpl->parse('main.copyright');
    }
    
    if (! empty($result['author']) or ! empty($result['source'])) {
        if (! empty($result['author'])) {
            $xtpl->parse('main.author.name');
        }
        
        if (! empty($result['source'])) {
            $xtpl->parse('main.author.source');
        }
        $xtpl->parse('main.author');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

// Search
function search_theme($key, $check_num, $date_array, $array_cat_search)
{
    global $module_name, $module_info, $module_file, $lang_module, $module_name;
    
    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('BASE_URL_SITE', NV_BASE_SITEURL . 'index.php');
    $xtpl->assign('TO_DATE', $date_array['to_date']);
    $xtpl->assign('FROM_DATE', $date_array['from_date']);
    $xtpl->assign('KEY', $key);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('OP_NAME', 'search');
    
    foreach ($array_cat_search as $search_cat) {
        $xtpl->assign('SEARCH_CAT', $search_cat);
        $xtpl->parse('main.search_cat');
    }
    
    for ($i = 0; $i <= 5; ++ $i) {
        if ($check_num == $i) {
            $xtpl->assign('CHECK' . $i, 'selected=\'selected\'');
        } else {
            $xtpl->assign('CHECK' . $i, '');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function search_result_theme($key, $numRecord, $per_pages, $page, $array_content, $catid)
{
    global $module_file, $module_info, $lang_module, $module_name, $global_array_cat, $module_config, $global_config;
    
    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('KEY', $key);
    $xtpl->assign('IMG_WIDTH', $module_config[$module_name]['homewidth']);
    $xtpl->assign('TITLE_MOD', $lang_module['search_modul_title']);
    
    if (! empty($array_content)) {
        foreach ($array_content as $value) {
            $catid_i = $value['catid'];
            
            $xtpl->assign('LINK', $global_array_cat[$catid_i]['link'] . '/' . $value['alias'] . "-" . $value['id'] . $global_config['rewrite_exturl']);
            $xtpl->assign('TITLEROW', strip_tags(BoldKeywordInStr($value['title'], $key)));
            $xtpl->assign('CONTENT', BoldKeywordInStr($value['hometext'], $key) . "...");
            $xtpl->assign('TIME', date('d/m/Y h:i:s A', $value['publtime']));
            $xtpl->assign('AUTHOR', BoldKeywordInStr($value['author'], $key));
            $xtpl->assign('SOURCE', BoldKeywordInStr(GetSourceNews($value['sourceid']), $key));
            
            if (! empty($value['homeimgfile'])) {
                $xtpl->assign('IMG_SRC', $value['homeimgfile']);
                $xtpl->parse('results.result.result_img');
            }
            
            $xtpl->parse('results.result');
        }
    }
    
    if ($numRecord == 0) {
        $xtpl->assign('KEY', $key);
        $xtpl->assign('INMOD', $lang_module['search_modul_title']);
        $xtpl->parse('results.noneresult');
    }
    
    if ($numRecord > $per_pages) // show pages
{
        $url_link = $_SERVER['REQUEST_URI'];
        if (strpos($url_link, '&page=') > 0) {
            $url_link = substr($url_link, 0, strpos($url_link, '&page='));
        } elseif (strpos($url_link, '?page=') > 0) {
            $url_link = substr($url_link, 0, strpos($url_link, '?page='));
        }
        $_array_url = array(
            'link' => $url_link,
            'amp' => '&page='
        );
        $generate_page = nv_generate_page($_array_url, $numRecord, $per_pages, $page);
        
        $xtpl->assign('VIEW_PAGES', $generate_page);
        $xtpl->parse('results.pages_result');
    }
    
    $xtpl->assign('NUMRECORD', $numRecord);
    $xtpl->assign('MY_DOMAIN', NV_MY_DOMAIN);
    
    $xtpl->parse('results');
    return $xtpl->text('results');
}

function tag_theme($topic_array, $generate_page, $page_title, $description, $topic_image)
{
    global $lang_module, $module_info, $module_name, $module_file, $topicalias, $module_config;
    
    $xtpl = new XTemplate('tag.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('TITLE', $page_title);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);
    if (! empty($description)) {
        $xtpl->assign('DESCRIPTION', $description);
        if (! empty($topic_image)) {
            $xtpl->assign('HOMEIMG1', $topic_image);
            $xtpl->parse('main.description.image');
        }
        $xtpl->parse('main.description');
    }
    if (! empty($topic_array)) {
        foreach ($topic_array as $topic_array_i) {
            $xtpl->assign('TOPIC', $topic_array_i);
            
            if (! empty($topic_array_i['uploader_name'])) {
                $xtpl->parse('main.topic.uploader_name');
            }
            
            if (! empty($topic_array_i['hitstotal'])) {
                $xtpl->parse('main.topic.hitstotal');
            }
            
            if (! empty($topic_array_i['publtime'])) {
                $xtpl->assign('TIME', humanTiming($topic_array_i['publtime']));
            }
            
            if (! empty($topic_array_i['src'])) {
                $xtpl->parse('main.topic.homethumb');
            }
            
            if (defined('NV_IS_MODADMIN') and ! empty($topic_array_i['id'])) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($topic_array_i['id']) . ' ' . nv_link_delete_page($topic_array_i['id']));
                $xtpl->parse('main.topic.adminlink');
            }
            $xtpl->parse('main.topic');
        }
    }
    
    if (! empty($topic_other_array)) {
        foreach ($topic_other_array as $topic_other_array_i) {
            $topic_other_array_i['publtime'] = nv_date('H:i d/m/Y', $topic_other_array_i['publtime']);
            
            $xtpl->assign('TOPIC_OTHER', $topic_other_array_i);
            $xtpl->parse('main.other.loop');
        }
        
        $xtpl->parse('main.other');
    }
    
    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function uploader_theme($array_uploader, $item_array, $generate_page, $mode)
{
    if ($mode == 'uploader') {
        global $lang_module, $module_info, $module_name, $module_file, $topicalias, $module_config, $user_info, $lang_global;
        
        $xtpl = new XTemplate('uploader.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('GLANG', $lang_global);
        $xtpl->assign('UPLOADER', $array_uploader);
        $xtpl->assign('IMGWIDTH', $module_config[$module_name]['homewidth']);
        $xtpl->assign('IMGHEIGHT', $module_config[$module_name]['homeheight']);
        $xtpl->assign('MODULE_NAME', $module_file);
        foreach ($item_array as $item) {
            $item['publtime'] = humanTiming($item['publtime']);
            $item['title_cut'] = nv_clean60($item['title'], $module_config[$module_name]['titlecut'], true);
            $xtpl->assign('ITEM', $item);
            if (defined('NV_IS_MODADMIN')) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($item['id']) . " " . nv_link_delete_page($item['id']));
                $xtpl->parse('main_info.adminlink');
            }
            if ($item['imghome'] != '') {
                $xtpl->assign('HOMEIMG', $item['imghome']);
                $xtpl->assign('HOMEIMGALT', ! empty($item['homeimgalt']) ? $item['homeimgalt'] : $item['title']);
                $xtpl->parse('main_info.loop.image');
            }
            
            if ($item['hitstotal'] > 0) {
                $xtpl->parse('main_info.loop.hitstotal');
            }
            
            $xtpl->parse('main_info.loop');
        }
        
        if (! empty($array_uploader['email']) and $array_uploader['view_mail'] == 1) {
            $xtpl->parse('main_info.view_mail');
        }
        
        if (! empty($array_uploader['description'])) {
            $xtpl->parse('main_info.description');
        }
        
        if ((defined('NV_IS_USER') and $array_uploader['status'] == 1 and $user_info['userid'] == $array_uploader['userid'])) {
            $xtpl->parse('main_info.edit_link');
        }
        
        if (! empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main_info.generate_page');
        }
        $xtpl->parse('main_info');
        return $xtpl->text('main_info');
    } elseif ($mode == 'list') {
        global $lang_module, $module_info, $module_name, $module_file, $topicalias, $module_config, $user_info, $lang_global;
        
        $xtpl = new XTemplate('uploader.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('UPLOADER', $array_uploader);
        $xtpl->assign('IMGWIDTH', $module_config[$module_name]['homewidth']);
        $xtpl->assign('IMGHEIGHT', $module_config[$module_name]['homeheight']);
        $xtpl->assign('MODULE_NAME', $module_file);
        
        foreach ($item_array as $item) {
            $item['publtime'] = humanTiming($item['publtime']);
            $item['title_cut'] = nv_clean60($item['title'], $module_config[$module_name]['titlecut'], true);
            $xtpl->assign('ITEM', $item);
            if (defined('NV_IS_MODADMIN')) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($item['id']) . " " . nv_link_delete_page($item['id']));
                $xtpl->parse('list_video.loop.adminlink');
            }
            
            if ($item['imghome'] != '') {
                $xtpl->assign('HOMEIMG', $item['imghome']);
                $xtpl->assign('HOMEIMGALT', ! empty($item['homeimgalt']) ? $item['homeimgalt'] : $item['title']);
                $xtpl->parse('list_video.loop.image');
            }
            
            if ($item['hitstotal'] > 0) {
                $xtpl->parse('list_video.loop.hitstotal');
            }
            
            $xtpl->parse('list_video.loop');
        }
        
        if ((defined('NV_IS_USER') and $array_uploader['status'] == 1 and $user_info['userid'] == $array_uploader['userid'])) {
            $xtpl->parse('list_video.edit_link');
        }
        
        if (! empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('list_video.generate_page');
        }
        
        $xtpl->parse('list_video');
        return $xtpl->text('list_video');
    } elseif ($mode == 'editinfo') {
        global $lang_module, $module_info, $module_name, $module_file, $topicalias, $module_config, $user_info, $lang_global;
        
        $xtpl = new XTemplate('uploader.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('GLANG', $lang_global);
        $xtpl->assign('UPLOADER', $array_uploader);
        
        $xtpl->parse('edit_info');
        return $xtpl->text('edit_info');
    }
}