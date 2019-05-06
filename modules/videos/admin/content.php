<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$report = '';
$username_alias = change_alias($admin_info['username']);
$array_structure_image = array();
$array_structure_image[''] = $module_upload;
$array_structure_image['Y'] = $module_upload . '/img/' . date('Y');
$array_structure_image['Ym'] = $module_upload . '/img/' . date('Y_m');
$array_structure_image['Y_m'] = $module_upload . '/img/' . date('Y/m');
$array_structure_image['Ym_d'] = $module_upload . '/img/' . date('Y_m/d');
$array_structure_image['Y_m_d'] = $module_upload . '/img/' . date('Y/m/d');
$array_structure_image['username'] = $module_upload . '/img/' . $username_alias;

$array_structure_image['username_Y'] = $module_upload . '/img/' . $username_alias . '/' . date('Y');
$array_structure_image['username_Ym'] = $module_upload . '/img/' . $username_alias . '/' . date('Y_m');
$array_structure_image['username_Y_m'] = $module_upload . '/img/' . $username_alias . '/' . date('Y/m');
$array_structure_image['username_Ym_d'] = $module_upload . '/img/' . $username_alias . '/' . date('Y_m/d');
$array_structure_image['username_Y_m_d'] = $module_upload . '/img/' . $username_alias . '/' . date('Y/m/d');

$structure_upload = isset($module_config[$module_name]['structure_upload']) ? $module_config[$module_name]['structure_upload'] : 'Ym';

$currentpath = isset($array_structure_image[$structure_upload]) ? $array_structure_image[$structure_upload] : '';

if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $currentpath)) {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $currentpath;
} else {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
    $e = explode('/', $currentpath);
    if (! empty($e)) {
        $cp = '';
        foreach ($e as $p) {
            if (! empty($p) and ! is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                if ($mk[0] > 0) {
                    $upload_real_dir_page = $mk[2];
                    $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                }
            } elseif (! empty($p)) {
                $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
            }
            $cp .= $p . '/';
        }
    }
    $upload_real_dir_page = str_replace('\\', '/', $upload_real_dir_page);
}

$array_structure_file = array();
$array_structure_file[''] = $module_upload;
$array_structure_file['Y'] = $module_upload . '/vid/' . date('Y');
$array_structure_file['Ym'] = $module_upload . '/vid/' . date('Y_m');
$array_structure_file['Y_m'] = $module_upload . '/vid/' . date('Y/m');
$array_structure_file['Ym_d'] = $module_upload . '/vid/' . date('Y_m/d');
$array_structure_file['Y_m_d'] = $module_upload . '/vid/' . date('Y/m/d');

$array_structure_file['username_Y'] = $module_upload . '/vid/' . $username_alias . '/' . date('Y');
$array_structure_file['username_Ym'] = $module_upload . '/vid/' . $username_alias . '/' . date('Y_m');
$array_structure_file['username_Y_m'] = $module_upload . '/vid/' . $username_alias . '/' . date('Y/m');
$array_structure_file['username_Ym_d'] = $module_upload . '/vid/' . $username_alias . '/' . date('Y_m/d');
$array_structure_file['username_Y_m_d'] = $module_upload . '/vid/' . $username_alias . '/' . date('Y/m/d');

$file_path = isset($array_structure_file[$structure_upload]) ? $array_structure_file[$structure_upload] : '';

if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $file_path)) {
    $real_file_path = NV_UPLOADS_REAL_DIR . '/' . $file_path;
} else {
    $real_file_path = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
    $e = explode('/', $file_path);
    if (! empty($e)) {
        $cp = '';
        foreach ($e as $p) {
            if (! empty($p) and ! is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                if ($mk[0] > 0) {
                    $real_file_path = $mk[2];
                    $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                }
            } elseif (! empty($p)) {
                $real_file_path = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
            }
            $cp .= $p . '/';
        }
    }
    $real_file_path = str_replace('\\', '/', $real_file_path);
}

$currentpath = str_replace(NV_ROOTDIR . '/', '', $upload_real_dir_page);
$file_path = str_replace(NV_ROOTDIR . '/', '', $real_file_path);

$uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/img/';

if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_currentpath = explode('/', $currentpath);
    if ($array_currentpath[2] == $username_alias) {
        $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $username_alias;
    }
}

if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_file_path = explode('/', $file_path);
    if ($array_file_path[2] == $username_alias) {
        $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $username_alias;
    }
}

$uploads_dir_file_user = NV_UPLOADS_DIR . '/' . $module_upload . '/vid/';

if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_currentpath = explode('/', $currentpath);
    if ($array_currentpath[2] == $username_alias) {
        $uploads_dir_file_user = NV_UPLOADS_DIR . '/' . $module_upload . '/vid/' . $username_alias;
    }
}

if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_file_path = explode('/', $file_path);
    if ($array_file_path[2] == $username_alias) {
        $uploads_dir_file_user = NV_UPLOADS_DIR . '/' . $module_upload . '/vid/' . $username_alias;
    }
}

$array_block_cat_module = array();
$id_block_content = array();
$sql = 'SELECT bid, adddefault, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
$result = $db->query($sql);
while (list ($bid_i, $adddefault_i, $title_i) = $result->fetch(3)) {
    $array_block_cat_module[$bid_i] = $title_i;
    if ($adddefault_i) {
        $id_block_content[] = $bid_i;
    }
}

// playlist
$array_playlist_cat_module = array();
$id_playlist_content = array();
$sql = 'SELECT playlist_id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat ORDER BY weight ASC';
$result = $db->query($sql);
while (list ($playlist_id, $title_i) = $result->fetch(3)) {
    $array_playlist_cat_module[$playlist_id] = $title_i;
}

$catid = $nv_Request->get_int('catid', 'get', 0);
$parentid = $nv_Request->get_int('parentid', 'get', 0);

$admin_name = $admin_info['username'];

