<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Apr 20, 2010 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

$channel = array();
$data = array();
$array_item = array();

$pid_alias = isset( $array_op[1] ) ? trim( $array_op[1] ) : '';
//$p_id = 1;
$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['description'] = ! empty( $module_info['description'] ) ? $module_info['description'] : $global_config['site_description'];
if($pid_alias > 0)
{
	$db->sqlreset()
		->select( '*' )
		->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
		->where( 'status=1 AND inhome=1 AND playlist_id='.$pid_alias );
		// ->limit( 30 );

	$result = $db->query( $db->sql() );
	while( $data = $result->fetch( ) )
	{
		// $catalias = $global_array_cat[$catid_i]['alias'];

		if( $data['homeimgthumb'] == 1 ) // image thumb
		{
			$rimages = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
		}
		elseif( $data['homeimgthumb'] == 2 ) // image file
		{
			$rimages = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
		}
		elseif( $data['homeimgthumb'] == 3 ) // image url
		{
			$rimages = $data['homeimgfile'];
		}
		else // no image
		{
			$rimages = '';
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
			elseif( $data['vid_type'] == 4 || $data['vid_type'] == 5 )
			{
				$data['href'] = $data['vid_path'];
				$data['quality'] = '';
			}
		}
		
			
		$array_item[] = $data;
		
	}
	
	
	$contents = '';
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
		$contents .='<guid>'.$items['id'].'</guid>';
		$contents .='<jwplayer:image>'.$rimages.'</jwplayer:image>';
		if( $items['vid_type'] == 3)
		{
			foreach ($items['href'] as $source_file_i)
			{
				$contents .= '<jwplayer:source file="'.htmlentities($source_file_i['link_mp4']).'" label="'.$source_file_i['quality'].'" />';
			}
		}
		else
		{
			$contents .= '<jwplayer:source file="'.$items['href'].'" />';
		}
		
		$contents .='</item>';	
	}
		
	$contents .='</channel>';
	$contents .='</rss>';

echo $contents;
die();
}

