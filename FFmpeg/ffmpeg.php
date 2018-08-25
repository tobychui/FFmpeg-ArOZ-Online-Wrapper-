<?php
include '../auth.php';
function mv($var){
	if (isset($_GET[$var]) && $_GET[$var] != ""){
		return $_GET[$var];
	}
	return "";
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
				pclose(popen("start cmd.exe /c " . '"' . '"'.$ffmpegPath.'" -threads 1 -i "' . $inputRealPath .'" "' . $outputFilename . '"' . '"', "r")); 
				//exec('"ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe" -threads 1 -i "' . $inputRealPath .'" "' . $outputFilename . '" > NUL 2>&1 &');
				echo ("DONE");
			}else{
				die("ERROR. FFmpeg binary not found.");
			}
		} else {
			exec('bash -c "avconv -i "' . $inputRealPath .'" "' . $outputFilename . '"  > /dev/null 2>&1 &"');
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