$rowcontent = array(
    'id' => '',
    'catid' => $catid,
    'listcatid' => $catid . ',' . $parentid,
    'admin_id' => $admin_id,
    'admin_name' => $admin_name,
    'author' => '',
    'artist' => '',
    'sourceid' => 0,
    'addtime' => NV_CURRENTTIME,
    'edittime' => NV_CURRENTTIME,
    'status' => 0,
    'publtime' => NV_CURRENTTIME,
    'exptime' => 0,
    'archive' => 1,
    'title' => '',
    'alias' => '',
    'hometext' => '',
    'sourcetext' => '',
    'vid_path' => '',
    'vid_duration' => '',
    'homeimgfile' => '',
    'homeimgalt' => '',
    'homeimgthumb' => '',
    'bodyhtml' => '',
    'copyright' => 0,
    'gid' => 0,
    'inhome' => 1,
    'allowed_comm' => $module_config[$module_name]['setcomm'],
    'allowed_rating' => 1,
    'allowed_send' => 1,
    'allowed_save' => 1,
    'hitstotal' => 0,
    'hitscm' => 0,
    'total_rating' => 0,
    'click_rating' => 0,
    'keywords' => '',
    'keywords_old' => '',
    'is_del_report' => 1,
    'mode' => 'add'
);

$page_title = $lang_module['content_add'];
$error = array();
$groups_list = nv_groups_list();
$array_keywords_old = array();

$rowcontent['id'] = $nv_Request->get_int('id', 'get,post', 0);
if ($rowcontent['id'] > 0) {
    $check_permission = false;
    $rowcontent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows where id=' . $rowcontent['id'])->fetch();
    if (! empty($rowcontent['id'])) {
        $rowcontent['mode'] = 'edit';
        $arr_catid = explode(',', $rowcontent['listcatid']);
        if (defined('NV_IS_ADMIN_MODULE')) {
            $check_permission = true;
        } else {
            $check_edit = 0;
            $status = $rowcontent['status'];
            foreach ($arr_catid as $catid_i) {
                if (isset($array_cat_admin[$admin_id][$catid_i])) {
                    if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
                        ++ $check_edit;
                    } else {
                        if ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                            ++ $check_edit;
                        } elseif ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1 and ($status == 0 or $status = 2)) {
                            ++ $check_edit;
                        } elseif (($status == 0 or $status == 4 or $status == 5) and $rowcontent['admin_id'] == $admin_id) {
                            ++ $check_edit;
                        }
                    }
                }
            }
            if ($check_edit == sizeof($arr_catid)) {
                $check_permission = true;
            }
        }
    }
    
    if (! $check_permission) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        die();
    }
    
    $page_title = $lang_module['content_edit'];
    
    $body_contents = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_detail where id=' . $rowcontent['id'])->fetch();
    $rowcontent = array_merge($rowcontent, $body_contents);
    unset($body_contents);
    
    $report = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report WHERE id=' . $rowcontent['id'])->fetchColumn();
    
    $_query = $db->query('SELECT tid, keyword FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id=' . $rowcontent['id'] . ' ORDER BY keyword ASC');
    while ($row = $_query->fetch()) {
        $array_keywords_old[$row['tid']] = $row['keyword'];
    }
    $rowcontent['keywords'] = implode(', ', $array_keywords_old);
    $rowcontent['keywords_old'] = $rowcontent['keywords'];
    
    $id_block_content = array();
    $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where id=' . $rowcontent['id'];
    $result = $db->query($sql);
    while (list ($bid_i) = $result->fetch(3)) {
        $id_block_content[] = $bid_i;
    }
    
    // Playlist
    $id_playlist_content = array();
    $sql = 'SELECT playlist_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist where id=' . $rowcontent['id'];
    $result = $db->query($sql);
    while (list ($playlist_id) = $result->fetch(3)) {
        $id_playlist_content[] = $playlist_id;
    }
}

$array_cat_add_content = $array_cat_pub_content = $array_cat_edit_content = $array_censor_content = array();
foreach ($global_array_cat as $catid_i => $array_value) {
    $check_add_content = $check_pub_content = $check_edit_content = $check_censor_content = false;
    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_add_content = $check_pub_content = $check_edit_content = $check_censor_content = true;
    } elseif (isset($array_cat_admin[$admin_id][$catid_i])) {
        if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
            $check_add_content = $check_pub_content = $check_edit_content = $check_censor_content = true;
        } else {
            if ($array_cat_admin[$admin_id][$catid_i]['add_content'] == 1) {
                $check_add_content = true;
            }
            
            if ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1) {
                $check_pub_content = true;
            }
            
            if ($array_cat_admin[$admin_id][$catid_i]['app_content'] == 1) {
                $check_censor_content = true;
            }
            
            if ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                $check_edit_content = true;
            }
        }
    }
    if ($check_add_content) {
        $array_cat_add_content[] = $catid_i;
    }
    
    if ($check_pub_content) {
        $array_cat_pub_content[] = $catid_i;
    }
    if ($check_censor_content) // Nguoi kiem duyet
{
        $array_censor_content[] = $catid_i;
    }
    
    if ($check_edit_content) {
        $array_cat_edit_content[] = $catid_i;
    }
}

