<?php
/*
	@! jQuery photo uploader
-----------------------------------------------------------------------------	
	# author: @akshitsethi
	# web: http://www.akshitsethi.me
	# email: ping@akshitsethi.me
	# mobile: (91)9871084893
-----------------------------------------------------------------------------
	@@ The biggest failure is failing to try.
*/
?>
<!doctype html>
<html lang="en">
<head>
<title>Photo uploader via PHP, jQuery and AJAX - A tutorial by akshitsethi.me</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Description" content="Awesome photo uploader using PHP, jQuery and AJAX. Also provides protection against CSRF attacks." />
<meta name="Keywords" content="jquery, php, ajax, plupload, photo uploader, ajax uploader" />
<meta name="Owner" content="Akshit Sethi" />
<link rel="shortcut icon" href="img/favicon.ico">
<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/upload.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.plupload.js"></script>
<script type="text/javascript" src="js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="js/jquery.blockui.js"></script>
<script type="text/javascript" src="js/jquery.timeago.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$("#filelist").niceScroll({
		cursorwidth: "8px",
		cursorborderradius: "0px",
		cursoropacitymin: 0.1,
		cursoropacitymax: 0.3
	});

	$(".side-pane").niceScroll({
		cursorwidth: "8px",
		cursorborderradius: "0px",
		cursoropacitymin: 0.1,
		cursoropacitymax: 0.3
	});

	$(".time").timeago();
});
</script>
</head>
<body>
		<div class="header-inner clearfix">
	<div class="container">
	
		<div class="side-pane">
			<center><span class="highlight-two" style="display: inline-block; margin-top: 190px;">Photos will show over here</span></center>
		</div>

		<div id="uploader" class="main-pane">
			<div id="filelist_header" class="clearfix">
				<div class="filename">Name</div>
				<div class="filesize">Size</div>
				<div class="filestatus">Status</div>
				<div class="filedel"></div>
				<div></div>
			</div>

			<div id="filelist"></div>

			<div class="action-btns">
				<a id="pickfiles" class="login-button btn">Select files to upload</a>
				<a href="javascript:;" id="upload_button" class="login-button upload hide">Upload</a>
			</div>

			<center>
				<div id="upload_info">
					<div id="upload_info_inner">
						<div class="progressbg">
							<div id="percent" class="progress"></div>
						</div>
					</div>

				    <div id="unknown">
						<div id="time2go"></div>
						<div id="upRate"></div>
					</div>
				</div>
			</center>

			<form method="POST" action="process.php" id="processupload">
				<input type="hidden" name="uploaded_photos" id="uploaded_photos" />
				<input type="hidden" name="fkey" value="<?php echo $fkey; ?>" />
			</form>
		</div>

		<script type="text/javascript">
		// <![CDATA[

			$('#upload_button').click(function() {
				$('.side-pane').html('');
				$('#upload_button').hide();
				$('#pickfiles').hide();
				$('#upload_info').show();
				$('#upload_info').css("display","inherit");
				uploader.start();

				$('#filelist').block({
					message: '<center><div class="start-message">Upload in Progress</div></center>',
					css: {
						border: 'none',
						backgroundColor: 'none'
					},
					overlayCSS: {
						backgroundColor: '#fff',
						opacity: '0',
						cursor: 'wait'
					}
				});
			});

			var uploader = new plupload.Uploader({
				runtimes : 'flash, html5',
				browse_button : 'pickfiles',
				container : 'uploader',
				max_file_size : '10mb',
				url : 'php/upload.php',
				flash_swf_url : 'uploader/uploader.swf',
				filters : [
					{ title : "Image files", extensions : "jpg,jpeg,gif,png" }
				]
			});

			uploader.bind('Init', function(up, params) {});
			uploader.init();

			uploader.bind('FilesAdded', function(up, files) {
				/*
					@@ Show / hide various elements
				*/
				$('.upload-message').hide();
				$('.info-message').hide();
				$('#upload_button').show();
				$('#filelist_header').show();

				$.each(files, function(i, file) {
					$('#filelist').append(
						'<div id="' + file.id + '" class="filecontainer">' +
						'<div class="filename"> '+file.name + '</div>'+
						'<div class="filesize">' + plupload.formatSize(file.size) + '</div>'+
						'<div class="filestatus" id="status_'+file.id+'">0%</div>'+
						'<div class="filedel"><a id="remove_'+file.id+'" href="javascript:;"><img src="img/uploader/delete.gif" /></a></div>' +
						'</div>');

					$('#remove_'+file.id).click(function(e) {
						uploader.removeFile(file)
						$('#'+file.id).hide('slow', function() { ('#'+file.id).remove(); });
					});
				});

				up.refresh();
				$('#filelist').animate({scrollTop: $('#filelist').attr("scrollHeight")}, 1500);
			});

			uploader.bind('UploadProgress', function(up, file) {
				$('#status_' + file.id).html(file.percent + "%");
					if(file.percent == 100) {
						$('#' + file.id).block({
							message: '',
							css: {
								border: 'none',
								backgroundColor: 'none'
							},
							overlayCSS: {
								backgroundColor: '#fff',
								opacity: '0.7',
								cursor: 'wait'
							}
						});
					}
				$('#percent').width(uploader.total.percent+"%");
				$('#upRate').text(Math.ceil(uploader.total.bytesPerSec/1024)+" kb/sec");
			});

			uploader.bind('FileUploaded', function(up, file, response) {
				var input = $("#uploaded_photos");
				var data = response.response;
				var details = data.split(',');
					if(details[0] == 'success') {
						var photo_html = '<div class="padding-10 hm-photo clearfix"><a href="uploads/source/'+details[3]+'/'+details[4]+'" target="_blank"><img src="uploads/small/'+details[3]+'/'+details[4]+'"></a><p class="small-text light-text">'+details[1]+'</p><abbr class="time small-text" title="'+details[2]+'"></abbr></div>';
						input.val(input.val() + details[1] + ":");
					} else {
						var photo_html = '<div class="clearfix">'+details[1]+'</div>';
					}
				$('.side-pane').prepend(photo_html);
				$('.time').timeago();
			});

			uploader.bind('UploadComplete', function(up, files) {
				$('#upload_info').hide();
				$('#filelist').unblock({
		       		onUnblock: function () {
		       			$('#filelist_header').hide();
		       			$('#filelist').html('<div style="margin-top: 180px; text-align: center;"><strong>Yay!</strong><br/>All photos have been uploaded.</div>');
				    }
		 		});
			});

	
		</script>


		</div>
	</div>
</body>
</html>