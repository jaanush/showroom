<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<style type="text/css">
	body {
		margin: 0;
		padding: 0;
		overflow:hidden;
	}
	#header {
		position: fixed;
		top: 0px;
		left: 0px;
		height: 83px;
		width: 100%;
		z-index: 100;
		opacity: 0.9;
		text-align: center
	}
	#footer {
		position: fixed;
		overflow: hidden;
		bottom: 0px;
		left: 0px;
		height: 47px;
		width: 100%;
		z-index: 50;
		opacity: 0.9;
		text-align: center
	}
	#footer img {
		/*margin-bottom: -40px*/
	}
	#crop {
		position: absolute;
		top: 0px;
		left: 0px;
		width: 100%;
		height: 100%;
		overflow: hidden;
    	cursor: move;
	}
	#container {
		display: inline-block;
		padding: 48px 0px 15px;
		background: #f2f2f2 url(<?php print($themeRoot) ?>/images/floral_440_2_bg.png) center center;
	}
	#container img {
		position: relative;
		margin: 50px;
		border: 10px solid #FFF;
		box-shadow: 5px 5px 7px #aaa;
		-moz-box-shadow: 5px 5px 7px #aaa;
		-webkit-box-shadow: 5px 5px 7px #aaa;
	}
	.ui-flickable-container {
    	cursor: move;
		background: #f2f2f2 url(<?php print($themeRoot) ?>/images/floral_440_2_bg.png) center center;
	}
	/*
	.ui-flickable-container {
		height: 120%;
	}
	*/
	.ui-flickable-wrapper {
		background-color: transparent !important;
	}
	#header img, #footer img {
    	cursor: default;
	}
</style>
<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
<script src="<?php print($themeRoot) ?>/js/jquery.kinetic.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php print($themeRoot) ?>/js/jquery.rotate-0.1.js" type="text/javascript" charset="utf-8"></script>
<script tyle="text/javascript">

(function($) {
	$.fn.log = function(msg) {
		if(window.console) {
			console.log("%s: %o", msg, this);
		} else {
			alert(msg);
		}
		return this;
	}
})(jQuery);

(function($) {
	$.fn.toPhoto = function() {
		this.each(function(idx,image){
			$(image).load(function(){
				var img=$(this);
				var ow=img.outerWidth(true), oh=img.outerHeight(true), iw=img.innerWidth(), ih=img.innerHeight();
				var canvas=$('<canvas width="'+ow+'" height="'+oh+'"></canvas>');
				if(!canvas[0].getContext) return;
				var ctx=canvas[0].getContext('2d');
				img.replaceWith(canvas);
				//console.log('Replaced',canvas[0]);
			  	ctx.translate(ow/2,oh/2);
				ctx.fillStyle = '#FFFFFF';
				//ctx.strokeStyle = '#FFFFFF';
				ctx.rotate((Math.random()-0.5)*0.1);
				ctx.shadowOffsetX = 3;
				ctx.shadowOffsetY = 3;
				ctx.shadowBlur = 10;
				ctx.shadowColor = "#777777"
	       		ctx.fillRect(-Math.floor(iw/2)-10,-Math.floor(ih/2)-10,iw+20,ih+20);             // x, y, width, height
				ctx.shadowOffsetX = 0;
				ctx.shadowOffsetY = 0;
				ctx.shadowBlur = 0;
				ctx.shadowColor = "transparent";
				//console.log('Drawing',image,iw/2,ih/2);
				ctx.drawImage(this, -Math.floor(iw/2), -Math.floor(ih/2));
			});
		});
	}
	$.fn.scramble = function() {
		this.each(function(idx,image){
			$(this).jqrotate((Math.random()-0.5)*5);
		});
	}
})(jQuery);

$(document).ready(function() {
	//$('#container img').toPhoto();
	$('#container img').scramble();
});

$(window).load(function() {
	//$('#test').toPhoto();
	$('#container').height(($(window).height()-63)+'px');
	$(window).resize(function(){$('#container').height(($(window).height()-63)+'px');});
    $('#crop').kinetic({y:false,maxvelocity:80,slowdown:0.95});
	$('#expand').toggle(function() {
		$(this).parent().animate({ height: $(this).height()}, 200);
	}, function() {
		$(this).parent().animate({ height: 47}, 200);
	});
});
</script>
</head>
<body>
	<div id="header"><img src="<?php print($themeRoot) ?>/images/header_low.png" alt="" /></div>
	<div id="crop">
		<div id="container">
			<table style="height: 100%">
				<tbody>
					<tr>
						<td><img id="test" src="images/wedding/simon_maribell/001_480.jpg" alt="001" /></td>
						<td><img src="images/wedding/simon_maribell/002_480.jpg" alt="002" /></td>
						<td><img src="images/wedding/simon_maribell/003_480.jpg" alt="003" /></td>
						<td><img src="images/wedding/simon_maribell/004_480.jpg" alt="004" /></td>
						<td><img src="images/wedding/simon_maribell/005_480.jpg" alt="005" /></td>
						<td><img src="images/wedding/simon_maribell/006_480.jpg" alt="006" /></td>
						<td><img src="images/wedding/simon_maribell/007_480.jpg" alt="007" /></td>
						<td><img src="images/wedding/simon_maribell/008_480.jpg" alt="008" /></td>
						<td><img src="images/wedding/simon_maribell/009_480.jpg" alt="009" /></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id="footer"><img id="expand" src="<?php print($themeRoot) ?>/images/footer_high.png" alt="" /></div>
</body>
</html>