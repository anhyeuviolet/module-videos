<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');


if (! nv_function_exists('curl')) {
	/**
	 * curl()
	 */
	function curl($url)
	{
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$head[] = "Connection: keep-alive";
		$head[] = "Keep-Alive: 300";
		$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$head[] = "Accept-Language: en-us,en;q=0.5";
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Expect:'
		));
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}
}

if (! nv_function_exists('get_facebook_id')) {
	// Get Facebook video id
	function get_facebook_id($link)
	{
		if(substr($link, -1) != '/' && is_numeric(substr($link, -1))){
			$link = $link.'/';
		}
		preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)\/(.*)/U', $link, $id); // link dang https://www.facebook.com/userName/videos/vb.IDuser/IDvideo/?type=2&theater
		if(isset($id[4])){
			$idVideo = $id[3];
		}else{
			preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)/U', $link, $id); // link dang https://www.facebook.com/userName/videos/IDvideo
			if(isset($id[3])){
				$idVideo = $id[2];
			}else{
				preg_match('/https:\/\/www.facebook.com\/video\.php\?v\=(.*)/', $link, $id); // link dang https://www.facebook.com/video.php?v=IDvideo
				$idVideo = $id[1];
				$idVideo = substr($idVideo, 0, -1);
			}
		}
		return $idVideo;
	}
}

if (! nv_function_exists('get_facebook_mp4')) {
	// Get direct link MP4 Facebook
	function get_facebook_mp4($link)
	{
		$id = get_facebook_id($link);
		$embed = 'https://www.facebook.com/video/embed?video_id='.$id;
		$get = curl($embed);
		$data = explode('"videoData":[', $get); // tach chuoi "videoData":[ thanh mang
		$data = explode('],"minQuality"', $data[1]); // tach chuoi ],"minQuality" thanh mang
		$data = str_replace(
			array('\/'),
			array('/'),
			$data[0]
		); // thay the cac ky tu ma hoa thanh ky tu dac biet
		$fbvid_mp4 = array();
		$mp4 = array(
			'link_mp4'=>'',
			'quality'=>''
		 );
		//Link HD
		
		$data = json_decode($data); // decode chuoi
		if(isset($data->hd_src)){
			$mp4 = array(
				'link_mp4' => $data->hd_src,
				'quality' => 'HD'
			);  
			$fbvid_mp4[] = $mp4;
		}
		if(isset($data->sd_src)){
			$mp4 = array(
				'link_mp4' => $data->sd_src,
				'quality' => 'SD'
			 );  
			$fbvid_mp4[] = $mp4;
		}

		return $fbvid_mp4;  
	}
}

if (! nv_function_exists('nv_get_video_href')) {

    function nv_get_video_href($path, $type)
    {
        global $module_upload;
        // Export video link
        $href_vid = array();
        if (! empty($path)) {
            if ($type == 1) {
                $href_vid['link'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/vid/' . $path;
                $href_vid['quality'] = '';
            } elseif ($type == 2) {
                $href_vid['link'] = $path;
                $href_vid['quality'] = '';
            } elseif ($type == 3) {
                $href_vid = get_link_mp4_picasa($path);
            } elseif ($type == 4) {
                $href_vid = get_facebook_mp4($path);
            } elseif ($type == 5) {
                $href_vid['link'] = $path;
                $href_vid['quality'] = '';
            }
        }
        return $href_vid;
    }
}

if (! nv_function_exists('videos_thumbs')) {

    function videos_thumbs($id, $file, $module_upload, $width = 200, $height = 150, $quality = 90)
    {
        if ($width >= $height)
            $rate = $width / $height;
        else
            $rate = $height / $width;
        
        $image = NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/img/' . $file;
        
        if ($file != '' and file_exists($image)) {
            $imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $file;
            $imginfo = nv_is_image($image);
            
            $basename = $module_upload . '_' . $width . 'x' . $height . '-' . $id . '-' . md5_file($image) . '.' . $imginfo['ext'];
            
            if (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename)) {
                $imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename;
            } else {
                
                $_image = new NukeViet\Files\Image($image, NV_MAX_WIDTH, NV_MAX_HEIGHT);
                
                if ($imginfo['width'] <= $imginfo['height']) {
                    $_image->resizeXY($width, 0);
                } elseif (($imginfo['width'] / $imginfo['height']) < $rate) {
                    $_image->resizeXY($width, 0);
                } elseif (($imginfo['width'] / $imginfo['height']) >= $rate) {
                    $_image->resizeXY(0, $height);
                }
                
                $_image->cropFromCenter($width, $height);
                
                $_image->save(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/', $basename, $quality);
                
                if (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename)) {
                    $imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename;
                }
            }
        } elseif (nv_is_url($file)) {
            $imgsource = $file;
        } else {
            $imgsource = '';
        }
        return $imgsource;
    }
}

