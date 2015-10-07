<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$playlist_id = $nv_Request->get_int( 'playlist_id', 'get' );
$playlisttitle = $db->query( 'SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlists WHERE playlist_id =' . $playlist_id )->fetchColumn();
if( empty( $playlisttitle ) )
{
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=playlists' );
	die();
}

$page_title = $lang_module['playlist_page'] . ': ' . $playlisttitle;

$global_array_cat = array();

$sql = 'SELECT catid, alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
$result = $db->query( $sql );
while( list( $catid_i, $alias_i ) = $result->fetch( 3 ) )
{
	$global_array_cat[$catid_i] = array( 'alias' => $alias_i );
}

$sql = 'SELECT id, catid, alias, title, playlist_id, playlist_sort FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE playlist_id=' . $playlist_id . ' ORDER BY playlist_sort ASC';
$result = $db->query( $sql );

$xtpl = new XTemplate( 'playlistsnews.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'playlist_id', $playlist_id );

$_rows_playlist = $db->query( $sql )->fetchAll();
$num = sizeof( $_rows_playlist );

$i = 0;
foreach( $_rows_playlist as $row)
{
	++$i;
	$row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
	$row['delete'] = nv_link_edit_page( $row['id'] );
	$xtpl->assign( 'ROW', $row );
	for( $a = 1; $a <= $num; ++$a )
	{
		$xtpl->assign( 'PLAYLIST_SORT', array(
			'key' => $a,
			'title' => $a,
			'selected' => $a == $row['playlist_sort'] ? ' selected="selected"' : ''
		) );
		$xtpl->parse( 'main.data.loop.playlist_sort' );
	}

	$xtpl->parse( 'main.data.loop' );
}
$result->closeCursor();

if( $i )
{
	$xtpl->assign( 'URL_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=playlistdelnews' );
	$xtpl->parse( 'main.data' );
}
else
{
	$xtpl->parse( 'main.empty' );
}
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$set_active_op = 'playlists';
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';