if ($nv_Request->get_int('save', 'post') == 1) {
    $catids = array_unique($nv_Request->get_typed_array('catids', 'post', 'int', array()));
    $id_block_content_post = array_unique($nv_Request->get_typed_array('bids', 'post', 'int', array()));
    $id_playlist_content_post = array_unique($nv_Request->get_typed_array('playlists', 'post', 'int', array()));
    
    $rowcontent['catid'] = $nv_Request->get_int('catid', 'post', 0);
    
    $rowcontent['is_del_report'] = $nv_Request->get_int('is_del_report', 'post', 0);
    if ($report and $rowcontent['is_del_report']) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report WHERE id=' . $rowcontent['id']);
    }
    $rowcontent['listcatid'] = implode(',', $catids);
    
    if ($nv_Request->isset_request('status1', 'post'))
        $rowcontent['status'] = 1; // dang tin
    elseif ($nv_Request->isset_request('status0', 'post'))
        $rowcontent['status'] = 0; // cho tong bien tap duyet
    elseif ($nv_Request->isset_request('status4', 'post'))
        $rowcontent['status'] = 4; // luu tam
    else
        $rowcontent['status'] = 6; // gui, cho bien tap
    
    $message_error_show = $lang_module['permissions_pub_error'];
    if ($rowcontent['status'] == 1) {
        $array_cat_check_content = $array_cat_pub_content;
    } elseif ($rowcontent['status'] == 1 and $rowcontent['publtime'] <= NV_CURRENTTIME) {
        $array_cat_check_content = $array_cat_edit_content;
    } elseif ($rowcontent['status'] == 0) {
        $array_cat_check_content = $array_censor_content;
        $message_error_show = $lang_module['permissions_sendspadmin_error'];
    } else {
        $array_cat_check_content = $array_cat_add_content;
    }
    
    foreach ($catids as $catid_i) {
        if (! empty($catid_i) and ! in_array($catid_i, $array_cat_check_content)) {
            $error[] = sprintf($message_error_show, $global_array_cat[$catid_i]['title']);
        }
    }
    
    $rowcontent['author'] = $nv_Request->get_title('author', 'post', '', 1);
    $rowcontent['artist'] = $nv_Request->get_title('artist', 'post', '', 1);
    $rowcontent['sourcetext'] = $nv_Request->get_title('sourcetext', 'post', '');
    
    $publ_date = $nv_Request->get_title('publ_date', 'post', '');
    
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $publ_date, $m)) {
        $phour = $nv_Request->get_int('phour', 'post', 0);
        $pmin = $nv_Request->get_int('pmin', 'post', 0);
        $rowcontent['publtime'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
    } else {
        $rowcontent['publtime'] = NV_CURRENTTIME;
    }
    
    $exp_date = $nv_Request->get_title('exp_date', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $exp_date, $m)) {
        $ehour = $nv_Request->get_int('ehour', 'post', 0);
        $emin = $nv_Request->get_int('emin', 'post', 0);
        $rowcontent['exptime'] = mktime($ehour, $emin, 0, $m[2], $m[1], $m[3]);
    } else {
        $rowcontent['exptime'] = 0;
    }
    
    $rowcontent['archive'] = $nv_Request->get_int('archive', 'post', 0);
    if ($rowcontent['archive'] > 0) {
        $rowcontent['archive'] = ($rowcontent['exptime'] > NV_CURRENTTIME) ? 1 : 2;
    }
    $rowcontent['title'] = $nv_Request->get_title('title', 'post', '', 1);
    
    // Xử lý liên kết tĩnh
    $alias = $nv_Request->get_title('alias', 'post', '');
    if (empty($alias)) {
        $alias = change_alias($rowcontent['title']);
        if ($module_config[$module_name]['alias_lower'])
            $alias = strtolower($alias);
    } else {
        $alias = change_alias($alias);
    }
    
    if (empty($alias) or ! preg_match("/^([a-zA-Z0-9\_\-]+)$/", $alias)) {
        if (empty($rowcontent['alias'])) {
            $rowcontent['alias'] = 'post';
        }
    } else {
        $rowcontent['alias'] = $alias;
    }
    
    $rowcontent['hometext'] = $nv_Request->get_textarea('hometext', '', 'br', 1);
    
    $rowcontent['vid_path'] = $nv_Request->get_title('vid_path', 'post', '');
    $rowcontent['vid_duration'] = $nv_Request->get_title('vid_duration', 'post', '');
    
    $rowcontent['homeimgfile'] = $nv_Request->get_title('homeimg', 'post', '');
    $rowcontent['homeimgalt'] = $nv_Request->get_title('homeimgalt', 'post', '', 1);
    $rowcontent['bodyhtml'] = $nv_Request->get_editor('bodyhtml', '', NV_ALLOWED_HTML_TAGS);
    
    $rowcontent['copyright'] = (int) $nv_Request->get_bool('copyright', 'post');
    $rowcontent['inhome'] = (int) $nv_Request->get_bool('inhome', 'post');
    
    $_groups_post = $nv_Request->get_array('allowed_comm', 'post', array());
    $rowcontent['allowed_comm'] = ! empty($_groups_post) ? implode(',', nv_groups_post(array_intersect($_groups_post, array_keys($groups_list)))) : '';
    
    $rowcontent['allowed_rating'] = (int) $nv_Request->get_bool('allowed_rating', 'post');
    $rowcontent['allowed_send'] = (int) $nv_Request->get_bool('allowed_send', 'post');
    $rowcontent['allowed_save'] = (int) $nv_Request->get_bool('allowed_save', 'post');
    $rowcontent['gid'] = $nv_Request->get_int('gid', 'post', 0);
    
    $rowcontent['keywords'] = $nv_Request->get_array('keywords', 'post', '');
    $rowcontent['keywords'] = implode(', ', $rowcontent['keywords']);
    
    // Tu dong xac dinh keywords
    if ($rowcontent['keywords'] == '' and ! empty($module_config[$module_name]['auto_tags'])) {
        $keywords = ($rowcontent['hometext'] != '') ? $rowcontent['hometext'] : $rowcontent['bodyhtml'];
        $keywords = nv_get_keywords($keywords, 100);
        $keywords = explode(',', $keywords);
        
        // Ưu tiên lọc từ khóa theo các từ khóa đã có trong tags thay vì đọc từ từ điển
        $keywords_return = array();
        foreach ($keywords as $keyword_i) {
            $sth = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id where keyword = :keyword');
            $sth->bindParam(':keyword', $keyword_i, PDO::PARAM_STR);
            $sth->execute();
            if ($sth->fetchColumn()) {
                $keywords_return[] = $keyword_i;
                if (sizeof($keywords_return) > 20) {
                    break;
                }
            }
        }
        
        if (sizeof($keywords_return) < 20) {
            foreach ($keywords as $keyword_i) {
                if (! in_array($keyword_i, $keywords_return)) {
                    $keywords_return[] = $keyword_i;
                    if (sizeof($keywords_return) > 20) {
                        break;
                    }
                }
            }
        }
        $rowcontent['keywords'] = implode(',', $keywords_return);
    }
    
    if (empty($rowcontent['title'])) {
        $error[] = $lang_module['error_title'];
    } elseif (empty($rowcontent['listcatid'])) {
        $error[] = $lang_module['error_cat'];
    } elseif (empty($rowcontent['vid_path'])) {
        $error[] = $lang_module['error_vid_path'];
    }
    
    if (empty($error)) {
        if (! empty($catids)) {
            $rowcontent['catid'] = in_array($rowcontent['catid'], $catids) ? $rowcontent['catid'] : $catids[0];
        }
        
        $rowcontent['sourceid'] = 0;
        if (! empty($rowcontent['sourcetext'])) {
            $url_info = @parse_url($rowcontent['sourcetext']);
            if (isset($url_info['scheme']) and isset($url_info['host'])) {
                $sourceid_link = $url_info['scheme'] . '://' . $url_info['host'];
                $stmt = $db->prepare('SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE link= :link');
                $stmt->bindParam(':link', $sourceid_link, PDO::PARAM_STR);
                $stmt->execute();
                $rowcontent['sourceid'] = $stmt->fetchColumn();
                
                if (empty($rowcontent['sourceid'])) {
                    $weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
                    $weight = intval($weight) + 1;
                    $_sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_sources (title, link, logo, weight, add_time, edit_time) VALUES ( :title ,:sourceid_link, '', :weight, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
                    
                    $data_insert = array();
                    $data_insert['title'] = $url_info['host'];
                    $data_insert['sourceid_link'] = $sourceid_link;
                    $data_insert['weight'] = $weight;
                    
                    $rowcontent['sourceid'] = $db->insert_id($_sql, 'sourceid', $data_insert);
                }
            } else {
                $stmt = $db->prepare('SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE title= :title');
                $stmt->bindParam(':title', $rowcontent['sourcetext'], PDO::PARAM_STR);
                $stmt->execute();
                $rowcontent['sourceid'] = $stmt->fetchColumn();
                
                if (empty($rowcontent['sourceid'])) {
                    $weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
                    $weight = intval($weight) + 1;
                    $_sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_sources (title, link, logo, weight, add_time, edit_time) VALUES ( :title, '', '', " . $weight . " , " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
                    $data_insert = array();
                    $data_insert['title'] = $rowcontent['sourcetext'];
                    
                    $rowcontent['sourceid'] = $db->insert_id($_sql, 'sourceid', $data_insert);
                }
            }
        }
        
        // Xu ly anh minh hoa
        $rowcontent['homeimgthumb'] = 0;
        if (! nv_is_url($rowcontent['homeimgfile']) and is_file(NV_DOCUMENT_ROOT . $rowcontent['homeimgfile'])) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/');
            $rowcontent['homeimgfile'] = substr($rowcontent['homeimgfile'], $lu);
            if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/img/' . $rowcontent['homeimgfile'])) {
                $rowcontent['homeimgthumb'] = 1;
            } else {
                $rowcontent['homeimgthumb'] = 2;
            }
        } elseif (nv_is_url($rowcontent['homeimgfile'])) {
            $rowcontent['homeimgthumb'] = 3;
        } else {
            $rowcontent['homeimgfile'] = '';
        }
        
        // Xu ly Video link
        $rowcontent['vid_type'] = 0;
        if (! nv_is_url($rowcontent['vid_path']) and is_file(NV_DOCUMENT_ROOT . $rowcontent['vid_path'])) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/vid/');
            $rowcontent['vid_path'] = substr($rowcontent['vid_path'], $lu);
            if (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/vid/' . $rowcontent['vid_path'])) {
                $rowcontent['vid_type'] = 1; // is uploaded file
            }
        } elseif (nv_is_url($rowcontent['vid_path'])) {
            if (is_youtube($rowcontent['vid_path'])) {
                $rowcontent['vid_type'] = 2; // is Youtube
            } elseif (is_picasa($rowcontent['vid_path'])) {
                $rowcontent['vid_type'] = 3; // is Picasa
            } elseif (is_facebook($rowcontent['vid_path'])) {
                $rowcontent['vid_type'] = 4; // is Facebook
            } elseif (is_gdrive($rowcontent['vid_path'])) {
                $rowcontent['vid_type'] = 6; // is Google Drive
            } else {
                $rowcontent['vid_type'] = 5; // hotlink from other site
            }
        } else {
            $rowcontent['vid_path'] = '';
        }
        
        // Auto-Thumb from Youtube - if empty Image
        if (($rowcontent['vid_type'] == 2) and (empty($rowcontent['homeimgfile']))) {
            $rowcontent['homeimgfile'] = 'https://img.youtube.com/vi/' . get_youtube_id($rowcontent['vid_path']) . '/0.jpg';
            $rowcontent['homeimgthumb'] = 3;
        }
        
        // Auto-duration from Youtube - if empty
        if (($rowcontent['vid_type'] == 2) and (empty($rowcontent['vid_duration']))) {
            $_vid_duration = youtubeVideoDuration($rowcontent['vid_path']);
            $rowcontent['vid_duration'] = sec2hms($_vid_duration);
        }
        
        if ($rowcontent['id'] == 0) {
            if (! defined('NV_IS_SPADMIN') and intval($rowcontent['publtime']) < NV_CURRENTTIME) {
                $rowcontent['publtime'] = NV_CURRENTTIME;
            }
            if ($rowcontent['status'] == 1 and $rowcontent['publtime'] > NV_CURRENTTIME) {
                $rowcontent['status'] = 2;
            }
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows
				(catid, listcatid, admin_id, admin_name, author, artist, sourceid, addtime, edittime, status, publtime, exptime, archive, title, alias, hometext, vid_path, vid_duration, vid_type, homeimgfile, homeimgalt, homeimgthumb, inhome, allowed_comm, allowed_rating, hitstotal, hitscm, total_rating, click_rating) VALUES
				 (' . intval($rowcontent['catid']) . ',
				 :listcatid,
				 ' . intval($rowcontent['admin_id']) . ',
				 :admin_name,
				 :author,
				 :artist,
				 ' . intval($rowcontent['sourceid']) . ',
				 ' . intval($rowcontent['addtime']) . ',
				 ' . intval($rowcontent['edittime']) . ',
				 ' . intval($rowcontent['status']) . ',
				 ' . intval($rowcontent['publtime']) . ',
				 ' . intval($rowcontent['exptime']) . ',
				 ' . intval($rowcontent['archive']) . ',
				 :title,
				 :alias,
				 :hometext,
				 :vid_path,
				 :vid_duration,
				 :vid_type,
				 :homeimgfile,
				 :homeimgalt,
				 :homeimgthumb,
				 ' . intval($rowcontent['inhome']) . ',
				 :allowed_comm,
				 ' . intval($rowcontent['allowed_rating']) . ',
				 ' . intval($rowcontent['hitstotal']) . ',
				 ' . intval($rowcontent['hitscm']) . ',
				 ' . intval($rowcontent['total_rating']) . ',
				 ' . intval($rowcontent['click_rating']) . ')';
            
            $data_insert = array();
            $data_insert['listcatid'] = $rowcontent['listcatid'];
            $data_insert['admin_name'] = $rowcontent['admin_name'];
            $data_insert['author'] = $rowcontent['author'];
            $data_insert['artist'] = $rowcontent['artist'];
            $data_insert['title'] = $rowcontent['title'];
            $data_insert['alias'] = $rowcontent['alias'];
            $data_insert['hometext'] = $rowcontent['hometext'];
            $data_insert['vid_path'] = $rowcontent['vid_path'];
            $data_insert['vid_duration'] = $rowcontent['vid_duration'];
            $data_insert['vid_type'] = $rowcontent['vid_type'];
            $data_insert['homeimgfile'] = $rowcontent['homeimgfile'];
            $data_insert['homeimgalt'] = $rowcontent['homeimgalt'];
            $data_insert['homeimgthumb'] = $rowcontent['homeimgthumb'];
            $data_insert['allowed_comm'] = $rowcontent['allowed_comm'];
            
            $rowcontent['id'] = $db->insert_id($sql, 'id', $data_insert);
            if ($rowcontent['id'] > 0) {
                if (nv_videos_check_uploader(intval($rowcontent['admin_id']))) {
                    nv_videos_getuser_info(intval($rowcontent['admin_id']));
                    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['add_uploader_data'], $rowcontent['admin_name'], $admin_info['userid']);
                }
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['content_add'], $rowcontent['title'], $admin_info['userid']);
                $ct_query = array();
                
                $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_detail VALUES
					(' . $rowcontent['id'] . ',
					 :bodyhtml,
					 :sourcetext,
					 ' . $rowcontent['copyright'] . ',
					 ' . $rowcontent['allowed_send'] . ',
					 ' . $rowcontent['allowed_save'] . ',
					 ' . $rowcontent['gid'] . '
					 )');
                $stmt->bindParam(':bodyhtml', $rowcontent['bodyhtml'], PDO::PARAM_STR, strlen($rowcontent['bodyhtml']));
                $stmt->bindParam(':sourcetext', $rowcontent['sourcetext'], PDO::PARAM_STR, strlen($rowcontent['sourcetext']));
                $ct_query[] = (int) $stmt->execute();
                
                foreach ($catids as $catid) {
                    $ct_query[] = (int) $db->exec('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid . ' SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $rowcontent['id']);
                }
                
                if (array_sum($ct_query) != sizeof($ct_query)) {
                    $error[] = $lang_module['errorsave'];
                }
                unset($ct_query);
            } else {
                $error[] = $lang_module['errorsave'];
            }
        } else {
            $rowcontent_old = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows where id=' . $rowcontent['id'])->fetch();
            if ($rowcontent_old['status'] == 1) {
                $rowcontent['status'] = 1;
            }
            if (! defined('NV_IS_SPADMIN') and intval($rowcontent['publtime']) < intval($rowcontent_old['addtime'])) {
                $rowcontent['publtime'] = $rowcontent_old['addtime'];
            }
            
            if ($rowcontent['status'] == 1 and $rowcontent['publtime'] > NV_CURRENTTIME) {
                $rowcontent['status'] = 2;
            }
            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET
					 catid=' . intval($rowcontent['catid']) . ',
					 listcatid=:listcatid,
					 author=:author,
					 artist=:artist,
					 sourceid=' . intval($rowcontent['sourceid']) . ',
					 status=' . intval($rowcontent['status']) . ',
					 publtime=' . intval($rowcontent['publtime']) . ',
					 exptime=' . intval($rowcontent['exptime']) . ',
					 archive=' . intval($rowcontent['archive']) . ',
					 title=:title,
					 alias=:alias,
					 hometext=:hometext,
					 vid_path=:vid_path,
					 vid_duration=:vid_duration,
					 vid_type=:vid_type,
					 homeimgfile=:homeimgfile,
					 homeimgalt=:homeimgalt,
					 homeimgthumb=:homeimgthumb,
					 inhome=' . intval($rowcontent['inhome']) . ',
					 allowed_comm=:allowed_comm,
					 allowed_rating=' . intval($rowcontent['allowed_rating']) . ',
					 edittime=' . NV_CURRENTTIME . '
				WHERE id =' . $rowcontent['id']);
            
            $sth->bindParam(':listcatid', $rowcontent['listcatid'], PDO::PARAM_STR);
            $sth->bindParam(':author', $rowcontent['author'], PDO::PARAM_STR);
            $sth->bindParam(':artist', $rowcontent['artist'], PDO::PARAM_STR);
            $sth->bindParam(':title', $rowcontent['title'], PDO::PARAM_STR);
            $sth->bindParam(':alias', $rowcontent['alias'], PDO::PARAM_STR);
            $sth->bindParam(':hometext', $rowcontent['hometext'], PDO::PARAM_STR, strlen($rowcontent['hometext']));
            $sth->bindParam(':vid_path', $rowcontent['vid_path'], PDO::PARAM_STR);
            $sth->bindParam(':vid_duration', $rowcontent['vid_duration'], PDO::PARAM_STR);
            $sth->bindParam(':vid_type', $rowcontent['vid_type'], PDO::PARAM_STR);
            $sth->bindParam(':homeimgfile', $rowcontent['homeimgfile'], PDO::PARAM_STR);
            $sth->bindParam(':homeimgalt', $rowcontent['homeimgalt'], PDO::PARAM_STR);
            $sth->bindParam(':homeimgthumb', $rowcontent['homeimgthumb'], PDO::PARAM_STR);
            $sth->bindParam(':allowed_comm', $rowcontent['allowed_comm'], PDO::PARAM_STR);
            
            if ($sth->execute()) {
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['content_edit'], $rowcontent['title'], $admin_info['userid']);
                
                $ct_query = array();
                $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_detail SET
					bodyhtml=:bodyhtml,
					sourcetext=:sourcetext,
					copyright=' . intval($rowcontent['copyright']) . ',
					allowed_send=' . intval($rowcontent['allowed_send']) . ',
					allowed_save=' . intval($rowcontent['allowed_save']) . ',
					gid=' . intval($rowcontent['gid']) . '
				WHERE id =' . $rowcontent['id']);
                
                $sth->bindParam(':bodyhtml', $rowcontent['bodyhtml'], PDO::PARAM_STR, strlen($rowcontent['bodyhtml']));
                $sth->bindParam(':sourcetext', $rowcontent['sourcetext'], PDO::PARAM_STR, strlen($rowcontent['sourcetext']));
                
                $ct_query[] = (int) $sth->execute();
                
                if ($rowcontent_old['listcatid'] != $rowcontent['listcatid']) {
                    $array_cat_old = explode(',', $rowcontent_old['listcatid']);
                    $array_cat_new = explode(',', $rowcontent['listcatid']);
                    $array_cat_diff = array_diff($array_cat_old, $array_cat_new);
                    foreach ($array_cat_diff as $catid) {
                        if (! empty($catid)) {
                            $ct_query[] = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid . ' WHERE id = ' . intval($rowcontent['id']));
                        }
                    }
                }
                
                foreach ($catids as $catid) {
                    if (! empty($catid)) {
                        $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid . ' WHERE id = ' . $rowcontent['id']);
                        $ct_query[] = $db->exec('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid . ' SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $rowcontent['id']);
                    }
                }
                
                if (array_sum($ct_query) != sizeof($ct_query)) {
                    $error[] = $lang_module['errorsave'];
                }
            } else {
                $error[] = $lang_module['errorsave'];
            }
        }
        
        nv_set_status_module();
        if (empty($error)) {
            $id_block_content_new = $rowcontent['mode'] == 'edit' ? array_diff($id_block_content_post, $id_block_content) : $id_block_content_post;
            $id_block_content_del = $rowcontent['mode'] == 'edit' ? array_diff($id_block_content, $id_block_content_post) : array();
            
            $array_block_fix = array();
            foreach ($id_block_content_new as $bid_i) {
                $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_block (bid, id, weight) VALUES (' . $bid_i . ', ' . $rowcontent['id'] . ', 0)');
                $array_block_fix[] = $bid_i;
            }
            foreach ($id_block_content_del as $bid_i) {
                $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE id = ' . $rowcontent['id'] . ' AND bid = ' . $bid_i);
                $array_block_fix[] = $bid_i;
            }
            
            $array_block_fix = array_unique($array_block_fix);
            foreach ($array_block_fix as $bid_i) {
                nv_videos_fix_block($bid_i, false);
            }
            
            // Playlist
            
            $id_playlist_content_new = $rowcontent['mode'] == 'edit' ? array_diff($id_playlist_content_post, $id_playlist_content) : $id_playlist_content_post;
            $id_playlist_content_del = $rowcontent['mode'] == 'edit' ? array_diff($id_playlist_content, $id_playlist_content_post) : array();
            
            $array_playlist_fix = array();
            foreach ($id_playlist_content_new as $playlist_id_i) {
                $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_playlist (playlist_id, id, playlist_sort) VALUES (' . $playlist_id_i . ', ' . $rowcontent['id'] . ', 0)');
                $array_playlist_fix[] = $playlist_id_i;
            }
            foreach ($id_playlist_content_del as $playlist_id_i) {
                $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist WHERE id = ' . $rowcontent['id'] . ' AND playlist_id = ' . $playlist_id_i);
                $array_playlist_fix[] = $playlist_id_i;
            }
            
            $array_playlist_fix = array_unique($array_playlist_fix);
            foreach ($array_playlist_fix as $playlist_id_i) {
                nv_videos_fix_playlist($playlist_id_i, false);
            }
            
            if ($rowcontent['keywords'] != $rowcontent['keywords_old']) {
                $keywords = explode(',', $rowcontent['keywords']);
                $keywords = array_map('strip_punctuation', $keywords);
                $keywords = array_map('trim', $keywords);
                $keywords = array_diff($keywords, array(
                    ''
                ));
                $keywords = array_unique($keywords);
                
                foreach ($keywords as $keyword) {
                    if (! in_array($keyword, $array_keywords_old)) {
                        $alias_i = nv_strtolower(change_alias($keyword));
                        $sth = $db->prepare('SELECT tid, alias, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags where alias= :alias OR FIND_IN_SET(:keyword, keywords)>0');
                        $sth->bindParam(':alias', $alias_i, PDO::PARAM_STR);
                        $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                        $sth->execute();
                        
                        list ($tid, $alias, $keywords_i) = $sth->fetch(3);
                        if (empty($tid)) {
                            $array_insert = array();
                            $array_insert['alias'] = $alias_i;
                            $array_insert['keyword'] = $keyword;
                            
                            $tid = $db->insert_id("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_tags (numnews, alias, description, image, keywords) VALUES (1, :alias, '', '', :keyword)", "tid", $array_insert);
                        } else {
                            if ($alias != $alias_i) {
                                if (! empty($keywords_i)) {
                                    $keyword_arr = explode(',', $keywords_i);
                                    $keyword_arr[] = $keyword;
                                    $keywords_i2 = implode(',', array_unique($keyword_arr));
                                } else {
                                    $keywords_i2 = $keyword;
                                }
                                if ($keywords_i != $keywords_i2) {
                                    $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET keywords= :keywords WHERE tid =' . $tid);
                                    $sth->bindParam(':keywords', $keywords_i2, PDO::PARAM_STR);
                                    $sth->execute();
                                }
                            }
                            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET numnews = numnews+1 WHERE tid = ' . $tid);
                        }
                        
                        // insert keyword for table _tags_id
                        try {
                            $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id (id, tid, keyword) VALUES (' . $rowcontent['id'] . ', ' . intval($tid) . ', :keyword)');
                            $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                            $sth->execute();
                        } catch (PDOException $e) {
                            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id SET keyword = :keyword WHERE id = ' . $rowcontent['id'] . ' AND tid=' . intval($tid));
                            $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                            $sth->execute();
                        }
                        unset($array_keywords_old[$tid]);
                    }
                }
                
                foreach ($array_keywords_old as $tid => $keyword) {
                    if (! in_array($keyword, $keywords)) {
                        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET numnews = numnews-1 WHERE tid = ' . $tid);
                        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id = ' . $rowcontent['id'] . ' AND tid=' . $tid);
                    }
                }
            }
            
            if (isset($module_config['seotools']['prcservice']) and ! empty($module_config['seotools']['prcservice']) and $rowcontent['status'] == 1 and $rowcontent['publtime'] < NV_CURRENTTIME + 1 and ($rowcontent['exptime'] == 0 or $rowcontent['exptime'] > NV_CURRENTTIME + 1)) {
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=rpc&id=' . $rowcontent['id'] . '&rand=' . nv_genpass());
                die();
            } else {
                $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
                $msg1 = $lang_module['content_saveok'];
                $msg2 = $lang_module['content_main'] . ' ' . $module_info['custom_title'];
                redriect($msg1, $msg2, $url, $module_data . '_detail');
            }
        }
    } else {
        $url = 'javascript: history.go(-1)';
        $msg1 = implode('<br />', $error);
        $msg2 = $lang_module['content_back'];
        redriect($msg1, $msg2, $url, $module_data . '_detail', 'back');
    }
    $id_block_content = $id_block_content_post;
}

