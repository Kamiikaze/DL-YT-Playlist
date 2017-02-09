<html>

	<head>
		<title>Upload YouTube-Playlist</title>
	</head>
	
	<body>
	
		<form action="dlytplaylist.php" method="get">
			Playlistname:
			<input type="text" name="playlistname" placeholder="Playlistname"/></br>
			Playlisturl:
			<input type="text" name="youtubeurl" placeholder="YouTube-Playlist URL"/></br>
			Debug:
			<input type="radio" name="debug" value="debug" checked>Yes
			<input type="radio" name="debug" value="">No
			</br></br>
			<input type="submit">
			
			
		</form>
	
	</body>
	
</html>