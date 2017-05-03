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

$page_title = $lang_module['search_youtube'];
$key = $nv_Request->get_string ( 'q', 'get,post' );
$maxResults = $nv_Request->get_int ( 'maxResults', 'get,post' );
$error = '';

if(file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/vendor/autoload.php')){
	require_once NV_ROOTDIR . '/modules/' . $module_file . '/vendor/autoload.php';
}else{
	$error = $lang_module['missing_lib'];
}

$xtpl = new XTemplate ( 'search.tpl', NV_ROOTDIR . '/themes/' . $global_config ['module_theme'] . '/modules/' . $module_file );
$xtpl->assign ( 'LANG', $lang_module );
$xtpl->assign ( 'GLANG', $lang_global );
$xtpl->assign ( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign ( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign ( 'MODULE_NAME', $module_name );
$xtpl->assign ( 'OP', $op );

if (empty ( $error )) {
	$xtpl->parse ( 'main.form' );
}else{
	$xtpl->assign ( 'ERROR', $error );
	$xtpl->parse ( 'main.error' );
}

$xtpl->parse ( 'main' );
$contents = $xtpl->text ( 'main' );
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme ( $contents );
include NV_ROOTDIR . '/includes/footer.php';