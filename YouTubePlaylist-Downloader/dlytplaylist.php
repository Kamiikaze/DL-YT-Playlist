<?php
set_time_limit(0);
include("sinusbot.class.php");
include("config.php");

$sinusbot = new SinusBot($ipport);
$sinusbot->login($user, $pass);

$instances	= $sinusbot->selectInstance($instanceIDS[$defaultInstance]); // Alle Instanzen
$status		= $sinusbot->getStatus($instanceIDS[$defaultInstance]);

echo "<pre>";

//$playlistID = 'PLIngIOSrB2_ChWHT-BR53dtb5c2g8V3KJ';
//$youtubedlurl = "https://www.youtube.com/playlist?list=PLIngIOSrB2_BWPbKa-ur0HFn4XrMaxcKn";
$youtubedlurl = $_GET['youtubeurl'];
$youtubedlurl = (explode("list=", $youtubedlurl));
$playlistID = $youtubedlurl[1];

$playlistname = $_GET['playlistname'];

$time_start = microtime(true);

$getPlaylist = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems/?part='.$part.'&playlistId='.$playlistID.'&maxResults='.$maxResults.'&key='.$API_key.''));
$getPlaylist = json_decode(json_encode($getPlaylist), true);
$plTacks = $getPlaylist['items'];

//print_r($getPlaylist);

$createPL = $sinusbot->createPlaylist($playlistname);

If ($createPL['success'] == 1 ) {
	$debug = "[DEBUG|" . __LINE__ . "] Created Playlist '$playlistname' successfuly <br><br>";
	for ($a = 0; $a < count($plTacks); $a++) {
		$tracknr = $a+1;
		$debug .= "[DEBUG|" . __LINE__ . "] Starting with Track $tracknr / " . count($plTacks) . "<br>";
		$title = $plTacks[$a]['snippet']['title'];
		$vidId = $plTacks[$a]['snippet']['resourceId']['videoId'];
		$yturl = $ytBaseURL . $vidId;
		$debug .= "[DEBUG|" . __LINE__ . "] Getting Video-URL: $yturl<br>";
		
		$addjob = $sinusbot->addJob($yturl);
		
		If ($addjob['success'] == 1 ) {
			$debug .= "[DEBUG|" . __LINE__ . "] Starting download with JobID: $addjob[uuid] <br>";
			
			$b = 0;
			$debug .= "[DEBUG|" . __LINE__ . "] Start scanning Files.. <br>";
			while ( $b != 1) {
				$files = $sinusbot->getFiles();
			
				for ($c = 0; $c < count($files); $c++) {
					If ($files[$c]['filename'] == $yturl ) {
						$uploadedTrackId = $files[$c]['uuid'];
						$b = 1;
					}
				}
			}
			$debug .= "[DEBUG|" . __LINE__ . "] Adding Track '$uploadedTrackId' to Playlist..  <br>";
			$addTrackToPL = $sinusbot->addPlaylistTrack($uploadedTrackId, $createPL['uuid']);
			If ($addTrackToPL['success'] == 1 ) {
				$debug .= "[DEBUG|" . __LINE__ . "] Added Track successfuly <br>";
			} else {
				$error = "[ERROR|" . __LINE__ . "] Couldn't add Track to Playlist.<br>";
				exit($error);
			}
			// move track to folder named as $playlistname
			$debug .= "[DEBUG|" . __LINE__ . "] Job $addjob[uuid] finished. <br><br>";
		} else {
			$error = "[ERROR|" . __LINE__ . "] Couldn't download file.<br>";
			exit($error);
		}
	}
} else {
	$error = "[ERROR|" . __LINE__ . "] Couldn't create Playlist '$playlistname'.<br>";
	exit($error);
}

$time_end = microtime(true);
$time = round($time_end - $time_start);
echo "Process Time: $time sec.<br><br>";

If (isset($_GET['debug'])) {
	echo $debug;
}




