$rowcontent['hometext'] = nv_htmlspecialchars(nv_br2nl($rowcontent['hometext']));
$rowcontent['bodyhtml'] = htmlspecialchars(nv_editor_br2nl($rowcontent['bodyhtml']));

if (! empty($rowcontent['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/img/' . $rowcontent['homeimgfile'])) {
    $rowcontent['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $rowcontent['homeimgfile'];
}

if (! empty($rowcontent['vid_path']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/vid/' . $rowcontent['vid_path'])) {
    $rowcontent['vid_path'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/vid/' . $rowcontent['vid_path'];
}

$array_catid_in_row = explode(',', $rowcontent['listcatid']);

$sql = 'SELECT sourceid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources ORDER BY weight ASC';
$result = $db->query($sql);
$array_source_module = array();
$array_source_module[0] = $lang_module['sources_sl'];
while (list ($sourceid_i, $title_i) = $result->fetch(3)) {
    $array_source_module[$sourceid_i] = $title_i;
}

$tdate = date('H|i', $rowcontent['publtime']);
$publ_date = date('d/m/Y', $rowcontent['publtime']);
list ($phour, $pmin) = explode('|', $tdate);
if ($rowcontent['exptime'] == 0) {
    $emin = $ehour = 0;
    $exp_date = '';
} else {
    $exp_date = date('d/m/Y', $rowcontent['exptime']);
    $tdate = date('H|i', $rowcontent['exptime']);
    list ($ehour, $emin) = explode('|', $tdate);
}

if ($rowcontent['status'] == 1 and $rowcontent['publtime'] > NV_CURRENTTIME) {
    $array_cat_check_content = $array_cat_pub_content;
} elseif ($rowcontent['status'] == 1) {
    $array_cat_check_content = $array_cat_edit_content;
} else {
    $array_cat_check_content = $array_cat_add_content;
}

if (empty($array_cat_check_content)) {
    $redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat';
    
    $contents = '<div class="alert alert-info"><p class="no_cat">' . $lang_module['note_cat'] . '</p><br/>
	<img class="center-block" src="' . NV_BASE_SITEURL . NV_ASSETS_DIR . '/images/load_bar.gif"/>
	</div>';
    $contents .= "<meta http-equiv=\"refresh\" content=\"5;URL=" . $redirect . "\" />";
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    die();
}
$contents = '';

$lang_global['title_suggest_max'] = sprintf($lang_global['length_suggest_max'], 65);
$lang_global['description_suggest_max'] = sprintf($lang_global['length_suggest_max'], 160);

$xtpl = new XTemplate('content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('rowcontent', $rowcontent);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('module_name', $module_name);

foreach ($global_array_cat as $catid_i => $array_value) {
    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_show = 1;
    } else {
        $array_cat = GetCatidInParent($catid_i);
        $check_show = array_intersect($array_cat, $array_cat_check_content);
    }
    if (! empty($check_show)) {
        $space = intval($array_value['lev']) * 30;
        $catiddisplay = (sizeof($array_catid_in_row) > 1 and (in_array($catid_i, $array_catid_in_row))) ? '' : ' display: none;';
        $temp = array(
            'catid' => $catid_i,
            'space' => $space,
            'title' => $array_value['title'],
            'disabled' => (! in_array($catid_i, $array_cat_check_content)) ? ' disabled="disabled"' : '',
            'checked' => (in_array($catid_i, $array_catid_in_row)) ? ' checked="checked"' : '',
            'catidchecked' => ($catid_i == $rowcontent['catid']) ? ' checked="checked"' : '',
            'catiddisplay' => $catiddisplay
        );
        $xtpl->assign('CATS', $temp);
        $xtpl->parse('main.catid');
    }
}

// Copyright
$checkcop = ($rowcontent['copyright']) ? ' checked="checked"' : '';
$xtpl->assign('checkcop', $checkcop);

// time update
$xtpl->assign('publ_date', $publ_date);
$select = '';
for ($i = 0; $i <= 23; ++ $i) {
    $select .= "<option value=\"" . $i . "\"" . (($i == $phour) ? ' selected="selected"' : '') . ">" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>\n";
}
$xtpl->assign('phour', $select);
$select = '';
for ($i = 0; $i < 60; ++ $i) {
    $select .= "<option value=\"" . $i . "\"" . (($i == $pmin) ? ' selected="selected"' : '') . ">" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>\n";
}
$xtpl->assign('pmin', $select);

// time exp
$xtpl->assign('exp_date', $exp_date);
$select = '';
for ($i = 0; $i <= 23; ++ $i) {
    $select .= "<option value=\"" . $i . "\"" . (($i == $ehour) ? ' selected="selected"' : '') . ">" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>\n";
}
$xtpl->assign('ehour', $select);
$select = '';
for ($i = 0; $i < 60; ++ $i) {
    $select .= "<option value=\"" . $i . "\"" . (($i == $emin) ? ' selected="selected"' : '') . ">" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>\n";
}
$xtpl->assign('emin', $select);

// allowed comm
$allowed_comm = explode(',', $rowcontent['allowed_comm']);
foreach ($groups_list as $_group_id => $_title) {
    $xtpl->assign('ALLOWED_COMM', array(
        'value' => $_group_id,
        'checked' => in_array($_group_id, $allowed_comm) ? ' checked="checked"' : '',
        'title' => $_title
    ));
    $xtpl->parse('main.allowed_comm');
}
if ($module_config[$module_name]['allowed_comm'] != '-1') {
    $xtpl->parse('main.content_note_comm');
}

// source
$select = '';
foreach ($array_source_module as $sourceid_i => $source_title_i) {
    $source_sl = ($sourceid_i == $rowcontent['sourceid']) ? ' selected="selected"' : '';
    $select .= "<option value=\"" . $sourceid_i . "\" " . $source_sl . ">" . $source_title_i . "</option>\n";
}
$xtpl->assign('sourceid', $select);

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $edits = nv_aleditor('bodyhtml', '100%', '400px', $rowcontent['bodyhtml'], '', $uploads_dir_user, $currentpath);
} else {
    $edits = "<textarea style=\"width: 100%\" name=\"bodyhtml\" id=\"bodyhtml\" cols=\"20\" rows=\"15\">" . $rowcontent['bodyhtml'] . "</textarea>";
}

$shtm = '';
if (sizeof($array_block_cat_module)) {
    foreach ($array_block_cat_module as $bid_i => $bid_title) {
        $xtpl->assign('BLOCKS', array(
            'title' => $bid_title,
            'bid' => $bid_i,
            'checked' => in_array($bid_i, $id_block_content) ? 'checked="checked"' : ''
        ));
        $xtpl->parse('main.block_cat.loop');
    }
    $xtpl->parse('main.block_cat');
}
// Playlist
if (sizeof($array_playlist_cat_module)) {
    foreach ($array_playlist_cat_module as $playlist_id_i => $playlist_title) {
        $xtpl->assign('PLAYLISTS', array(
            'title' => $playlist_title,
            'playlist_id' => $playlist_id_i,
            'selected' => in_array($playlist_id_i, $id_playlist_content) ? 'selected="selected"' : ''
        ));
        $xtpl->parse('main.playlist_cat.loop');
    }
    $xtpl->parse('main.playlist_cat');
}

if (! empty($rowcontent['keywords'])) {
    $keywords_array = explode(',', $rowcontent['keywords']);
    foreach ($keywords_array as $keywords) {
        $xtpl->assign('KEYWORDS', $keywords);
        $xtpl->parse('main.keywords');
    }
}
$archive_checked = ($rowcontent['archive']) ? ' checked="checked"' : '';
$xtpl->assign('archive_checked', $archive_checked);
$inhome_checked = ($rowcontent['inhome']) ? ' checked="checked"' : '';
$xtpl->assign('inhome_checked', $inhome_checked);
$allowed_rating_checked = ($rowcontent['allowed_rating']) ? ' checked="checked"' : '';
$xtpl->assign('allowed_rating_checked', $allowed_rating_checked);
$allowed_send_checked = ($rowcontent['allowed_send']) ? ' checked="checked"' : '';
$xtpl->assign('allowed_send_checked', $allowed_send_checked);
$allowed_save_checked = ($rowcontent['allowed_save']) ? ' checked="checked"' : '';
$xtpl->assign('allowed_save_checked', $allowed_save_checked);

$xtpl->assign('edit_bodytext', $edits);

if (! empty($error)) {
    $xtpl->assign('error', implode('<br />', $error));
    $xtpl->parse('main.error');
}

if (defined('NV_IS_ADMIN_MODULE') || ! empty($array_pub_content)) // toan quyen module
{
    if ($rowcontent['status'] == 1 and $rowcontent['id'] > 0) {
        $xtpl->parse('main.status');
        if ($report) {
            $xtpl->parse('main.is_del_report');
        }
    } else {
        $xtpl->parse('main.status0');
    }
} else {
    // gioi hoan quyen
    if ($rowcontent['status'] == 1 and $rowcontent['id'] > 0) {
        $xtpl->parse('main.status');
    } elseif (! empty($array_cat_pub_content)) // neu co quyen dang bai
{
        $xtpl->parse('main.status0');
    } else {
        if (! empty($array_censor_content)) // neu co quyen duyet bai thi
{
            $xtpl->parse('main.status1.status0');
        }
        $xtpl->parse('main.status1');
    }
}
if (empty($rowcontent['alias'])) {
    $xtpl->parse('main.getalias');
}
if (empty($rowcontent['vid_duration'])) {
    $xtpl->parse('main.get_duration');
}
$xtpl->assign('UPLOADS_DIR_USER', $uploads_dir_user);
$xtpl->assign('UPLOADS_DIR_FILE_USER', $uploads_dir_file_user);
$xtpl->assign('UPLOAD_CURRENT', $currentpath);
$xtpl->assign('UPLOAD_FILE_PATH', $file_path);

if ($module_config[$module_name]['auto_tags']) {
    $xtpl->parse('main.auto_tags');
}

$xtpl->parse('main');
$contents .= $xtpl->text('main');

if ($rowcontent['id'] > 0) {
    $op = '';
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';