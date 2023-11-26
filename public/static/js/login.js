$(document).ready(function(){
	if(window.addEventListener){
		window.addEventListener("load", loaded, false);
	}else if(window.attachEvent){
		window.attachEvent("onload", loaded);
	}else if(document.getElementById){
		window.onload=loaded;
	}
	if(detectIE()){
		$("body").prepend('<div class="error-box" style="text-align:center">Dear Internet Explorer user, you must try the awesome browser. Click here to download <a href="http://getfirefox.com" target="_blank">Firefox</a> browser!</div>');
		$("#uname").val('Username').live("focus", function(){
			if($(this).val() == 'Username') $(this).val('');
		}).live("blur", function(){
			if(!$(this).val()) $(this).val('Username');
		});
		$("#ifpssd").val('Password').live("focus", function(){
			if($(this).val() == 'Password') $(this).val('');
		}).live("blur", function(){
			if(!$(this).val()) $(this).val('Password');
		});
	}
});
function iFresponse(st, id){
	setTimeout(iFtimereload, 1000);
}
function iFtimereload(){
	document.getElementById("timereload").value--;
	if(document.getElementById("timereload").value==0){
		window.location.reload();
	}
	else setTimeout(iFtimereload, 1000);
}
function detectIE(){
	var ua = window.navigator.userAgent;
	
	var msie = ua.indexOf('MSIE ');
	if(msie > 0){
		return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
	}
	
	var trident = ua.indexOf('Trident/');
	if(trident > 0){
		var rv = ua.indexOf('rv:');
		return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
	}
	
	var edge = ua.indexOf('Edge/');
	if(edge > 0){
		return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
	}
	
	return false;
}
function base_url(id){
	return base_urls + id;
}
function site_url(id){
	return site_urls + id;
}
function loaded(){
	$("#page-container").css({"display":"block"});
	$("#uname").focus();
}
function iFlogin_s(){
	$("#iflogin_r").html('<div style="padding:9px 0"><img src="'+ base_url('static/i/login.gif') +'" alt="Please wait.." title="Please wait.."></div>').fadeIn(function(){ $("#iflogin_f").slideUp(); });
	$("#iflogin_f").ajaxSubmit({
		success:function(response){
			$("#iflogin_r").html(response);
		},
		timeout:(60 * 1000),
		error:function(response){
			$("#iflogin_r").html('<div class="error-box">'+ response.status +' - '+ response.statusText +'</div>');
			$("#iflogin_f").slideDown();
		}
	});
	return false;
}