if (! nv_function_exists('nv_block_videos_cat_quickplay')) {

    function nv_block_config_videos_cat_quickplay($module, $data_block, $lang_block)
    {
        global $site_mods, $nv_Cache;
        
        $html_input = '';
        $html = '<tr>';
        $html .= '<td>' . $lang_block['catid'] . '</td>';
        
        $html .= '<td><select name="config_catid" class="form-control w150">';
        $html .= '<option value="0"> -- </option>';
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $l) {
            $html .= '<option value="' . $l['catid'] . '" ' . (($data_block['catid'] == $l['catid']) ? ' selected="selected"' : '') . '>' . $l['title'] . '</option>';
        }
        $html .= '</select>';
        $html .= '</td></tr>';
        
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['numrow'] . '</td>';
        $html .= '<td><input type="text" class="form-control w150" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['show_logo'] . '</td>';
        $html .= '<td>';
        $html .= '<input type="checkbox" value="1" name="config_show_logo" ' . ($data_block['show_logo'] == 1 ? 'checked="checked"' : '') . ' /></td>';
        $html .= '</tr>';
        return $html;
    }

    function nv_block_config_videos_cat_quickplay_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['catid'] = $nv_Request->get_int('config_catid', 'post', array());
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['show_logo'] = $nv_Request->get_int('config_show_logo', 'post', 0);
        return $return;
    }

    function nv_block_videos_cat_quickplay($block_config)
    {
        global $lang_global, $lang_module, $blockID, $module_array_cat, $module_info, $site_mods, $module_config, $global_config, $db, $nv_Cache;
		$url_info = @parse_url(NV_MY_DOMAIN);

        $module = $block_config['module'];
        $show_no_image = $module_config[$module]['show_no_image'];
        if (empty($show_no_image)) {
            $show_no_image = 'themes/default/images/' . $module . '/' . 'video_placeholder.png';
        }
        $blockwidth = $module_config[$module]['blockwidth'];
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $site_mods[$module]['module_file'] . '/block_cat_quickplay.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_cat_quickplay.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $site_mods[$module]['module_file']);
        $xtpl->assign('LANG_GLOBAL', $lang_global);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('MODULE_FILE', $site_mods[$module]['module_file']);
        $xtpl->assign('BLOCKID', $blockID);
        if (empty($block_config['catid']))
            return '';
        $catid = $block_config['catid'];
        
        $db->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_' . $catid)
            ->where('status= 1')
            ->order('publtime DESC')
            ->limit(1);
        $list = $nv_Cache->db($db->sql(), '', $module);
        
        $main_id = 0;
        if (! empty($list)) {
            if (defined('NV_IS_MODADMIN') and (empty($module_config[$module]['jwplayer_license']) or ! isset($module_config[$module]['jwplayer_license']))) {
                $xtpl->assign('SETTING_LINKS', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=setting#jwplayer_license');
                $xtpl->parse('main.no_jwp_lic_admin');
            } elseif (empty($module_config[$module]['jwplayer_license']) or ! isset($module_config[$module]['jwplayer_license'])) {
                $xtpl->parse('main.no_jwp_lic');
            }
            
            if (! empty($module_config[$module]['jwplayer_logo_file']) and file_exists(NV_ROOTDIR . '/' . $module_config[$module]['jwplayer_logo_file'])) {
                $lu = strlen(NV_BASE_SITEURL);
                $module_config[$module]['jwplayer_logo_file'] = NV_BASE_SITEURL . $module_config[$module]['jwplayer_logo_file'];
            }
            $module_config[$module]['site_name'] = $global_config['site_name'];
            
            $xtpl->assign('VIDEO_CONFIG', $module_config[$module]);
            foreach ($list as $l) {
				$main_id = $l['id'];
                $l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'] . '/' . $l['alias'] . '-' . $l['id'] . $global_config['rewrite_exturl'];
                if ($l['homeimgthumb'] == 1 or $l['homeimgthumb'] == 2) // image file
				{
                    $l['thumb'] = videos_thumbs($l['id'], $l['homeimgfile'], $module, $module_config[$module]['homewidth'], $module_config[$module]['homeheight'], 90);
                } elseif ($l['homeimgthumb'] == 3) // image url
				{
                    $l['thumb'] = $l['homeimgfile'];
                } elseif (! empty($show_no_image)) // no image
				{
                    $l['thumb'] = NV_BASE_SITEURL . $show_no_image;
                } else {
                    $l['thumb'] = '';
                }
                
                $l['blockwidth'] = $blockwidth;
                
                $href_vid = array();
                $href_vid = nv_get_video_href($l['vid_path'], $l['vid_type']);
                
                $xtpl->assign('ROW', $l);
                $link_player = NV_MY_DOMAIN . NV_BASE_SITEURL . $module . '/player/' . rand(1000, 9999) . 0 . '-' . md5($l['id'] . session_id() . $global_config['sitekey']) . '-' . rand(1000, 9999) . $l['id'] . $global_config['rewrite_endurl'];
				$link_player = preg_replace('/' . $url_info['scheme'] . ':' . '/', '', $link_player);

                $xtpl->assign('PLAYER', $link_player);
            }
            
            if (! empty($href_vid)) {
                if ($block_config['show_logo'] > 0 and ! empty($module_config[$module]['jwplayer_logo_file'])) {
                    $xtpl->parse('main.jwplayer.player_logo');
                }
                
                if (! defined('JWPLAYER_JS' . $site_mods[$module]['module_data'])) {
                    define('JWPLAYER_JS' . $site_mods[$module]['module_data'], true);
                    $xtpl->parse('main.jwplayer_js');
                }
                $xtpl->parse('main.jwplayer');
                $xtpl->parse('main.vid_jw_content');
            }
        }
        if ( $main_id > 0 ){
            $db->sqlreset()
                ->select('*')
                ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_' . $catid)
                ->where('status= 1 AND id <>' . $main_id)
                ->order('publtime DESC')
                ->limit($block_config['numrow']);
            $_sql = $nv_Cache->db($db->sql(), '', $module);
        }
        
        if (! empty($_sql)) {
            foreach ($_sql as $l) {
                $l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'] . '/' . $l['alias'] . '-' . $l['id'] . $global_config['rewrite_exturl'];
                
                if ($l['homeimgthumb'] == 1 or $l['homeimgthumb'] == 2) // image file
                {
                    $l['thumb'] = videos_thumbs($l['id'], $l['homeimgfile'], $module, $module_config[$module]['homewidth'], $module_config[$module]['homeheight'], 90);
                } elseif ($l['homeimgthumb'] == 3) // image url
                {
                    $l['thumb'] = $l['homeimgfile'];
                } elseif (! empty($show_no_image)) // no image
                {
                    $l['thumb'] = NV_BASE_SITEURL . $show_no_image;
                } else {
                    $l['thumb'] = '';
                }
                $l['blockwidth'] = $blockwidth;
                
                $xtpl->assign('ROW', $l);
                if (! empty($l['thumb']))
                    $xtpl->parse('main.loop.img');
                
                $xtpl->parse('main.loop');
            }
        }
    $xtpl->parse('main');
    return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $module, $global_array_cat, $module_array_cat, $nv_Cache;
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $global_array_cat;
            unset($module_array_cat[0]);
        } else {
            $module_array_cat = array();
            $sql = 'SELECT catid, parentid, title, alias, viewcat, subcatid, numlinks, description, inhome, keywords, groups_view FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
            $list = $nv_Cache->db($sql, 'catid', $module);
            foreach ($list as $l) {
                $module_array_cat[$l['catid']] = $l;
                $module_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
            }
        }
        $content = nv_block_videos_cat_quickplay($block_config);
    }
}