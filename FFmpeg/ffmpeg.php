<?php
include '../auth.php';
function mv($var){
	if (isset($_GET[$var]) && $_GET[$var] != ""){
		return $_GET[$var];
	}
	return "";
}

function getExt($filepath){
	return pathinfo($filepath, PATHINFO_EXTENSION);
}

$input = mv("input");
$output = mv("output");
$command = mv("passthrough");
if ($input != "" && $output != ""){
	if (file_exists($input)){
		$inputRealPath = realpath($input);
		$outputRealPath = realpath(dirname($output));
		$outputFilename = $outputRealPath . "/" .  basename($output);
		//echo "start cmd.exe /c " . '"' . '"'.$ffmpegPath.'" -threads 1 -i "' . $inputRealPath .'" "' . $outputFilename . '"' . '"';
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if (file_exists("ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe")){
				$ffmpegPath = realpath("ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe");
				pclose(popen("start cmd.exe /c " . '"' . '"'.$ffmpegPath.'" -i "' . $inputRealPath .'" "' . $outputFilename . '"' . '"', "r")); 
				//exec('"ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe" -threads 1 -i "' . $inputRealPath .'" "' . $outputFilename . '" > NUL 2>&1 &');
				echo ("DONE");
			}else{
				die("ERROR. FFmpeg binary not found.");
			}
		} else {
			if (getExt($inputRealPath) == "mp4" && getExt($outputFilename) == "mp3"){
				//Quick conversion script just created for mp4 to mp3 conversion
				exec('bash -c "avconv -i "' . $inputRealPath .'" -f mp3 -vn "' . $outputFilename . '"  > /dev/null 2>&1 &"');
			}else if (getExt($inputRealPath) == "avi" && getExt($outputFilename) == "aac"){
				//Quick conversion script for avi -> aac
				exec('bash -c "avconv -i "' . $inputRealPath .'" -vn -acodec copy "' . $outputFilename . '"  > /dev/null 2>&1 &"');
			}else{
				exec('bash -c "avconv -i "' . $inputRealPath .'" -strict experimental "' . $outputFilename . '"  > /dev/null 2>&1 &"');
			}
			echo ("DONE");
		}
	}else{
		die("ERROR. Input file not exists.");
	}
}else if ($command != ""){
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if (file_exists("ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe")){
				$ffmpegPath = realpath("ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe");
				pclose(popen("start cmd.exe /c " . '"' . '"'.$ffmpegPath . $command . '"', "r")); 
				//$result = shell_exec('"ffmpeg-4.0.2-win32-static\bin\ffmpeg.exe" ' . $command . ' > NUL 2>&1 &');
				echo ("DONE");
			}else{
				die("ERROR. FFmpeg binary not found.");
			}
		} else {
			exec('bash -c "avconv ' . $command . '  > /dev/null 2>&1 &"');
			if (strpos($result,"command not found") !== false){
				echo "ERROR. Command Not Found exception. Are you sure you have installed ffmpeg?";
			}else{
				echo ("DONE" . $result);
			}
		}
}else{
	die("ERROR. Not enough variable.");
}

?>