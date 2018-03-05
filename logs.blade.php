<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		* { margin: 0; padding: 0; box-sizing: border-box; }
	    body { font: 13px Helvetica, Arial; }
		.device-logs { list-style-type: none; margin: 0; padding: 0; }
      	.device-logs li { padding: 5px 10px; }
      	.device-logs li:nth-child(odd) { background: #eee; }
      	#parentDiv{ 
      		height:600px;
		  overflow:auto;
		  border: 2px black solid;
		}
	</style>
</head>
<body>
	<div id="parentDiv">
		<ul class="device-logs"></ul> 
	</div>
<script src="{{ url('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript">
	window.opener.log_device();

	function window_open_log_device(type, logmessage){

        var d = new Date();   

		$('.device-logs').append($('<li>').text(d.getHours() + ':' + d.getMinutes() + ':' + type + ' : ' + logmessage)); 

		var objDiv = document.getElementById("parentDiv");
		objDiv.scrollTop = objDiv.scrollHeight;
	}
</script>
</body>
</html>