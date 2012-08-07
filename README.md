ss-timelinejs
=============

a silverstripe - timeline JS intergration module 

to show in the `<body>` of your site.

```html
	<div id="timeline-embed"></div>
	<script type="text/javascript">
	    var timeline_config = {
			width:				"100%",
			height:				"600",
			source:				'path_to_json/or_link_to_googlespreadsheet',
			start_at_end: 		false,							//OPTIONAL START AT LATEST DATE
			start_at_slide:		'4',							//OPTIONAL START AT SPECIFIC SLIDE
			start_zoom_adjust:	'3',							//OPTIONAL TWEAK THE DEFAULT ZOOM LEVEL
			hash_bookmark:		true,							//OPTIONAL LOCATION BAR HASHES
			font:				'Bevan-PotanoSans',				//OPTIONAL FONT
			lang:				'fr',							//OPTIONAL LANGUAGE
			maptype:			'watercolor',					//OPTIONAL MAP STYLE
			css:				'path_to_css/timeline.css',		//OPTIONAL PATH TO CSS
			js:					'path_to_js/timeline-min.js'	//OPTIONAL PATH TO JS
		}
	</script>
	<script type="text/javascript" src="path_to_js/timeline-embed.js"></script>
```