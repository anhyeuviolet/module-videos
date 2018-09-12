<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */
if (! defined('NV_ADMIN') or ! defined('NV_MAINFILE') or ! defined('NV_IS_MODADMIN'))
    die('Stop!!!');

if ($NV_IS_ADMIN_MODULE) {
    define('NV_IS_ADMIN_MODULE', true);
}

if ($NV_IS_ADMIN_FULL_MODULE) {
    define('NV_IS_ADMIN_FULL_MODULE', true);
}

$array_viewcat_full = array(
    'viewgrid_by_cat' => $lang_module['viewgrid_by_cat'],
    'viewcat_page_new' => $lang_module['viewcat_page_new'],
    'viewcat_page_old' => $lang_module['viewcat_page_old'],
    'viewcat_grid_new' => $lang_module['viewcat_grid_new'],
    'viewcat_grid_old' => $lang_module['viewcat_grid_old'],
    'viewcat_none' => $lang_module['viewcat_none']
);
$array_viewcat_nosub = array(
    'viewcat_page_new' => $lang_module['viewcat_page_new'],
    'viewcat_page_old' => $lang_module['viewcat_page_old'],
    'viewcat_grid_new' => $lang_module['viewcat_grid_new'],
    'viewcat_grid_old' => $lang_module['viewcat_grid_old']
);

$array_allowed_comm = array(
    $lang_global['no'],
    $lang_global['level6'],
    $lang_global['level4']
);

define('NV_IS_FILE_ADMIN', true);
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

global $global_array_cat;
$global_array_cat = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
$result = $db->query($sql);
while ($row = $result->fetch()) {
    $global_array_cat[$row['catid']] = $row;
}

