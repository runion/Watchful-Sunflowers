<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
  <meta charset="utf-8" />
  <title>Square Transforming - The Watchful Sunflowers</title>
  <script src="/common/jquery-latest.min.js"></script>
  <script src="/common/js/jquery-css-transform.js"></script>
  <script src="/common/js/jquery.textshadow.js"></script>
  <script>
  /*
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);


  jQuery(function($) {
	$("#shadowText").textShadow({
		color:   "#000",
		xoffset: "5px",
		yoffset: "5px",
		radius:  "5px",
		opacity: "50"
	});
	var midHeight = $('div.rectangle:first').height() / 2;
	var midWidth = $('div.rectangle:first').width() / 2;
	var offset = $('div.rectangle:first').offset();
	var ww = $(window).width();
	var wh = $(window).height();
	constDist = Math.round(Math.sqrt((ww * ww) + (wh * wh))); // hypotenuse of window
	var topOffset = offset.top;
	var leftOffset = offset.left;
	midpointX = leftOffset + midWidth;
	midpointY = topOffset + midHeight;
	
/*	$(window).mousemove( $.throttle(100, function(e) {
		if(e.pageY > midpointY) {
			if(e.pageX > midpointX) {
				relX = e.pageX - midpointX; //opposite
				relY = e.pageY - midpointY; //adjacent
				hypDistance = Math.sqrt((relX * relX) + (relY * relY));
				scaleY = (constDist - hypDistance) / constDist;
				atanA = Math.atan(relX / relY);
				angleA = Math.round(atanA * 180 / 3.14159) * -1;
				//console.log(angleA);
				$('div.rectangle:first').css('transform', 'rotate('+angleA+'deg) scaleY('+scaleY+')');

			}
		}
		else if(false) {
		
		}
	}));*/
	
	$(".stem").each(function() {
			maxMargin = 22;
			marginLR = Math.round(maxMargin * Math.random());
			$(this).css('margin', '45px '+marginLR+'px').data('margining', marginLR);
		});	
	
	$(window).mousemove( $.throttle(100, function(e) {
		var mouseX = e.pageX;
		var mouseY = e.pageY;
		$("div.rectangle").each(function() {
			var midHeight = $(this).height() / 2;
			var midWidth = $(this).width() / 2;
			var offset = $(this).offset();
			var topOffset = offset.top;
			var leftOffset = offset.left;
			midpointX = leftOffset + midWidth;
			midpointY = topOffset + midHeight;
			relX = mouseX - midpointX; //opposite
			relY = mouseY - midpointY; //adjacent
			hypDistance = Math.sqrt((relX * relX) + (relY * relY)); //Thank You Pythagoras
			//scaleY = (((constDist * 1.5) - hypDistance) / (constDist * 1.5)); //1.5 is the fudge factor, at 1.0 we could get close to scaleY -> 0
			scaleY = ((constDist * 1.5) / ((constDist * 1.5) - hypDistance)) - .6; // "-.6" is the fudge factor, nominal values are in the range of 1.0 - 1.75
			//$("#log").text(scaleY);
			scaleY = Math.max(0.5, scaleY); // enforce constraints
			scaleY = Math.min(1, scaleY); // enforce constraints
			atanA = Math.atan(relX / relY);
			angleA = Math.round(atanA * 180 / 3.14159) * -1;
			if(mouseY < midpointY) { angleA = angleA - 180; }
			$(this).css('transform', 'rotate('+angleA+'deg) scaleY('+scaleY+')').data('currRotation', angleA);
		});
		$("#shadowText").each(function() {
			var testInit = $(this).data('topOffset');
			if(!testInit) {
				var offset = $(this).offset();
				var topOffset = offset.top;
				var leftOffset = offset.left + ($(this).width() / 2);
				$(this).data('topOffset', topOffset);
				$(this).data('leftOffset', leftOffset);
			}
			else {
				var topOffset = testInit;
				var leftOffset = $(this).data('leftOffset');
			}
			distX = mouseX - leftOffset;
			distY = mouseY - topOffset;
			xoffset = -distX / 6;
			yoffset = -distY / 6;
			var radius = Math.max(2, Math.floor(Math.sqrt(distX * distX + distY * distY) / 18));
			$("#shadowText").css('text-shadow', "#000 " + xoffset+"px " +yoffset+"px " +radius+"px");
		});
	}));
  });
  </script>
  <style type="text/css">
	body {
		margin: 0;
		padding: 0;
		background: #aaa;
	}
	.stem {
		background:url(stem.png) 35% 100% no-repeat;
		padding-bottom: 50px;
		margin: 45px 5px;
		float: left;
	}
	.rectangle {
		width: 21px;
		height: 22px;
		background: url(sunflower_1.png) no-repeat;
	}
	div.skew1 {
		/*background: #dd227a;*/
		-moz-transform: rotate(-14deg) skew(0deg,4deg);
	}
	div.skew2 {
		/*background: #f00f00;*/
		-moz-transform: rotate(-16deg) skew(16deg,16deg);
	}
	div.skew3 {
		/*background: #baddad;*/
		/*-moz-transform: matrix(1, 0, 0.6, 1, 20px, 0px);*/
		-moz-transform: rotate(26deg) skew(-12deg,-12deg) scaleY(0.9);
	}
	div.skew4 {
		/*background: #3a121e;*/
		-moz-transform: rotate(-20deg) skew(16deg,16deg) scaleY(0.9);
	}
	div.skew5 {
		/*background: #eab121;*/
		-moz-transform: rotate(-20deg) skew(16deg,16deg) scaleY(0.9);
	}
	#log {
		position: absolute;
		right: 22px;
		bottom: 0;
	}
	#stems {
		position: absolute;
		bottom: 0;
		left: 0;
	}
	#shadowText {
		position: absolute;
		bottom: 35%;
		left: 40%;
		font-size: 26px;
		font-family: times new roman, times, serif;
		color: #ddd;
		text-shadow:#000 -10px 0px 5px;
	}
  </style>
  <!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
	<span id="shadowText">The Watchful Sunflowers</span>
	<div id="stems">
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle"></div></div>
		<div class="stem"><div class="rectangle skew1"></div></div>
		<div class="stem"><div class="rectangle skew2"></div></div>
		<div class="stem"><div class="rectangle skew3"></div></div>
		<div class="stem"><div class="rectangle skew4"></div></div>
		<div class="stem"><div class="rectangle skew5"></div></div>
	</div>
	<span id="log">log output</span>
</body>
</html>