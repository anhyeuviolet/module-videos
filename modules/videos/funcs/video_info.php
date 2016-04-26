<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12-11-2010 20:40
 */

if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

if( $nv_Request->isset_request( 'get_alias', 'post' ) )
{
	$title = $nv_Request->get_title( 'get_alias', 'post', '' );
	$alias = change_alias( $title );
	$alias = strtolower( $alias );

	include NV_ROOTDIR . '/includes/header.php';
	echo $alias;
	include NV_ROOTDIR . '/includes/footer.php';
}

if( $nv_Request->isset_request( 'get_duration', 'post' ) )
{
	$path = $nv_Request->get_string( 'get_duration', 'post', '' );
	$mod = $nv_Request->get_string( 'mod', 'post', '' );
	$path = urldecode($path);
	if( !empty($path) AND is_youtube($path) )
	{
		$_vid_duration = youtubeVideoDuration($path);
		$duration = sec2hms($_vid_duration);
	}
	else
	{
		$duration = '';
	}

	include NV_ROOTDIR . '/includes/header.php';
	echo $duration;
	include NV_ROOTDIR . '/includes/footer.php';
}
