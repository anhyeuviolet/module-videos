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

if( $nv_Request->isset_request( 'loading', 'post,get' ) ){
	$xtpl = new XTemplate( 'get.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );

	$xtpl->parse( 'loading' );
	$contents = $xtpl->text( 'loading' );
	echo $contents;
}

$key = $nv_Request->get_string ( 'q', 'get,post' );
$maxResults = $nv_Request->get_int ( 'maxResults', 'get,post' );
if(!empty($key) AND $maxResults < 1){
	$maxResults = 5;
}
$row = $error = '';

$xtpl = new XTemplate ( 'get.tpl', NV_ROOTDIR . '/themes/' . $global_config ['module_theme'] . '/modules/' . $module_file );
$xtpl->assign ( 'LANG', $lang_module );
$xtpl->assign ( 'GLANG', $lang_global );
$xtpl->assign ( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign ( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign ( 'MODULE_NAME', $module_name );
$xtpl->assign ( 'OP', $op );
$xtpl->assign ( 'Q', $key );

if( $nv_Request->isset_request( 'action', 'post,get' ) ){
	$action = $nv_Request->get_int ( 'action', 'get,post' );
	if ($action == 1 && ! empty ( $key ) && ! empty ( $maxResults )) {

	if(file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/vendor/autoload.php')){
		require_once NV_ROOTDIR . '/modules/' . $module_file . '/vendor/autoload.php';
	}else{
		die($lang_module['missing_lib']);
	}
		
		function videosListById($youtube, $part, $id) {
			$response = $youtube->videos->listVideos ( $part, array (
					'id' => $id 
			) );
			
			printResults ( $response );
		}

		$client = new Google_Client ();
		$client->setDeveloperKey ( $module_config [$module_name] ['youtube_api'] );
		
		// Disable SSL when testing or your host is not supported.
		$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
		$client->setHttpClient($guzzleClient);
		
		// Define an object that will be used to make all API requests.
		$youtube = new Google_Service_YouTube ( $client );
		
		try {
			
			// Call the search.list method to retrieve results matching the specified
			// query term.
			$searchResponse = $youtube->search->listSearch ( 'id,snippet', array (
					'q' => $key,
					'maxResults' => $maxResults 
			) );
			
			$videos = '';
			
			// Add each result to the appropriate list, and then display the lists of
			// matching videos, channels, and playlists.
			$numResults = sizeof($searchResponse ['items']);
			$xtpl->assign ( 'NUMRESULTS', $numResults );
			foreach ( $searchResponse ['items'] as $searchResult ) {
				switch ($searchResult ['id'] ['kind']) {
					case 'youtube#video' :
						$row = $searchResult ['snippet'];
						$row ['imghome'] = $searchResult ['snippet'] ['thumbnails'] ['default'] ['url'];
						$row ['youtube_id'] = $searchResult ['id'] ['videoId'];
						$row ['link'] = 'https://www.youtube.com/watch?v=' . $searchResult ['id'] ['videoId'];
						
						$videoInf = $youtube->videos->listVideos ( 'contentDetails', array (
								'id' => $searchResult ['id'] ['videoId'] 
						) );
						
						$duration_encoded = $videoInf['items'][0]['contentDetails']['duration'];
						
						// duration
						$interval = new DateInterval($duration_encoded);
						$seconds = $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;

						$row ['publishedAt'] = date ( 'H:i:s d/m/Y', strtotime ( $row ['publishedAt'] ) );
						
						$row ['duration'] = sec2hms($seconds) ;
						break;
				}
				$xtpl->assign ( 'ROW', $row );
				if (! empty ( $row ['youtube_id'] )) {
					$xtpl->parse ( 'main.data.loop' );
				}
			}
		} catch ( Google_Service_Exception $e ) {
			$error .= sprintf ( '<p>A service error occurred: <code>%s</code></p>', htmlspecialchars ( $e->getMessage () ) );
		} catch ( Google_Exception $e ) {
			$error .= sprintf ( '<p>An client error occurred: <code>%s</code></p>', htmlspecialchars ( $e->getMessage () ) );
		}
		$xtpl->parse ( 'main.data' );
	}
	
	if (! empty ( $error )) {
		$xtpl->assign ( 'ERROR', $error );
		$xtpl->parse ( 'main.error' );
	}
	$xtpl->parse ( 'main' );
	$contents = $xtpl->text ( 'main' );
	echo $contents;
}
