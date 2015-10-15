<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

$show_no_image = $module_config[$module_name]['show_no_image'];

$array_mod_title[] = array(
	'catid' => 0,
	'title' => $module_info['funcs'][$op]['func_custom_name'],
	'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['playlists']
);

$alias = isset( $array_op[1] ) ? trim( $array_op[1] ) : '';
$playlist_array = array();

if( !empty( $alias ) )
{
	$page = ( isset( $array_op[2] ) and substr( $array_op[2], 0, 5 ) == 'page-' ) ? intval( substr( $array_op[2], 5 ) ) : 1;

	$stmt = $db->prepare( 'SELECT playlist_id, title, alias, image, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat WHERE alias= :alias' );
	$stmt->bindParam( ':alias', $alias, PDO::PARAM_STR );
	$stmt->execute();

	list( $playlist_id, $page_title, $alias, $playlist_image, $description, $key_words ) = $stmt->fetch( 3 );

	if( $playlist_id > 0 )
	{
		$base_url_rewrite = $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['playlists'] . '/' . $alias;
		if( $page > 1 )
		{
			$page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
			$base_url_rewrite .= '/page-' . $page;
		}
		$base_url_rewrite = nv_url_rewrite( $base_url_rewrite, true );
		if( $_SERVER['REQUEST_URI'] != $base_url_rewrite and NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite )
		{
			Header( 'Location: ' . $base_url_rewrite );
			die();
		}

		$array_mod_title[] = array(
			'catid' => 0,
			'title' => $page_title,
			'link' => $base_url
		);

		$item_array = array();
		$end_weight = 0;

		$db->sqlreset()
			->select( 'COUNT(*)' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_rows t1' )
			->join( 'INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_playlist t2 ON t1.id = t2.id' )
			->where( 't2.playlist_id= ' . $playlist_id . ' AND t1.status= 1' );

		$num_items = $db->query( $db->sql() )->fetchColumn();

		$db->select( 't1.id, t1.catid, t1.admin_id, t1.author, t1.sourceid, t1.addtime, t1.edittime, t1.publtime, t1.title, t1.alias, t1.hometext, t1.homeimgfile, t1.homeimgalt, t1.homeimgthumb, t1.allowed_rating, t1.hitstotal, t1.hitscm, t1.total_rating, t1.click_rating, t2.playlist_sort' )
			->order( 't2.playlist_sort ASC' )
			->limit( $per_page )
			->offset( ($page - 1) * $per_page );

		$end_publtime = 0;

		$result = $db->query( $db->sql() );
		while( $item = $result->fetch() )
		{
			if( $item['homeimgthumb'] == 1 )//image thumb
			{
				$item['src'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/img/' . $item['homeimgfile'];
			}
			elseif( $item['homeimgthumb'] == 2 )//image file
			{
				$item['src'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $item['homeimgfile'];
			}
			elseif( $item['homeimgthumb'] == 3 )//image url
			{
				$item['src'] = $item['homeimgfile'];
			}
			elseif( ! empty( $show_no_image ) )//no image
			{
				$item['src'] = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$item['imghome'] = '';
			}
			$item['alt'] = ! empty( $item['homeimgalt'] ) ? $item['homeimgalt'] : $item['title'];
			$item['width'] = $module_config[$module_name]['homewidth'];

			$end_publtime = $item['publtime'];

			$item['link'] = $global_array_cat[$item['catid']]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
			$playlist_array[] = $item;
		}
		$result->closeCursor();
		unset( $result, $row );

		$playlist_other_array = array();
		if ( $st_links > 0)
		{
			$db->sqlreset()
				->select( 'id, catid, addtime, edittime, publtime, title, alias, hitstotal' )
				->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
				->where( 'status=1 AND publtime < ' . $end_publtime )
				->order( 'publtime ASC' )
				->limit( $st_links );

			$result = $db->query( $db->sql() );
			while( $item = $result->fetch() )
			{
				$item['link'] = $global_array_cat[$item['catid']]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
				$playlist_other_array[] = $item;
			}
			unset( $result, $row );
		}

		$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );

		$pl_ss = md5( $playlist_id . session_id() . $global_config['sitekey'] );
		$contents = playlist_theme( $playlist_array, $playlist_other_array, $generate_page, $page_title, $description, $playlist_id, $pl_ss );
	}
	else
	{
		Header( 'Location: ' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['playlist'], true ) );
		exit();
	}
}
else
{
	$page_title = $module_info['custom_title'];
	$key_words = $module_info['keywords'];

	$result = $db->query( 'SELECT playlist_id as id, title, alias, image, description as hometext, keywords, add_time as publtime FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat WHERE status=1 AND private_mode=1 ORDER BY weight ASC' );
	while( $item = $result->fetch() )
	{
		if( ! empty( $item['image'] ) AND file_exists( NV_ROOTDIR. '/' . NV_FILES_DIR . '/' . $module_upload . '/playlists/' . $item['image'] ) )//image thumb
		{
			$item['src'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/playlists/' . $item['image'];
		}
		elseif( ! empty( $item['image'] ) )//image file
		{
			$item['src'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/playlists/' . $item['image'];
		}
		elseif( ! empty( $show_no_image ) )//no image
		{
			$item['src'] = NV_BASE_SITEURL . $show_no_image;
		}
		else
		{
			$item['src'] = '';
		}
		$item['alt'] = ! empty( $item['homeimgalt'] ) ? $item['homeimgalt'] : $item['title'];
		$item['width'] = $module_config[$module_name]['homewidth'];

		$item['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['playlists'] . '/' . $item['alias'];
		$item['fake_id'] = 0;
		$playlist_array[] = $item;
	}
	$result->closeCursor();
	unset( $result, $row );

	$playlist_other_array = array();
	$contents = playlist_theme( $playlist_array, $playlist_other_array, '', $page_title, $description, '','' );
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
