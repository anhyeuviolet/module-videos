<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */
if (! defined ( 'NV_MAINFILE' ))
	die ( 'Stop!!!' );

$timecheckstatus = $module_config [$module_name] ['timecheckstatus'];
if ($timecheckstatus > 0 and $timecheckstatus < NV_CURRENTTIME) {
	nv_set_status_module ();
}

/**
 * nv_set_status_module()
 *
 * @return
 *
 */
function nv_set_status_module() {
	global $db, $nv_Cache, $module_name, $module_data, $global_config;
	
	$check_run_cronjobs = NV_ROOTDIR . '/' . NV_LOGS_DIR . '/data_logs/cronjobs_' . md5 ( $module_data . 'nv_set_status_module' . $global_config ['sitekey'] ) . '.txt';
	$p = NV_CURRENTTIME - 300;
	if (file_exists ( $check_run_cronjobs ) and @filemtime ( $check_run_cronjobs ) > $p) {
		return;
	}
	file_put_contents ( $check_run_cronjobs, '' );
	
	// status_0 = "Cho duyet";
	// status_1 = "Xuat ban";
	// status_2 = "Hen gio dang";
	// status_3= "Het han";
	
	// Dang cai bai cho kich hoat theo thoi gian
	$query = $db->query ( 'SELECT id, listcatid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status=2 AND publtime < ' . NV_CURRENTTIME . ' ORDER BY publtime ASC' );
	while ( list ( $id, $listcatid ) = $query->fetch ( 3 ) ) {
		$array_catid = explode ( ',', $listcatid );
		foreach ( $array_catid as $catid_i ) {
			$catid_i = intval ( $catid_i );
			if ($catid_i > 0) {
				$db->query ( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SET status=1 WHERE id=' . $id );
			}
		}
		$db->query ( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET status=1 WHERE id=' . $id );
	}
	
	// Ngung hieu luc cac bai da het han
	$query = $db->query ( 'SELECT id, listcatid, archive FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status=1 AND exptime > 0 AND exptime <= ' . NV_CURRENTTIME . ' ORDER BY exptime ASC' );
	while ( list ( $id, $listcatid, $archive ) = $query->fetch ( 3 ) ) {
		if (intval ( $archive ) == 0) {
			nv_del_content_module ( $id );
		} else {
			nv_archive_content_module ( $id, $listcatid );
		}
	}
	
	// Tim kiem thoi gian chay lan ke tiep
	$time_publtime = $db->query ( 'SELECT min(publtime) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status=2 AND publtime > ' . NV_CURRENTTIME )->fetchColumn ();
	$time_exptime = $db->query ( 'SELECT min(exptime) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status=1 AND exptime > ' . NV_CURRENTTIME )->fetchColumn ();
	
	$timecheckstatus = min ( $time_publtime, $time_exptime );
	if (! $timecheckstatus)
		$timecheckstatus = max ( $time_publtime, $time_exptime );
	
	$sth = $db->prepare ( "UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = 'timecheckstatus'" );
	$sth->bindValue ( ':module_name', $module_name, PDO::PARAM_STR );
	$sth->bindValue ( ':config_value', intval ( $timecheckstatus ), PDO::PARAM_STR );
	$sth->execute ();
	
	$nv_Cache->delMod ( 'settings' );
	$nv_Cache->delMod ( $module_name );
	
	unlink ( $check_run_cronjobs );
	clearstatcache ();
}

/**
 * nv_del_content_module()
 *
 * @param mixed $id        	
 * @return
 *
 */
function nv_del_content_module($id) {
	global $db, $module_name, $module_data, $title, $lang_module;
	$content_del = 'NO_' . $id;
	$title = '';
	list ( $id, $listcatid, $title, $homeimgfile ) = $db->query ( 'SELECT id, listcatid, title, homeimgfile FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . intval ( $id ) )->fetch ( 3 );
	if ($id > 0) {
		$number_no_del = 0;
		$array_catid = explode ( ',', $listcatid );
		foreach ( $array_catid as $catid_i ) {
			$catid_i = intval ( $catid_i );
			if ($catid_i > 0) {
				$_sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' WHERE id=' . $id;
				if (! $db->exec ( $_sql )) {
					++ $number_no_del;
				}
			}
		}
		
		$_sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id;
		if (! $db->exec ( $_sql )) {
			++ $number_no_del;
		}
		
		$_sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_detail WHERE id = ' . $id;
		if (! $db->exec ( $_sql )) {
			++ $number_no_del;
		}
		
		$db->query ( 'DELETE FROM ' . NV_PREFIXLANG . '_comment WHERE module=' . $db->quote ( $module_name ) . ' AND id = ' . $id );
		$db->query ( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE id = ' . $id );
		$db->query ( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist WHERE id = ' . $id );
		$db->query ( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_favourite WHERE id = ' . $id );
		$db->query ( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report WHERE id = ' . $id );
		
		$db->query ( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET numnews = numnews-1 WHERE tid IN (SELECT tid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id=' . $id . ')' );
		$db->query ( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id = ' . $id );
		
		if ($number_no_del == 0) {
			$content_del = 'OK_' . $id . '_' . nv_url_rewrite ( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true );
		} else {
			$content_del = 'ERR_' . $lang_module ['error_del_content'];
		}
	}
	return $content_del;
}

/**
 * nv_archive_content_module()
 *
 * @param mixed $id        	
 * @param mixed $listcatid        	
 * @return
 *
 */
function nv_archive_content_module($id, $listcatid) {
	global $db, $module_data;
	$array_catid = explode ( ',', $listcatid );
	foreach ( $array_catid as $catid_i ) {
		$catid_i = intval ( $catid_i );
		if ($catid_i > 0) {
			$db->query ( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SET status=3 WHERE id=' . $id );
		}
	}
	$db->query ( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET status=3 WHERE id=' . $id );
}

/**
 * nv_link_edit_page()
 *
 * @param mixed $id        	
 * @return
 *
 */
function nv_link_edit_page($id) {
	global $lang_global, $module_name;
	$link = "<a class=\"btn btn-primary btn-xs\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;id=" . $id . "\"><em class=\"fa fa-edit margin-right\"></em> " . $lang_global ['edit'] . "</a>";
	return $link;
}

/**
 * nv_link_delete_page()
 *
 * @param mixed $id        	
 * @return
 *
 */
function nv_link_delete_page($id, $detail = 0) {
	global $lang_global, $module_name;
	$link = "<a class=\"btn btn-danger btn-xs\" href=\"javascript:void(0);\" onclick=\"nv_del_content(" . $id . ", '" . md5 ( $id . session_id () ) . "','" . NV_BASE_ADMINURL . "', " . $detail . ")\"><em class=\"fa fa-trash-o margin-right\"></em> " . $lang_global ['delete'] . "</a>";
	return $link;
}

/**
 * nv_link_edit_playlist()
 *
 * @param mixed $id        	
 * @return
 *
 */
function nv_link_edit_playlist($id) {
	global $lang_global, $module_name;
	$link = "<a class=\"btn btn-primary btn-xs\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=playlists&amp;playlist_id=" . $id . "#edit\"><em class=\"fa fa-edit margin-right\"></em> " . $lang_global ['edit'] . "</a>";
	return $link;
}

/**
 * nv_videos_get_detail()
 *
 * @param mixed $bodytext        	
 * @return
 *
 */
function nv_videos_get_detail($bodytext) {
	// Get image tags
	if (preg_match_all ( "/\<img[^\>]*src=\"([^\"]*)\"[^\>]*\>/is", $bodytext, $match )) {
		foreach ( $match [0] as $key => $_m ) {
			$textimg = '';
			if (strpos ( $match [1] [$key], 'data:image/png;base64' ) === false) {
				$textimg = " " . $match [1] [$key];
			}
			if (preg_match_all ( "/\<img[^\>]*alt=\"([^\"]+)\"[^\>]*\>/is", $_m, $m_alt )) {
				$textimg .= " " . $m_alt [1] [0];
			}
			$bodytext = str_replace ( $_m, $textimg, $bodytext );
		}
	}
	// Get link tags
	if (preg_match_all ( "/\<a[^\>]*href=\"([^\"]+)\"[^\>]*\>(.*)\<\/a\>/isU", $bodytext, $match )) {
		foreach ( $match [0] as $key => $_m ) {
			$bodytext = str_replace ( $_m, $match [1] [$key] . " " . $match [2] [$key], $bodytext );
		}
	}
	
	$bodytext = str_replace ( '&nbsp;', ' ', strip_tags ( $bodytext ) );
	return preg_replace ( '/[ ]+/', ' ', $bodytext );
}

/**
 * get_youtube_id()
 *
 * @param mixed $url        	
 * @return
 *
 */
function get_youtube_id($url) {
	preg_match ( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches );
	return $matches [1];
}

/**
 * curl()
 */
function curl($url) {
	$ch = @curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	$head [] = "Connection: keep-alive";
	$head [] = "Keep-Alive: 300";
	$head [] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$head [] = "Accept-Language: en-us,en;q=0.5";
	curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36' );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $head );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 60 );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
			'Expect:' 
	) );
	$page = curl_exec ( $ch );
	curl_close ( $ch );
	return $page;
}

// Check URL is Youtube
function is_youtube($url) {
	$valid = preg_match ( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url );
	if ($valid) {
		return true;
	} else {
		return false;
	}
}

// Check URL is FaceBook
function is_facebook($url) {
	$pattern = '/facebook.com/';
	if (preg_match ( $pattern, $url ) == 1) {
		return true;
	} else {
		return false;
	}
}
// Check URL is Google Drive
function is_gdrive($url) {
	$pattern = '/drive.google.com/';
	if (preg_match ( $pattern, $url ) == 1) {
		return true;
	} else {
		return false;
	}
}
function get_gdrive_mp4($url) {
	$get_data_array = $data_array = array ();
	$gdvid_mp4 = array ();
	$mp4 = array (
			'link_mp4' => '',
			'quality' => '' 
	);
	
	$get_data_array = curl ( $url );
	if (isset ( $get_data_array )) {
		$cat = explode ( ',["fmt_stream_map","', $get_data_array );
		
		$cat = explode ( '"]', $cat [1] );
		$cat = explode ( ',', $cat [0] );
		foreach ( $cat as $link ) {
			$cat = explode ( '|', $link );
			$links = str_replace ( array (
					'\u003d',
					'\u0026' 
			), array (
					'=',
					'&' 
			), $cat [1] );
			
			if ($cat [0] == 37) {
				$f1080p = $links;
			}
			if ($cat [0] == 22) {
				$f720p = $links;
			}
			if ($cat [0] == 59) {
				$f480p = $links;
			}
			if ($cat [0] == 43 or $cat [0] == 18) {
				$f360p = $links;
			}
		}
		
		if (isset ( $f1080p )) {
			$mp4 = array (
					'link_mp4' => $f1080p,
					'quality' => '1080p' 
			);
			$gdvid_mp4 [] = $mp4;
		}
		
		if (isset ( $f720p )) {
			$mp4 = array (
					'link_mp4' => $f720p,
					'quality' => '720p' 
			);
			$gdvid_mp4 [] = $mp4;
		}
		
		if (isset ( $f480p )) {
			$mp4 = array (
					'link_mp4' => $f480p,
					'quality' => '480p' 
			);
			$gdvid_mp4 [] = $mp4;
		}
		
		if (isset ( $f360p )) {
			$mp4 = array (
					'link_mp4' => $f360p,
					'quality' => '360p' 
			);
			$gdvid_mp4 [] = $mp4;
		}
	}
	return $gdvid_mp4;
}

// Get Facebook video id
function get_facebook_id($link) {
	if (substr ( $link, - 1 ) != '/' && is_numeric ( substr ( $link, - 1 ) )) {
		$link = $link . '/';
	}
	preg_match ( '/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)\/(.*)/U', $link, $id ); // link dang https://www.facebook.com/userName/videos/vb.IDuser/IDvideo/?type=2&theater
	if (isset ( $id [4] )) {
		$idVideo = $id [3];
	} else {
		preg_match ( '/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)/U', $link, $id ); // link dang https://www.facebook.com/userName/videos/IDvideo
		if (isset ( $id [3] )) {
			$idVideo = $id [2];
		} else {
			preg_match ( '/https:\/\/www.facebook.com\/video\.php\?v\=(.*)/', $link, $id ); // link dang https://www.facebook.com/video.php?v=IDvideo
			$idVideo = $id [1];
			$idVideo = substr ( $idVideo, 0, - 1 );
		}
	}
	return $idVideo;
}

// Get direct link MP4 Facebook
function get_facebook_mp4($link) {
	$id = get_facebook_id ( $link );
	$embed = 'https://www.facebook.com/video/embed?video_id=' . $id;
	$get = curl ( $embed );
	$data = explode ( '"videoData":[', $get ); // tach chuoi "videoData":[ thanh mang
	$data = explode ( '],"minQuality"', $data [1] ); // tach chuoi ],"minQuality" thanh mang
	$data = str_replace ( array (
			'\/' 
	), array (
			'/' 
	), $data [0] ); // thay the cac ky tu ma hoa thanh ky tu dac biet
	$fbvid_mp4 = array ();
	$mp4 = array (
			'link_mp4' => '',
			'quality' => '' 
	);
	// Link HD
	
	$data = json_decode ( $data ); // decode chuoi
	if (isset ( $data->hd_src )) {
		$mp4 = array (
				'link_mp4' => $data->hd_src,
				'quality' => 'HD' 
		);
		$fbvid_mp4 [] = $mp4;
	}
	if (isset ( $data->sd_src )) {
		$mp4 = array (
				'link_mp4' => $data->sd_src,
				'quality' => 'SD' 
		);
		$fbvid_mp4 [] = $mp4;
	}
	
	return $fbvid_mp4;
}

// Check URL is Picasa
function is_picasa($url) {
	$pattern = '/picasaweb.google.com/';
	if (preg_match ( $pattern, $url ) == 1) {
		return true;
	} else {
		return false;
	}
}

// Get link Picasa
function get_link_redirector_picasa($link_picasa) {
	$data = file_get_contents ( $link_picasa );
	$a = explode ( '"media":{"content":[', $data );
	$a = explode ( '],"', $a [1] );
	$datar = explode ( '},', $a [0] );
	$links = array ();
	foreach ( $datar as $key => $value ) {
		$value = str_replace ( "}}", "}", $value . "}" );
		$links [] = json_decode ( $value, true );
	}
	return $links;
}

// Get link Picasa
function getDirectLink($url) {
	$urlInfo = parse_url ( $url );
	$out = "GET  {$url} HTTP/1.1\r\n";
	$out .= "Host: {$urlInfo['host']}\r\n";
	$out .= "User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\n";
	$out .= "Connection: Close\r\n\r\n";
	$con = @fsockopen ( 'ssl://' . $urlInfo ['host'], 443, $errno, $errstr, 10 );
	if (! $con) {
		return $errstr . " " . $errno;
	}
	fwrite ( $con, $out );
	$data = '';
	while ( ! feof ( $con ) ) {
		$data .= fgets ( $con, 512 );
	}
	fclose ( $con );
	preg_match ( "!\r\n(?:Location|URI): *(.*?) *\r\n!", $data, $matches );
	$url = $matches [1];
	return trim ( $url );
}

// Output Picasa MP4 direct link
function get_link_mp4_picasa($link_picasa) {
	$links = get_link_redirector_picasa ( $link_picasa );
	$links_mp4 = array ();
	for($i = 1; $i < count ( $links ); $i ++) {
		$mp4 = array (
				'link_mp4' => '',
				'quality' => '' 
		);
		$mp4 ['link_mp4'] = getDirectLink ( $links [$i] ['url'] ) . '&format=getlink/video.mp4'; // get link mp4, must have &format... to embed in JWPlayer
		$mp4 ['quality'] = $links [$i] ['height']; // get quality
		$links_mp4 [] = $mp4;
	}
	return $links_mp4;
}
function humanTiming($time) {
	global $lang_module;
	
	$time = time () - $time; // to get the time since that moment
	$time = ($time < 1) ? 1 : $time;
	$tokens = array (
			31536000 => $lang_module ['year'],
			2592000 => $lang_module ['month'],
			604800 => $lang_module ['week'],
			86400 => $lang_module ['day'],
			3600 => $lang_module ['hour'],
			60 => $lang_module ['minute'],
			1 => $lang_module ['second'] 
	);
	
	foreach ( $tokens as $unit => $text ) {
		if ($time < $unit)
			continue;
		$numberOfUnits = floor ( $time / $unit );
		return $numberOfUnits . ' ' . $text;
	}
}

/**
 * videos_thumbs()
 * front-end thumbs create
 */
if (! nv_function_exists ( 'videos_thumbs' )) {
	function videos_thumbs($id, $file, $module_upload, $width = 200, $height = 150, $quality = 90) {
		if ($width >= $height)
			$rate = $width / $height;
		else
			$rate = $height / $width;
		
		$image = NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/img/' . $file;
		
		if ($file != '' and file_exists ( $image )) {
			$imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $file;
			$imginfo = nv_is_image ( $image );
			
			$basename = $module_upload . '_' . $width . 'x' . $height . '-' . $id . '-' . md5_file ( $image ) . '.' . $imginfo ['ext'];
			
			if (file_exists ( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename )) {
				$imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename;
			} else {
				
				$_image = new NukeViet\Files\Image ( $image, NV_MAX_WIDTH, NV_MAX_HEIGHT );
				
				if ($imginfo ['width'] <= $imginfo ['height']) {
					$_image->resizeXY ( $width, 0 );
				} elseif (($imginfo ['width'] / $imginfo ['height']) < $rate) {
					$_image->resizeXY ( $width, 0 );
				} elseif (($imginfo ['width'] / $imginfo ['height']) >= $rate) {
					$_image->resizeXY ( 0, $height );
				}
				
				$_image->cropFromCenter ( $width, $height );
				
				$_image->save ( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/', $basename, $quality );
				
				if (file_exists ( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename )) {
					$imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $basename;
				}
			}
		} elseif (nv_is_url ( $file )) {
			$imgsource = $file;
		} else {
			$imgsource = '';
		}
		return $imgsource;
	}
}

/**
 * Return video duration in seconds.
 *
 * @param
 *        	$video_url
 * @param
 *        	$api_key
 * @return integer|null
 *
 */
function youtubeVideoDuration($video_url) {
	global $module_config, $module_name;
	// video id from url
	$video_id = get_youtube_id ( $video_url );
	$api_key = $module_config [$module_name] ['youtube_api'];
	if (empty ( $api_key )) {
		$seconds = '';
		return $seconds;
	} else {
		// video json data
		$json_result = file_get_contents ( "https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$video_id&key=$api_key" );
		$result = json_decode ( $json_result, true );
		
		// video duration data
		if (! count ( $result ['items'] )) {
			return null;
		}
		$duration_encoded = $result ['items'] [0] ['contentDetails'] ['duration'];
		
		// duration
		$interval = new DateInterval ( $duration_encoded );
		$seconds = $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;
		
		return $seconds;
	}
}

/**
 * Return video duration to hours.
 *
 * @param
 *        	$sec
 * @param $padHours (true/false)        	
 * @return $hms
 *
 *
 */
function sec2hms($sec, $padHours = false) {
	$hms = "";
	$hours = intval ( intval ( $sec ) / 3600 );
	$hms .= ($padHours) ? str_pad ( $hours, 2, "0", STR_PAD_LEFT ) . ":" : $hours . ":";
	$minutes = intval ( ($sec / 60) % 60 );
	$hms .= str_pad ( $minutes, 2, "0", STR_PAD_LEFT ) . ":";
	$seconds = intval ( $sec % 60 );
	$hms .= str_pad ( $seconds, 2, "0", STR_PAD_LEFT );
	return $hms;
}

/**
 * function addhttp
 * Add http to URL
 *
 * @param
 *        	$url
 * @return $url
 *
 *
 */
function addhttp($url) {
	if (! preg_match ( "~^(?:f|ht)tps?://~i", $url )) {
		$url = "http://" . $url;
	}
	return $url;
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email
 *        	The email address
 * @param string $s
 *        	Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d
 *        	Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r
 *        	Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img
 *        	True to return a complete IMG tag False for just the URL
 * @param array $atts
 *        	Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 *         @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 256, $d = 'identicon', $r = 'g', $img = false, $atts = array()) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5 ( strtolower ( trim ( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ($img) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

/**
 * function nv_videos_check_uploader
 * Check if Uploader info is already inserted
 *
 * @param
 *        	$url
 * @return $url
 *
 *
 */
function nv_videos_check_uploader($user_id) {
	global $db, $global_config, $module_data, $module_name;
	$db->sqlreset ()->select ( 'userid' )->from ( NV_PREFIXLANG . '_' . $module_data . '_uploaders' )->where ( 'userid=' . $user_id );
	$query = $db->query ( $db->sql () );
	$result = $query->fetch ();
	if ($result > 0) {
		return false;
	} else {
		return true;
	}
}

/**
 * function nv_videos_getuser_info
 * Update Uploader info
 *
 * @param
 *        	$user_id
 *        	
 *        	
 */
function nv_videos_getuser_info($user_id) {
	global $db, $nv_Cache, $global_config, $module_data, $module_name, $lang_module;
	$db->sqlreset ()->select ( 'userid, group_id, username, md5username, email, first_name, last_name' )->from ( NV_USERS_GLOBALTABLE )->where ( 'userid=' . $user_id );
	$result = $db->query ( $db->sql () );
	while ( $uploader_info = $result->fetch () ) {
		$stmt = $db->prepare ( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_uploaders VALUES(
		' . intval ( $uploader_info ['userid'] ) . ',
		' . intval ( $uploader_info ['group_id'] ) . ',
		1,
		:username,
		:md5username,
		:email,
		:first_name,
		:last_name,
		:description,
		0)' );
		
		$_des = $lang_module ['about_uploader'] . $uploader_info ['username'];
		$stmt->bindParam ( ':username', $uploader_info ['username'], PDO::PARAM_STR );
		$stmt->bindParam ( ':md5username', $uploader_info ['md5username'], PDO::PARAM_STR );
		$stmt->bindParam ( ':email', $uploader_info ['email'], PDO::PARAM_STR );
		$stmt->bindParam ( ':first_name', $uploader_info ['first_name'], PDO::PARAM_STR );
		$stmt->bindParam ( ':last_name', $uploader_info ['last_name'], PDO::PARAM_STR );
		$stmt->bindParam ( ':description', $_des, PDO::PARAM_STR );
		$stmt->execute ();
	}
	$nv_Cache->delMod ( $module_name );
}

/**
 * function nv_get_video_href
 *
 * @param
 *        	$path
 * @param
 *        	$type
 *        	
 *        	
 */
function nv_get_video_href($path, $type) {
	global $module_upload;
	// Export video link
	$href_vid = array ();
	if (! empty ( $path )) {
		if ($type == 1) {
			$href_vid ['link'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/vid/' . $path;
			$href_vid ['quality'] = '';
		} elseif ($type == 2) {
			$href_vid ['link'] = $path;
			$href_vid ['quality'] = '';
		} elseif ($type == 3) {
			$href_vid = get_link_mp4_picasa ( $path );
		} elseif ($type == 4) {
			$href_vid = get_facebook_mp4 ( $path );
		} elseif ($type == 6) {
			$href_vid = get_gdrive_mp4 ( $path );
		} elseif ($type == 5) {
			$href_vid ['link'] = $path;
			$href_vid ['quality'] = '';
		}
	}
	return $href_vid;
}