$global_array_uploader = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_uploaders ORDER BY userid ASC';
$list = $nv_Cache->db($sql, 'userid', $module_name);
foreach ($list as $l) {
    $global_array_uploader[$l['userid']] = $l;
    $global_array_uploader[$l['userid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['uploader'] . '/' . $l['username'];
    $global_array_uploader[$l['userid']]['uploader_name'] = nv_show_name_user($l['first_name'], $l['last_name'], $l['username']);
    $global_array_uploader[$l['userid']]['uploader_list'] = $global_array_uploader[$l['userid']]['link'] . '/list';
    $global_array_uploader[$l['userid']]['uploader_editinfo'] = $global_array_uploader[$l['userid']]['link'] . '/editinfo';
    $global_array_uploader[$l['userid']]['uploader_gravatar'] = get_gravatar($global_array_uploader[$l['userid']]['email']);
}
unset($sql, $list);

/**
 * nv_fix_cat_order()
 *
 * @param integer $parentid            
 * @param integer $order          
 * @param integer $lev
 * @return
 *
 */
function nv_fix_cat_order($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $module_data;
    
    $sql = 'SELECT catid, parentid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_cat_order = array();
    while ($row = $result->fetch()) {
        $array_cat_order[] = $row['catid'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++ $lev;
    } else {
        $lev = 0;
    }
    foreach ($array_cat_order as $catid_i) {
        ++ $order;
        ++ $weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET weight=' . $weight . ', sort=' . $order . ', lev=' . $lev . ' WHERE catid=' . intval($catid_i);
        $db->query($sql);
        $order = nv_fix_cat_order($catid_i, $order, $lev);
    }
    $numsubcat = $weight;
    if ($parentid > 0) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET numsubcat=' . $numsubcat;
        if ($numsubcat == 0) {
            $sql .= ",subcatid='', viewcat='viewcat_page_new'";
        } else {
            $sql .= ",subcatid='" . implode(',', $array_cat_order) . "'";
        }
        $sql .= ' WHERE catid=' . intval($parentid);
        $db->query($sql);
    }
    return $order;
}

/**
 * nv_fix_playlist_cat()
 *
 * @return
 *
 */
function nv_fix_playlist_cat()
{
    global $db, $module_data;
    $sql = 'SELECT playlist_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++ $weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat SET weight=' . $weight . ' WHERE playlist_id=' . intval($row['playlist_id']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_fix_playlist()
 *
 * @param mixed $playlist_id            
 * @param bool $repairtable            
 * @return
 *
 */
function nv_fix_playlist($playlist_id, $repairtable = true)
{
    global $db, $module_data;
    $playlist_id = intval($playlist_id);
    if ($playlist_id > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist where playlist_id=' . $playlist_id . ' ORDER BY playlist_sort ASC';
        $result = $db->query($sql);
        $playlist_sort = 0;
        while ($row = $result->fetch()) {
            ++ $playlist_sort;
            if ($playlist_sort <= 100) {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist SET playlist_sort=' . $playlist_sort . ' WHERE playlist_id=' . $playlist_id . ' AND id=' . $row['id'];
            } else {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist WHERE playlist_id=' . $playlist_id . ' AND id=' . $row['id'];
            }
            $db->query($sql);
        }
        $result->closeCursor();
        if ($repairtable) {
            $db->query('OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist');
        }
    }
}

/**
 * nv_fix_block_cat()
 *
 * @return
 *
 */
function nv_fix_block_cat()
{
    global $db, $module_data;
    $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $weight = 0;
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        ++ $weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat SET weight=' . $weight . ' WHERE bid=' . intval($row['bid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_fix_source()
 *
 * @return
 *
 */
function nv_fix_source()
{
    global $db, $module_data;
    $sql = 'SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++ $weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sources SET weight=' . $weight . ' WHERE sourceid=' . intval($row['sourceid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_videos_fix_playlist()
 *
 * @param mixed $playlist_id            
 * @param bool $repairtable            
 * @return
 *
 */
function nv_videos_fix_playlist($playlist_id, $repairtable = true)
{
    global $db, $module_data;
    $playlist_id = intval($playlist_id);
    if ($playlist_id > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist where playlist_id=' . $playlist_id . ' ORDER BY playlist_sort ASC';
        $result = $db->query($sql);
        $playlist_sort = 0;
        while ($row = $result->fetch()) {
            ++ $playlist_sort;
            if ($playlist_sort <= 100) {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist SET playlist_sort=' . $playlist_sort . ' WHERE playlist_id=' . $playlist_id . ' AND id=' . $row['id'];
            } else {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist WHERE playlist_id=' . $playlist_id . ' AND id=' . $row['id'];
            }
            $db->query($sql);
        }
        $result->closeCursor();
        if ($repairtable) {
            $db->query('OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist');
        }
    }
}

/**
 * nv_videos_fix_block()
 *
 * @param mixed $bid            
 * @param bool $repairtable            
 * @return
 *
 */
function nv_videos_fix_block($bid, $repairtable = true)
{
    global $db, $module_data;
    $bid = intval($bid);
    if ($bid > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $bid . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++ $weight;
            if ($weight <= 100) {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block SET weight=' . $weight . ' WHERE bid=' . $bid . ' AND id=' . $row['id'];
            } else {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $bid . ' AND id=' . $row['id'];
            }
            $db->query($sql);
        }
        $result->closeCursor();
        if ($repairtable) {
            $db->query('OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_block');
        }
    }
}

/**
 * nv_show_cat_list()
 *
 * @param integer $parentid            
 * @return
 *
 */
function nv_show_cat_list($parentid = 0)
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_cat_admin, $global_array_cat, $admin_id, $global_config, $module_file;
    
    $xtpl = new XTemplate('cat_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    
    // Cac chu de co quyen han
    $array_cat_check_content = array();
    foreach ($global_array_cat as $catid_i => $array_value) {
        if (defined('NV_IS_ADMIN_MODULE')) {
            $array_cat_check_content[] = $catid_i;
        } elseif (isset($array_cat_admin[$admin_id][$catid_i])) {
            if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
                $array_cat_check_content[] = $catid_i;
            } elseif ($array_cat_admin[$admin_id][$catid_i]['add_content'] == 1) {
                $array_cat_check_content[] = $catid_i;
            } elseif ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1) {
                $array_cat_check_content[] = $catid_i;
            } elseif ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                $array_cat_check_content[] = $catid_i;
            }
        }
    }
    
    // Cac chu de co quyen han
    if ($parentid > 0) {
        $parentid_i = $parentid;
        $array_cat_title = array();
        while ($parentid_i > 0) {
            $array_cat_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $parentid_i . "\"><strong>" . $global_array_cat[$parentid_i]['title'] . "</strong></a>";
            $parentid_i = $global_array_cat[$parentid_i]['parentid'];
        }
        sort($array_cat_title, SORT_NUMERIC);
        
        $xtpl->assign('CAT_TITLE', implode(' &raquo; ', $array_cat_title));
        $xtpl->parse('main.cat_title');
    }
    
    $sql = 'SELECT catid, parentid, title, weight, viewcat, numsubcat, inhome, numlinks, newday FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE parentid = ' . $parentid . ' ORDER BY weight ASC';
    $rowall = $db->query($sql)->fetchAll(3);
    $num = sizeof($rowall);
    $a = 1;
    $array_inhome = array(
        $lang_global['no'],
        $lang_global['yes']
    );
    
    foreach ($rowall as $row) {
        list ($catid, $parentid, $title, $weight, $viewcat, $numsubcat, $inhome, $numlinks, $newday) = $row;
        if (defined('NV_IS_ADMIN_MODULE')) {
            $check_show = 1;
        } else {
            $array_cat = GetCatidInParent($catid);
            $check_show = array_intersect($array_cat, $array_cat_check_content);
        }
        
        if (! empty($check_show)) {
            $array_viewcat = ($numsubcat > 0) ? $array_viewcat_full : $array_viewcat_nosub;
            if (! array_key_exists($viewcat, $array_viewcat)) {
                $viewcat = 'viewcat_page_new';
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET viewcat= :viewcat WHERE catid=' . intval($catid));
                $stmt->bindParam(':viewcat', $viewcat, PDO::PARAM_STR);
                $stmt->execute();
            }
            
            $admin_funcs = array();
            $weight_disabled = $func_cat_disabled = true;
            if (defined('NV_IS_ADMIN_MODULE') or (isset($array_cat_admin[$admin_id][$catid]) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1)) {
                $func_cat_disabled = false;
                $admin_funcs[] = "<em class=\"fa fa-plus fa-lg\">&nbsp;</em> <a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;catid=" . $catid . "&amp;parentid=" . $parentid . "\">" . $lang_module['content_add'] . "</a>\n";
            }
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_cat_admin[$admin_id][$parentid]) and $array_cat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $func_cat_disabled = false;
                $admin_funcs[] = "<em class=\"fa fa-edit fa-lg\">&nbsp;</em> <a class=\"\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;catid=" . $catid . "&amp;parentid=" . $parentid . "#edit\">" . $lang_global['edit'] . "</a>\n";
            }
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_cat_admin[$admin_id][$parentid]) and $array_cat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $weight_disabled = false;
                $admin_funcs[] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_cat(" . $catid . ")\">" . $lang_global['delete'] . "</a>";
            }
            
            $xtpl->assign('ROW', array(
                'catid' => $catid,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat&amp;parentid=' . $catid,
                'title' => $title,
                'adminfuncs' => implode('&nbsp;-&nbsp;', $admin_funcs)
            ));
            
            if ($weight_disabled) {
                $xtpl->assign('STT', $a);
                $xtpl->parse('main.data.loop.stt');
            } else {
                for ($i = 1; $i <= $num; ++ $i) {
                    $xtpl->assign('WEIGHT', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $weight ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.weight.loop');
                }
                $xtpl->parse('main.data.loop.weight');
            }
            
            if ($func_cat_disabled) {
                $xtpl->assign('INHOME', $array_inhome[$inhome]);
                $xtpl->parse('main.data.loop.disabled_inhome');
                
                $xtpl->assign('VIEWCAT', $array_viewcat[$viewcat]);
                $xtpl->parse('main.data.loop.disabled_viewcat');
                
                $xtpl->assign('NUMLINKS', $numlinks);
                $xtpl->parse('main.data.loop.title_numlinks');
                
                $xtpl->assign('NEWDAY', $newday);
                $xtpl->parse('main.data.loop.title_newday');
            } else {
                foreach ($array_inhome as $key => $val) {
                    $xtpl->assign('INHOME', array(
                        'key' => $key,
                        'title' => $val,
                        'selected' => $key == $inhome ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.inhome.loop');
                }
                $xtpl->parse('main.data.loop.inhome');
                
                foreach ($array_viewcat as $key => $val) {
                    $xtpl->assign('VIEWCAT', array(
                        'key' => $key,
                        'title' => $val,
                        'selected' => $key == $viewcat ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.viewcat.loop');
                }
                $xtpl->parse('main.data.loop.viewcat');
                
                for ($i = 1; $i <= 20; ++ $i) {
                    $xtpl->assign('NUMLINKS', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $numlinks ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.numlinks.loop');
                }
                $xtpl->parse('main.data.loop.numlinks');
                
                for ($i = 1; $i <= 10; ++ $i) {
                    $xtpl->assign('NEWDAY', array(
                        'key' => $i,
                        'title' => $i,
                        'selected' => $i == $newday ? ' selected="selected"' : ''
                    ));
                    $xtpl->parse('main.data.loop.newday.loop');
                }
                $xtpl->parse('main.data.loop.newday');
            }
            
            if ($numsubcat) {
                $xtpl->assign('NUMSUBCAT', $numsubcat);
                $xtpl->parse('main.data.loop.numsubcat');
            }
            
            $xtpl->parse('main.data.loop');
            ++ $a;
        }
    }
    
    if ($num > 0) {
        $xtpl->parse('main.data');
    }
    
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    
    return $contents;
}

/**
 * nv_show_playlist_list()
 *
 * @param mixed $playlist_id            
 * @return
 *
 */
function nv_show_playlist_list($playlist_id)
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $global_array_cat, $module_file, $global_config;
    
    $xtpl = new XTemplate('playlist_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('PLAYLIST_ID', $playlist_id);
    
    $global_array_cat[0] = array(
        'alias' => 'Other'
    );
    
    $sql = 'SELECT t1.id, t1.catid, t1.title, t1.alias, t2.playlist_sort FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_playlist t2 ON t1.id = t2.id WHERE t2.playlist_id= ' . $playlist_id . ' AND t1.status=1 ORDER BY t2.playlist_sort ASC';
    $array_block = $db->query($sql)->fetchAll();
    
    $num = sizeof($array_block);
    if ($num > 0) {
        foreach ($array_block as $row) {
            $xtpl->assign('ROW', array(
                'id' => $row['id'],
                'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'],
                'title' => $row['title']
            ));
            
            for ($i = 1; $i <= $num; ++ $i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['playlist_sort'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.playlist_sort');
            }
            
            $xtpl->parse('main.loop');
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $xtpl->parse('no_video');
        $contents = $xtpl->text('no_video');
    }
    return $contents;
}

/**
 * nv_show_playlist_cat_list()
 * $page
 * 
 * @return
 *
 */
function nv_show_playlist_cat_list($page)
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info, $nv_Request;
    
    $base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . '&' . NV_OP_VARIABLE . '=playlists';
    $page = $nv_Request->get_int('page', 'get', 1);
    $list_per_page = 25;
    $all_page = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat')->fetchColumn();
    
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat ORDER BY weight ASC LIMIT ' . ($page - 1) * $list_per_page . ', ' . $list_per_page;
    $_array_block_cat = $db->query($sql)->fetchAll();
    $num = sizeof($_array_block_cat);
    if ($page > 1)
        $num = ($num + (($page - 1) * $list_per_page));
    
    if ($num > 0) {
        $array_status = array(
            $lang_global['no'],
            $lang_global['yes'],
            $lang_module['playlist_waiting_approve']
        );
        
        $array_private_mode = array(
            $lang_module['playlist_private_off'],
            $lang_module['playlist_private_on']
        );
        $xtpl = new XTemplate('playlistcat_lists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('GLANG', $lang_global);
        $xtpl->assign('CUR_PAGE', $page);
        
        $generate_page = nv_generate_page($base_url, $all_page, $list_per_page, $page);
        
        foreach ($_array_block_cat as $row) {
            $numnews = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist where playlist_id=' . $row['playlist_id'])->fetchColumn();
            
            $xtpl->assign('ROW', array(
                'playlist_id' => $row['playlist_id'],
                'title' => $row['title'],
                'numnews' => $numnews,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=playlist&amp;playlist_id=' . $row['playlist_id'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['playlists'] . '/' . $row['alias'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['playlists'] . '&amp;playlist_id=' . $row['playlist_id'] . '#edit'
            ));
            
            for ($i = 1; $i <= $num; ++ $i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }
            
            foreach ($array_private_mode as $key => $val) {
                $xtpl->assign('PRIVATE_MODE', array(
                    'key' => $key,
                    'title' => $val,
                    'selected' => $key == $row['private_mode'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.private_mode');
            }
            
            foreach ($array_status as $key => $val) {
                $xtpl->assign('STATUS', array(
                    'key' => $key,
                    'title' => $val,
                    'selected' => $key == $row['status'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.status');
            }
            
            for ($i = 1; $i <= 30; ++ $i) {
                $xtpl->assign('NUMBER', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.number');
            }
            
            if ($row['status'] == 2) {
                $xtpl->parse('main.loop.pending');
            } elseif ($row['status'] == 0) {
                $xtpl->parse('main.loop.disable');
            }
            
            $xtpl->parse('main.loop');
        }
        
        if (! empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.generate_page');
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }
    
    return $contents;
}

/**
 * nv_show_block_cat_list()
 *
 * @return
 *
 */
function nv_show_block_cat_list()
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info;
    
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $_array_block_cat = $db->query($sql)->fetchAll();
    $num = sizeof($_array_block_cat);
    
    if ($num > 0) {
        $array_adddefault = array(
            $lang_global['no'],
            $lang_global['yes']
        );
        
        $xtpl = new XTemplate('blockcat_lists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('GLANG', $lang_global);
        
        foreach ($_array_block_cat as $row) {
            $numnews = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $row['bid'])->fetchColumn();
            
            $xtpl->assign('ROW', array(
                'bid' => $row['bid'],
                'title' => $row['title'],
                'numnews' => $numnews,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=block&amp;bid=' . $row['bid'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $row['alias'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;bid=' . $row['bid'] . '#edit'
            ));
            
            for ($i = 1; $i <= $num; ++ $i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }
            
            foreach ($array_adddefault as $key => $val) {
                $xtpl->assign('ADDDEFAULT', array(
                    'key' => $key,
                    'title' => $val,
                    'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.adddefault');
            }
            
            for ($i = 1; $i <= 30; ++ $i) {
                $xtpl->assign('NUMBER', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.number');
            }
            
            $xtpl->parse('main.loop');
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }
    
    return $contents;
}

/**
 * nv_show_sources_list()
 *
 * @return
 *
 */
function nv_show_sources_list()
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $nv_Request, $module_file, $global_config;
    
    $num = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_data . '&amp;' . NV_OP_VARIABLE . '=sources';
    $num_items = ($num > 1) ? $num : 1;
    $per_page = 15;
    $page = $nv_Request->get_int('page', 'get', 1);
    
    $xtpl = new XTemplate('sources_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    
    if ($num > 0) {
        $db->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_sources')
            ->order('weight')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
        
        $result = $db->query($db->sql());
        while ($row = $result->fetch()) {
            $xtpl->assign('ROW', array(
                'sourceid' => $row['sourceid'],
                'title' => $row['title'],
                'link' => $row['link'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=sources&amp;sourceid=' . $row['sourceid'] . '#edit'
            ));
            
            for ($i = 1; $i <= $num; ++ $i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }
            
            $xtpl->parse('main.loop');
        }
        $result->closeCursor();
        
        $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
        if (! empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.generate_page');
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }
    
    return $contents;
}

/**
 * nv_show_block_list()
 *
 * @param mixed $bid            
 * @return
 *
 */
function nv_show_block_list($bid)
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $global_array_cat, $module_file, $global_config;
    
    $xtpl = new XTemplate('block_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BID', $bid);
    
    $global_array_cat[0] = array(
        'alias' => 'Other'
    );
    
    $sql = 'SELECT t1.id, t1.catid, t1.title, t1.alias, t2.weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.id = t2.id WHERE t2.bid= ' . $bid . ' AND t1.status=1 ORDER BY t2.weight ASC';
    $array_block = $db->query($sql)->fetchAll();
    
    $num = sizeof($array_block);
    if ($num > 0) {
        foreach ($array_block as $row) {
            $xtpl->assign('ROW', array(
                'id' => $row['id'],
                'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'],
                'title' => $row['title']
            ));
            
            for ($i = 1; $i <= $num; ++ $i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }
            
            $xtpl->parse('main.loop');
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $xtpl->parse('no_video');
        $contents = $xtpl->text('no_video');
    }
    return $contents;
}

/**
 * GetCatidInParent()
 *
 * @param mixed $catid            
 * @return
 *
 */
function GetCatidInParent($catid)
{
    global $global_array_cat;
    $array_cat = array();
    $array_cat[] = $catid;
    $subcatid = explode(',', $global_array_cat[$catid]['subcatid']);
    if (! empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($global_array_cat[$id]['numsubcat'] == 0) {
                    $array_cat[] = $id;
                } else {
                    $array_cat_temp = GetCatidInParent($id);
                    foreach ($array_cat_temp as $catid_i) {
                        $array_cat[] = $catid_i;
                    }
                }
            }
        }
    }
    return array_unique($array_cat);
}

/**
 * redriect()
 *
 * @param string $msg1            
 * @param string $msg2            
 * @param mixed $nv_redirect            
 * @return
 *
 */
function redriect($msg1 = '', $msg2 = '', $nv_redirect, $autoSaveKey = '', $go_back = '')
{
    global $global_config, $module_file, $module_name;
    $xtpl = new XTemplate('redriect.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    
    if (empty($nv_redirect)) {
        $nv_redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
    }
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_REDIRECT', $nv_redirect);
    $xtpl->assign('MSG1', $msg1);
    $xtpl->assign('MSG2', $msg2);
    
    if (! empty($autoSaveKey)) {
        $xtpl->assign('AUTOSAVEKEY', $autoSaveKey);
        $xtpl->parse('main.removelocalstorage');
    }
    
    if ($go_back) {
        $xtpl->parse('main.go_back');
    } else {
        $xtpl->parse('main.meta_refresh');
    }
    
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}