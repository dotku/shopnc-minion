$("#template-selector").change(function(){
	var url = window.location.href;
	var splitParts = url.split('&homeview_template_id=');
	url = splitParts[0] + '&homeview_template_id=' + $(this).attr("value");
	
	if (splitParts[1]) {
		// deal splitParts[1]
		var postPart = splitParts[1].split("&");
		if (postPart[1]) {
			for(i = 1; i < postPart.size(); i++) {
				url += "&" + postParts[i];
			}
		}
		var postPart = splitParts[1].split("#");
		if (postPart[1]) {
			url += "#" + postPart[1];
		}
	}
	 
	if (window.console) {
		console.log(url);
	}
	window.location = url;
});