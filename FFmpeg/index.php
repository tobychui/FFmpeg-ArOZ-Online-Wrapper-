<?php
include '../auth.php';

function mv($var){
	if (isset($_GET[$var]) && $_GET[$var] != ""){
		return $_GET[$var];
	}
	return "";
}

if (mv("filepath") != "" && mv("filename") != ""){
	header("Location: selectConvert.php?filepath=" . mv("filepath") . "&filename=" . mv("filename"));
}
?>
<html>
<head>
<link rel="stylesheet" href="tocas.css">
<script src="jquery.min.js"></script>
<title>FFmpeg Wrapper for ArOZ Online</title>
</head>
<body>
<div id="headerNav" class="ts pointing secondary menu">
    <a class="item" href="../">< Back</a>
    <a class="active item">FFmpeg Wrapper for ArOZ Online</a>
</div>
<div class="ts container">
	<div class="ts segment">
		<h4>FFmpeg wrapper for ArOZ Online</h4>
		<p>This is a wrapper for ArOZ Online to provide FFmpeg conversion API for other modules.<br>
		This can provide API for converting different kind of video to audio or vise versa.</p>
		<p>If you arrive here by accident, please click the "back" button on the top left corner of the page to exit.</p>
	</div>
	<div class="ts primary segment">
	<?php
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if (file_exists('ffmpeg-4.0.2-win32-static\bin\ffmpeg.exe')){
				echo "✅ FFmpeg found with path: ffmpeg-4.0.2-win32-static\bin\ffmpeg.exe";
			}else{
				echo '❌FFmpeg not found. Please download and place your ffmpeg 4.0.2 32bit binary at: ffmpeg-4.0.2-win32-static\bin\ffmpeg.exe';
			}
		} else {
			$result = shell_exec("whereis avconv");
			echo "❗Current avconv installation path: <br><code>" . $result . "</code><br> If you see no path following the lib name in the line above, please install it via the button below (Debian Jessie Only)";
		}
	?>
	</div>
	<div class="ts primary segment">
		<div class="ts header">
			Examples
			<div class="sub header">Here are some examples for calling the FFmpeg wrapper module with AJAX request / GET command</div>
		</div>
		<code>ffmpeg.php?input=filename.mp4&output=filename.webm</code><br>
		<code>ffmpeg.php?input=filename.mp4&output=filename.mp3</code><br>
		<code>ffmpeg.php?passthrough=-i "/media/storage1/test.mp4" -y -codec:a libmp3lame -ac 2 -ar 44100 -ab 128k "/media/storage1/output.mp3"</code>
	</div>
	
	<div class="ts info segment">
		<p>You can do something amazing with this wrapper. For example, you can make the module you write gain access to FFmpeg by sending AJAX command in the above format. Or you can do some basic file conversion with the following quick functions.</p>
		<div class="ts header">
			ArOZ Online Functions
			<div class="sub header">These functions have to be used with ArOZ Online System</div>
		</div>
		<div class="ts basic segment" style="background-color:#a9cbd1 !important"> 
			<button class="ts secondary opinion button" onClick="createDesktopIcon();">Create Desktop Icon</button>
			<a class="ts secondary opinion button" href="readonlyFileViewer.php?path=../">Convert File</a>
			
			<?php 
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
					
				}else{
					echo '<a class="ts secondary opinion button" href="readonlyFileViewer.php?path=/media">Convert File (External Storage)</a>';
					echo '<a class="ts secondary opinion button" href="quick_install.php">apt-install avconv</a>';
				}
			?>
			
		</div>
	</div>
	<div class="ts negative segment">
	<div class="ts header">
		Developer Reminder
		<div class="sub header">Asynchronous Threadings</div>
	</div>
		This module is written with Asynchronous Threadings. (i.e. The conversion is done in the background and you will not know when the process is finished.).<br>
		If you are developing module that will use this wrapper, please design your module in a more flexible way in handling possible conversion unfinished situation.
	<br>
	</div>
	<div class="ts divider"></div>
	Developed by Toby Chui feat. IMUS Laboratory under ArOZ Online Project<br>
	Read the License.txt for more information about the license.
</div>
<br><br><br><br>
<script>
var inVDI = !(!parent.isFunctionBar);
if (inVDI){
	$("#headerNav").hide();
}
function createDesktopIcon(){
	$.get( "createDesktopIcon.php", function( data ) {
		if (data.includes("ERROR")){
			alert(data);
		}else{
			
		}
	});
}
</script>
</body>
</html>