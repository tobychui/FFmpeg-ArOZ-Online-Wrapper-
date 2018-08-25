<?php
session_start();
$username = "";
if (isset($_SESSION['login'])){
	$username = $_SESSION['login'];
}else{
	die("ERROR. No Session username. Are you sure you are running this under ArOZ Online System?");
}
if (file_exists("../Desktop/") && file_exists("../Desktop/files/" . $username . "/")){
	if (file_exists("../Desktop/files/" . $username . '/ffmpeg.shortcut') == false){
		$target = "../Desktop/files/" . $username . '/ffmpeg.shortcut';
		$shortcut = fopen($target, "w") or die("ERROR. Unable to open file.");
		$txt = "module" . PHP_EOL . "FFmpeg"  . PHP_EOL . "FFmpeg" . PHP_EOL . "FFmpeg/img/desktop_icon.png" . PHP_EOL;
		fwrite($shortcut, $txt);
		fclose($shortcut);
	}else{
		die("ERROR. Shortcut already exists.");
	}
}else{
	die("ERROR. Desktop module not exists");
}
?>