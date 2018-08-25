<html>
<head>
<link rel="stylesheet" href="tocas.css">
<script src="jquery.min.js"></script>
</head>
<body style="background:rgba(237,237,237,0.85);">
<div id="convertingInterface" class="ts active dimmer" style="display:none;">
	<div class="ts text loader">Converting</div>
</div>
<br>
<?php
function check_file_is_audio($filename) 
{
    $mime = explode("/",mime_content_type($filename))[0];
	if ($mime == "audio"){
		return true;
	}
	return false;
}

function checkIfVideo($file){
	$mime = mime_content_type($file);
	if(strstr($mime, "video/")){
		return true;
	}
	return false;
}

function checkIfImage($file){
	$mime = mime_content_type($file);
	if(strstr($mime, "image/")){
		return true;
	}
	return false;
}

?>
<div class="ts container">
	<div class="ts header">
		FFmpeg Convertor
		<div class="sub header">FFmpeg wrapper for ArOZ Online System</div>
	</div>
	Base Directory
	<div class="ts underlined tiny fluid input">
		<input id="basedir" type="text" placeholder="Input filename" value="<?php echo dirname($_GET['filepath']) . "/"; ?>" readonly="readonly">
	</div>
	Filename
	<div class="ts underlined tiny fluid input">
		<input type="text" placeholder="Input filename" value="<?php echo basename($_GET['filepath']); ?>" readonly="readonly">
	</div>
	Display Name
	<div class="ts underlined tiny fluid input">
		<input type="text" placeholder="Input filename" value="<?php echo basename($_GET['filename']); ?>" readonly="readonly">
	</div>
	Extension
	<div class="ts underlined tiny fluid input">
		<input type="text" placeholder="Input filename" value="<?php $ext = pathinfo($_GET['filepath'], PATHINFO_EXTENSION); echo $ext;?>" readonly="readonly">
	</div>
	Target Format
	<?php
	$musicFormats = ["mp3","aac","ogg","wav","flac"];
	$videoFormats = ["webm","mp4"];
	$imageFormats = ["png","jpg","gif"];
	$isAudio = check_file_is_audio($_GET['filepath']);
	$isVideo = checkIfVideo($_GET['filepath']);
	$isImage = checkIfImage($_GET['filepath']);
	?>
	<select id="targetFormat" class="ts basic tiny fluid dropdown">
	<?php
	if ($isAudio){
		foreach ($musicFormats as $format){
			if ($format != $ext){
				echo '<option>'.$format.'</option>';
			}
		}
	}else if ($isVideo){
		foreach ($videoFormats as $format){
			if ($format != $ext){
				echo '<option>'.$format.'</option>';
			}
		}
		foreach ($musicFormats as $format){
			if ($format != $ext){
				echo '<option>'.$format.'</option>';
			}
		}
	}else if ($isImage){
		foreach ($imageFormats as $format){
			if ($format != $ext){
				echo '<option>'.$format.'</option>';
			}
		}
	}
	?>
	</select>
	<ins style="font-size:11px;">**The output filename will be the same as the input filename.</ins>
	<br>
	<div class="ts tiny buttons">
		<button class="ts positive button" onClick="confirmConversion();">Convert</button>
		<button class="ts negative button" onClick="cancelConversion();">Cancel</button>
	</div>
	<br>
	
</div>
<script>
var sourceFile = "<?php echo $_GET['filepath'];?>";
var filenameOnly = "<?php echo basename($_GET['filepath'],".".$ext);?>";
var inVDI = !(!parent.isFunctionBar);
if (inVDI){
	 //If it is currently in VDI, force the current window size and resize properties
	var windowID = $(window.frameElement).parent().attr("id");
	parent.setWindowIcon(windowID + "","exchange");
	parent.changeWindowTitle(windowID + "","FFmpeg Wrapper");
	parent.setGlassEffectMode(windowID + "");
	parent.setWindowPreferdSize(windowID + "",380,460);
	parent.setWindowFixedSize(windowID + "");
}

function cancelConversion(){
	parent.callToInterface().showNotification("<i class='remove icon'></i> Conversion Cancelled");
	window.location.href="../SystemAOB/functions/killProcess.php";
}

function confirmConversion(){
	var targetFile = $("#basedir").val() + filenameOnly + "." + $("#targetFormat option:selected").text();
	parent.callToInterface().showNotification("<i class='exchange icon'></i> Conversion started in the background.");
	console.log("ffmpeg.php?input=" + sourceFile + "&output=" + targetFile);
	$("#convertingInterface").show();
	  $.ajax({
		url:"ffmpeg.php?input=" + sourceFile + "&output=" + targetFile,  
		success:function(data) {
		  if (data.includes("ERROR")){
			  parent.callToInterface().showNotification("<i class='remove icon'></i> " . data);
		  }else{
			  window.location.href="../SystemAOB/functions/killProcess.php"  
		  }
		}
	  });
}

</script>
</body>
</html>