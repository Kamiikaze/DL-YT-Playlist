<?php

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

// Get your YouTube-Api Key here >> https://console.developers.google.com
$API_key = 'AIzaSyCo1rh9f8_D085lNP1E6eyDg3oLDYhuGr0';

$ip			= "120.0.0.1";	// IP Address of the server SinusBot is running on (NOT localhost)
$port		= "8087";		// Port that the web panel is running on (default 8087)
$user		= "admin";		// Username to login to the web panel 
$pass		= "admin";		// Corresponding password

$defaultInstance = 0;
$instanceIDS		= array(
											"InstanceID #1",
											"InstanceID #2"
										);
$instanceNames	= array(
											"MusicBot #1",
											"MusicBot #2"
										);


#------Do NOT modify the following:------#

$maxResults = 50;
$part = 'snippet';

$ytBaseURL = 'https://www.youtube.com/watch?v=';

#------------------------------------------------#