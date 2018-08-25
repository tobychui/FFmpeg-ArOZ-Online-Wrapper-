# FFmpeg-ArOZ-Online-Wrapper-
A simple wrapper for ArOZ Online Beta system. A simple PHP based FFmpeg wrapper with Asynchronous Threadings supported.

## Installation
Download the repo to your desktop, rezipping only the folder "FFmpeg" and upload it to your ArOZ Online System via the "Add or Remove WebApp" interface in the System Settings > Host.

## Web Interface
You can still use the wrapper's WebUI if you are not into the ArOZ Online System. This module also support FloatWindow Mode under Virtual Desktop Interface (ArOZ Online Only).

<img src="https://raw.githubusercontent.com/tobychui/FFmpeg-ArOZ-Online-Wrapper-/master/screenshots/2018-08-25_17-32-31.png">

And the instructions on how to use the API is included in the index page.

<img src="https://raw.githubusercontent.com/tobychui/FFmpeg-ArOZ-Online-Wrapper-/master/screenshots/2018-08-25_17-33-07.png">

## Running on Linux Apache
To run on linux and you get a fresh installation of ArOZ Online, you can run the install.php before performing any testing. The install.php will install avconv onto your system and the rest of the script require avconv in order to work normally.
After installing the avconv, this will shown up on the index page.

<img src="https://raw.githubusercontent.com/tobychui/FFmpeg-ArOZ-Online-Wrapper-/master/screenshots/2018-08-25_17-33-11.png">

## Running on Windows Apache
You do not need to install anything extra if you are installing on Windows version of ArOZ Online Beta (or just Apache Web server). Unless your ffmpeg.exe is corrupted or the folder "ffmpeg-4.0.2-win32-static" is missing, this should be showing up on the index, indicating everything is fine.

<img src="https://raw.githubusercontent.com/tobychui/FFmpeg-ArOZ-Online-Wrapper-/master/screenshots/2018-08-25_17-33-19.png">

## How to use the API
To use the API, you can get started with the following commands.
`
ffmpeg.php?input=filename.mp4&output=filename.webm

ffmpeg.php?input=filename.mp4&output=filename.mp3

ffmpeg.php?passthrough=-i "/media/storage1/test.mp4" -y -codec:a libmp3lame -ac 2 -ar 44100 -ab 128k "/media/storage1/output.mp3"
`
** Paths that passed in can be either real or relative. The script will convert them to real path anyway.
