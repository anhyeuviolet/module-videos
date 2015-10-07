<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['playlists'];

$error = '';
$savecat = 0;

$array = array();
$array['playlist_id'] = 0;
$array['title'] = '';
$array['alias'] = '';
$array['image'] = '';
$array['description'] = '';
$array['keywords'] = '';

$savecat = $nv_Request->get_int( 'savecat', 'post', 0 );
if( ! empty( $savecat ) )
{
	$array['playlist_id'] = $nv_Request->get_int( 'playlist_id', 'post', 0 );
	$array['title'] = $nv_Request->get_title( 'title', 'post', '', 1 );
	$array['keywords'] = $nv_Request->get_title( 'keywords', 'post', '', 1 );
	$array['alias'] = $nv_Request->get_title( 'alias', 'post', '' );
	$array['description'] = $nv_Request->get_string( 'description', 'post', '' );

	$array['description'] = strip_tags( $array['description'] );
	$array['description'] = nv_nl2br( nv_htmlspecialchars( $array['description'] ), '<br />' );

	// Xu ly anh minh hoa
	$array['image'] = $nv_Request->get_title( 'homeimg', 'post', '' );
	if( ! nv_is_url( $array['image'] ) and file_exists( NV_DOCUMENT_ROOT . $array['image'] ) )
	{
		$lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/playlists/' );
		$array['image'] = substr( $array['image'], $lu );
	}
	else
	{
		$array['image'] = '';
	}

	$array['alias'] = ( $array['alias'] == '' ) ? change_alias( $array['title'] ) : change_alias( $array['alias'] );

	if( empty( $array['title'] ) )
	{
		$error = $lang_module['playlists_error_title'];
	}
	elseif( $array['playlist_id'] == 0 )
	{
		$weight = $db->query( "SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists" )->fetchColumn();
		$weight = intval( $weight ) + 1;

		$_sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_playlists (title, alias, description, image, weight, keywords, add_time, edit_time) VALUES ( :title, :alias, :description, :image, :weight, :keywords, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
		$data_insert = array();
		$data_insert['title'] = $array['title'];
		$data_insert['alias'] = $array['alias'];
		$data_insert['description'] = $array['description'];
		$data_insert['image'] = $array['image'];
		$data_insert['weight'] = $weight;
		$data_insert['keywords'] = $array['keywords'];

		if( $db->insert_id( $_sql, 'playlist_id', $data_insert ) )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_add_playlist', " ", $admin_info['userid'] );
			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
			die();
		}
		else
		{
			$error = $lang_module['errorsave'];
		}
	}
	else
	{
		$stmt = $db->prepare( "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_playlists SET title= :title, alias = :alias, description= :description, image = :image, keywords= :keywords, edit_time=" . NV_CURRENTTIME . " WHERE playlist_id =" . $array['playlist_id'] );
		$stmt->bindParam( ':title', $array['title'], PDO::PARAM_STR );
		$stmt->bindParam( ':alias', $array['alias'], PDO::PARAM_STR );
		$stmt->bindParam( ':description', $array['description'], PDO::PARAM_STR );
		$stmt->bindParam( ':image', $array['image'], PDO::PARAM_STR );
		$stmt->bindParam( ':keywords', $array['keywords'], PDO::PARAM_STR );

		if( $stmt->execute() )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_edit_playlist', "playlist_id " . $array['playlist_id'], $admin_info['userid'] );
			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		}
		else
		{
			$error = $lang_module['errorsave'];
		}
	}
}

$array['playlist_id'] = $nv_Request->get_int( 'playlist_id', 'get', 0 );
if( $array['playlist_id'] > 0 )
{
	list( $array['playlist_id'], $array['title'], $array['alias'], $array['image'], $array['description'], $array['keywords'] ) = $db->query( "SELECT playlist_id, title, alias, image, description, keywords FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists where playlist_id=" . $array['playlist_id'] )->fetch( 3 );
	$lang_module['add_playlist'] = $lang_module['edit_playlist'];
}

if( is_file( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/playlists/' . $array['image'] ) )
{
	$array['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/playlists/' . $array['image'];
}

$xtpl = new XTemplate( 'playlists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'UPLOADS_DIR', NV_UPLOADS_DIR . '/' . $module_upload . '/playlists' );
$xtpl->assign( 'DATA', $array );
$xtpl->assign( 'PLAYLIST_LIST', nv_show_playlists_list() );

if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', $error );
	$xtpl->parse( 'main.error' );
}

if( empty( $array['alias'] ) )
{
	$xtpl->parse( 'main.getalias' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';