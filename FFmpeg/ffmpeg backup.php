<?php
include '../auth.php';
function mv($var){
	if (isset($_GET[$var]) && $_GET[$var] != ""){
		return $_GET[$var];
	}
	return "";
}

/**
class ffmpeg extends Thread {
    public $data;
    public function run() {


      $this->data = 'result';
    }
}

$thread = new ChildThread();

if ($thread->start()) {
 
    // wait until thread is finished
    $thread->join();


}
**/



$input = mv("input");
$output = mv("output");
$command = mv("passthrough");

if ($input != "" && $output != ""){
	if (file_exists($input)){
		$inputRealPath = realpath($input);
		$outputRealPath = realpath(dirname($output));
		$outputFilename = $outputRealPath . "/" .  basename($output);
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if (file_exists("ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe")){
				$result = shell_exec('"ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe" -threads 1 -i "' . $inputRealPath .'" "' . $outputFilename . '"');
				echo ("DONE " . $result);
			}else{
				die("ERROR. FFmpeg binary not found.");
			}
		} else {
			$result = shell_exec('avconv -i "' . $inputRealPath .'" "' . $outputFilename . '"');
			if (strpos($result,"command not found") !== false){
				echo "ERROR. Command Not Found exception. Are you sure you have installed ffmpeg?";
			}else{
				echo ("DONE " . $result);
			}
			
		}
	}else{
		die("ERROR. Input file not exists.");
	}
}else if ($command != ""){
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if (file_exists("ffmpeg-4.0.2-win32-static/bin/ffmpeg.exe")){
				$result = shell_exec('"ffmpeg-4.0.2-win32-static\bin\ffmpeg.exe" ' . $command);
				echo ("DONE " . $result);
			}else{
				die("ERROR. FFmpeg binary not found.");
			}
		} else {
			$result = shell_exec('avconv ' . $command);
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