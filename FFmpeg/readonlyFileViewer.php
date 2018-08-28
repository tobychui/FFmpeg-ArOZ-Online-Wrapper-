<?php
include '../auth.php';
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>File Selector (ArOZ Online Beta)</title>
    <link rel="stylesheet" href="../script/tocas/tocas.css">
	<script src="../script/tocas/tocas.js"></script>
	<script src="../script/jquery.min.js"></script>
	<style>
	.item {
		cursor: pointer;
		
	}
	</style>
</head>
<body>
<?php
$path = "";
$status = 1;
$directOpenFile = 0;

if (isset($_GET['path']) && $_GET['path'] != ""){
	if (file_exists($_GET['path'])){
		$path = $_GET['path'];
	}else{
		$path = "PATH NOT FOUND";
		$status = 0;
	}
}else{
	$path = "UNDEFINED DIRECTORY";
	$status = 0;
}

if (is_file($path)){
	//Open the file
	$directOpenFile = true;
}
?>
<div class="ts icon message">
    <i class="folder open icon"></i>
    <div class="content">
        <div class="header">Please select a file for conversion<br>Or <a href="index.php">CLICK HERE</a> to cancel.</div>
        <p id="currentPath"><?php echo $path;?></p>
    </div>
</div>
<?php if ($status == 0){ exit(0);}?>
<div class="ts segmented list">
<?php
	$files = glob("$path/*");
	$filePath = [];
	$folderPath = [];
	foreach ($files as $file){
		if (is_dir($file)){
			array_push($folderPath,$file);
		}
		if (is_file($file)){
			array_push($filePath,$file);
		}
	}
	echo ' <div class="item"><i class="chevron left icon"></i>../</div>';
	foreach ($folderPath as $object){
		echo ' <div class="item"><i class="folder outline icon"></i>'.str_replace($path . "/","",$object).'</div>';
	}
	
	foreach ($filePath as $object){
		echo ' <div class="item"><i class="file outline icon"></i>'.str_replace($path . "/","",$object).'</div>';
	}

?>
</div>
<script>
var currentPath = "<?php echo $path;?>";
var directOpenFile = <?php echo $directOpenFile ? 'true' : 'false'; ?>;
var isFunctionBar = !(!parent.isFunctionBar);

$(document).ready(function(){
	if (directOpenFile == true){
		var filename = currentPath.split("/").splice(-1,1);
		if (isFunctionBar){
			parent.newEmbededWindow("SystemAOB/functions/file_system/index.php?controlLv=2&mode=file&dir=" + currentPath + "&filename=" + filename, filename, "file outline","fileOpenMiddleWare",0,0);
		}else{
			window.open("../SystemAOB/functions/file_system/index.php?controlLv=2&mode=file&dir=" + currentPath + "&filename=" + filename, filename, "file outline","fileOpenMiddleWare");
		}
		
	}
});

$( ".item" ).hover(
  function() {
    $(this).addClass("selected");
  }, function() {
    $(this).removeClass("selected");
  }
);

$( ".item" ).dblclick(function(e){
	e.preventDefault();
	var divContent = $(this).text();
	if (divContent == "../"){
		//Go back one page
		if (currentPath.substring(1,currentPath.length - 1).includes("/") == false || currentPath == "/"){
			return;
		}
		currentPath = currentPath.split('\\').join("/");
		currentPath = currentPath.replace("/" + currentPath.split("/").splice(-1,1).join("/"),"");
		window.location.href = "readonlyFileViewer.php?path=" + currentPath;
	}else{
		//Redirect to new page
		if ($(this).html().includes("file outline")){
			//This is a file, select it
			var filename = $(this).text().replace("//","/");
			var fullpath = currentPath + "/" + filename;
			//console.log(fullpath);
			window.location.href = "selectConvert.php?filepath=" + fullpath + "&filename=" + filename;
			
		}else{
			//This is a folder, open it
			window.location.href = "readonlyFileViewer.php?path=" + currentPath + "/" + divContent;
		}
		
	}
  });
  
</script>
</body>
</html>