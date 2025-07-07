var waitPaste = 0;

getClipboardImage = function(pasteEvent, callback){
	if(pasteEvent.clipboardData == false){
		if(typeof(callback) == "function"){
			callback(undefined);
		}
	};
	var items = pasteEvent.clipboardData.items;
	if(items == undefined){
		if(typeof(callback) == "function"){
			callback(undefined);
		}
	};
	for (var i = 0; i < items.length; i++) {
		if (items[i].type.indexOf("image") == -1) continue;
		var blob = items[i].getAsFile();
		if(typeof(callback) == "function"){
			callback(blob);
		}
	}
}
pasteZone = function(){
	if ($('#content').is(":focus") && $('#content').attr('data-paste') == 1) {
		return 1;
	}
	else if ($('#message_content').is(":focus") && $('#message_content').attr('data-paste') == 1) {
		return 2;
	}
	else {
		return 0;
	}
}		
pasteStart = function(t){
	if(t == 1){
		startMainUp();
	}
	else if(t == 2){
		startPrivateUp();
	}
}
pasteReset = function(){
	setTimeout(unwaitPaste, 5000);
}	

unwaitPaste = function(){
	waitPaste = 0;
}

$(document).ready(function(){
	
	window.addEventListener("paste", function(e){
		if(waitPaste == 0){
			getClipboardImage(e, function(imageBlob){
				var toPaste = pasteZone();
				if(imageBlob){
					var file = imageBlob;
					waitPaste = 1;
					if(toPaste == 2){
						uploadPrivate(imageBlob);
					}
					else if(toPaste == 1){
						uploadChat(imageBlob);
					}
					pasteReset();
				}
			});
		}
	}, false);

});