<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_string( 'list', 'post,get' );
$id = explode( ',', $id );

foreach( $id as $value )
{
	$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET playlist_id=0 WHERE id='" . $value . "'";
	$db->query( $sql );
}

echo $lang_module['playlist_delete_success'];