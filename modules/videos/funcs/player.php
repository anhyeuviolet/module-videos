<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

$channel = array();
$data = array();
$array_item = array();
$cache_file = '';
$contents = '';

// Get info from URL
$raw_alias = isset( $array_op[1] ) ? trim( $array_op[1] ) : '';
$arr_alias = explode('-',$raw_alias);
$p_id = intval(substr($arr_alias[0],4));
$check_ss = $arr_alias[1];
$vid_id = intval(substr($arr_alias[2],4));

// cache call
if( ! defined( 'NV_IS_MODADMIN' ) )
{
	$cache_file = NV_LANG_DATA . '_' . $module_name . '_' . $op . '_' .  md5( $p_id.$vid_id ) .'_' . NV_CACHE_PREFIX . '.cache';
	if( ( $cache = nv_get_cache( $module_name, $cache_file ) ) != false )
	{
		$contents = $cache;
	}
}
$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['description'] = ! empty( $module_info['description'] ) ? $module_info['description'] : $global_config['site_description'];

if( empty( $contents ) )
{
	if( $p_id > 0 )
	{
		if($check_ss != (md5( $p_id . session_id() . $global_config['sitekey'] )))die("Wrong session!");
		$db->sqlreset()
			->select( '*' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
			->order( 'playlist_sort ASC' )
			->where( 'status=1 AND inhome=1 AND playlist_id= ' . $p_id );
	}
	elseif( $vid_id > 0 )
	{
		if($check_ss != (md5( $vid_id . session_id() . $global_config['sitekey'] )))die("Wrong session!");
		$db->sqlreset()
			->select( '*' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
			->where( 'status=1 AND inhome=1 AND id= ' . $vid_id );
	}
	$result = $db->query( $db->sql() );
	while( $data = $result->fetch( ) )
	{
		if( $data['homeimgthumb'] == 1 ) // image thumb
		{
			$data['rss_img'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/img/' . $data['homeimgfile'];
		}
		elseif( $data['homeimgthumb'] == 2 ) // image file
		{
			$data['rss_img'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $data['homeimgfile'];
		}
		elseif( $data['homeimgthumb'] == 3 ) // image url
		{
			$data['rss_img'] = $data['homeimgfile'];
		}
		else // no image
		{
			$data['rss_img'] = '';
		}

		// Export video link
		if( ! empty( $data['vid_path'] ) )
		{
			if( $data['vid_type'] == 1 )
			{
				$data['href'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/vid/' . $data['vid_path'];
				$data['quality'] = '';
			}
			elseif( $data['vid_type'] == 2 )
			{
				$data['href'] = $data['vid_path'];
				$data['quality'] = '';
			}
			elseif( $data['vid_type'] == 3 )
			{
				$data['href'] = array();
				$data['href'] = get_link_mp4_picasa($data['vid_path']);
			}
			elseif( $data['vid_type'] == 4 )
			{
				$data['href'] = array();
				$data['href'] = get_facebook_mp4($data['vid_path']);
			}
			elseif( $data['vid_type'] == 5 )
			{
				$data['href'] = $data['vid_path'];
				$data['quality'] = '';
			}
		}
		$array_item[] = $data;
	}

	$contents .='<?xml version="1.0" encoding="utf-8"?>';
	$contents.='<rss version="2.0" xmlns:jwplayer="http://rss.jwpcdn.com/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">';
	$contents .='<channel>';
	$contents .='<title>'.$channel['title'].'</title>';
	$contents .='<description>'.$channel['description'].'</description>';
	$contents .='<link>'.$channel['link'].'</link>';
	foreach ( $array_item as $items )
	{
		$contents .='<item>';
		$contents .='<title>'.$items['title'].'</title>';
		$contents .='<description>'.$items['hometext'].'</description>';
		$contents .='<guid>'.$items['playlist_id'].$items['playlist_sort'].'</guid>';
		$contents .='<jwplayer:image>'.$items['rss_img'].'</jwplayer:image>';
		if( $items['vid_type'] == 3 || $items['vid_type'] == 4 )
		{
			foreach ($items['href'] as $source_file_i)
			{
				$contents .= '<jwplayer:source file="'.htmlentities($source_file_i['link_mp4']).'" label="'.$source_file_i['quality'].'" type="mp4" />';
			}
		}
		else
		{
			$contents .= '<jwplayer:source file="'.htmlentities($items['href']).'" />';
		}
		$contents .='</item>';	
	}
	$contents .='</channel>';
	$contents .='</rss>';

	$time_set_cache = filemtime( NV_ROOTDIR . '/' . NV_CACHEDIR .'/'. $module_name . '/' . $cache_file);
	if( ! defined( 'NV_IS_MODADMIN' ) and $contents != '' and $cache_file != '' and ((NV_CURRENTTIME - $time_set_cache) > 43200) )
	{
		nv_set_cache( $module_name, $cache_file, $contents );
	}
}

echo $contents;
die();