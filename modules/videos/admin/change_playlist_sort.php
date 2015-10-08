<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );

$playlist_id = $nv_Request->get_int( 'playlist_id', 'post', 0 );
$news_id = $nv_Request->get_int( 'news_id', 'post', 0 );
$mod = $nv_Request->get_string( 'mod', 'post', '' );
$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );

if( empty( $news_id ) ) die( 'NO_' . $news_id );
$content = 'NO_' . $news_id;

if( $mod == 'playlist_sort' and $new_vid > 0 )
{
	$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE playlist_id=' . $playlist_id . ' AND id='. $news_id;
	$numrows = $db->query( $sql )->fetchColumn();
	if( $numrows != 1 ) die( 'NO_' . $news_id );

	$sql = 'SELECT id, catid, playlist_id, playlist_sort FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE playlist_id=' . $playlist_id . ' AND id!='. $news_id.' ORDER BY playlist_sort ASC';
	$result = $db->query( $sql );

	$playlist_sort = 0;
	while( $row = $result->fetch() )
	{
		++$playlist_sort;
		if( $playlist_sort == $new_vid ) ++$playlist_sort;
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET playlist_sort=' . $playlist_sort . ' WHERE playlist_id=' . $row['playlist_id'].' AND id='.$row['id'];
		$db->query( $sql );
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_'. $row['catid'] . ' SET playlist_sort=' . $playlist_sort . ' WHERE playlist_id=' . $row['playlist_id'].' AND id='.$row['id'];
		$db->query( $sql );
	}

	$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET playlist_sort=' . $new_vid . ' WHERE playlist_id=' . $playlist_id .' AND id='.$news_id;
	$db->query( $sql );
	
	$sql_fix = 'SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE playlist_id=' . $playlist_id . ' AND id='. $news_id;
	$cats = $db->query( $sql_fix );
	while( $fix = $cats->fetch() )
	{
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_'. $fix['catid'] .' SET playlist_sort=' . $new_vid . ' WHERE playlist_id=' . $playlist_id .' AND id='.$news_id;
		$db->query( $sql );
	}

	$content = 'OK_' . $news_id;
	nv_del_moduleCache( $module_name );
}

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';