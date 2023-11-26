var jq = $.noConflict();

jq(document).ready(function(){
	if(window.addEventListener){
		window.addEventListener("load", loaded, false);
	}else if(window.attachEvent){
		window.attachEvent("onload", loaded);
	}else if(document.getElementById){
		window.onload=loaded;
	}
	
	jq("#sidebar > ul > li > a").click(function(){
		if(jq(this).next().length){
			jq(this).next().slideToggle("slow");
		}
	});
	
	jq("#rightbar h1").click(function(){
		if(jq(this).next().length){
			jq(this).next().toggle();
		}
	});
	jq(".toggle").click(function(){
		if(jq(this).html() == "+"){
			jq(this).html("&minus;");
		}
		else jq(this).html("+");
	});
	
	jq("#file").live("change", function(event){
		if(window.File && window.FileList && window.FileReader){
			var files = event.target.files;
			for(var i=0; i < files.length; i++){
				var file = files[i];
				if(!file.type.match("image")){
					alert("Invalid image file.");
					jq("#file").val('');
					continue;
				}
				var picReader = new FileReader();
				picReader.addEventListener("load", function(event){
					var picFile = event.target,
					preview = '<a href="'+ picFile.result +'" target="_blank"><img src="'+ picFile.result +'" /></a>';
					if(jq("#file_preview").length){
						jq("#file_preview").html(preview);
					}
					else jq("#file_holder").append('<td id="file_preview">'+ preview +'</td>');
				});
				picReader.readAsDataURL(file);
			}
		}
	});
	
	jq("#file_1").live("change", function(event){
		if(window.File && window.FileList && window.FileReader){
			var files = event.target.files;
			for(var i=0; i < files.length; i++){
				var file = files[i];
				if(!file.type.match("image")){
					alert("Invalid image file.");
					jq("#file_1").val('');
					continue;
				}
				var picReader = new FileReader();
				picReader.addEventListener("load", function(event){
					var picFile = event.target,
					preview = '<a href="'+ picFile.result +'" target="_blank"><img src="'+ picFile.result +'" /></a>';
					if(jq("#file_preview_1").length){
						jq("#file_preview_1").html(preview);
					}
					else jq("#file_holder_1").append('<td id="file_preview_1">'+ preview +'</td>');
				});
				picReader.readAsDataURL(file);
			}
		}
	});
	
	jq("#file_2").live("change", function(event){
		if(window.File && window.FileList && window.FileReader){
			var files = event.target.files;
			for(var i=0; i < files.length; i++){
				var file = files[i];
				if(!file.type.match("image")){
					alert("Invalid image file.");
					jq("#file_2").val('');
					continue;
				}
				var picReader = new FileReader();
				picReader.addEventListener("load", function(event){
					var picFile = event.target,
					preview = '<a href="'+ picFile.result +'" target="_blank"><img src="'+ picFile.result +'" /></a>';
					if(jq("#file_preview_2").length){
						jq("#file_preview_2").html(preview);
					}
					else jq("#file_holder_2").append('<td id="file_preview_2">'+ preview +'</td>');
				});
				picReader.readAsDataURL(file);
			}
		}
	});
	
	jq("#file_3").live("change", function(event){
		if(window.File && window.FileList && window.FileReader){
			var files = event.target.files;
			for(var i=0; i < files.length; i++){
				var file = files[i];
				if(!file.type.match("image")){
					alert("Invalid image file.");
					jq("#file_3").val('');
					continue;
				}
				var picReader = new FileReader();
				picReader.addEventListener("load", function(event){
					var picFile = event.target,
					preview = '<a href="'+ picFile.result +'" target="_blank"><img src="'+ picFile.result +'" /></a>';
					if(jq("#file_preview_3").length){
						jq("#file_preview_3").html(preview);
					}
					else jq("#file_holder_3").append('<td id="file_preview_3">'+ preview +'</td>');
				});
				picReader.readAsDataURL(file);
			}
		}
	});

	KE.show({
		id:"editor", skinType:"editor_office", cssPath:"<?php echo base_url('static/css/editor.css') ?>"
	});
});
function iFresponse(st, id){
	if(st == 1){
		setTimeout(iFtimeout, 1000);
		jq("#"+ id).fadeOut();
	}else if(st == 2){
		setTimeout(iFtimereload, 1000);
		jq("#"+ id).fadeOut();
	}else if(st == 3){
		setTimeout(iFreferrer, 2000);
	}else if(st == 4){
		jq("#"+ id).get(0).reset();
		jq("#"+ id).slideDown();
	}
}
function iFtimeout(){
	setTimeout(function(){
		jq(".ifclose").click();
	}, 3000);
}
function iFtimereload(){
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}
function base_url(id){
	return base_urls + id;
}
function site_url(id){
	return site_urls + id;
}
function loaded(){
	jq("#page-container").css({"display":"block"});
	jq("#rightbar").css({"min-height": jq(window).height() +"px", "width": (jq(window).width() -340) +"px"});
	jq("#sidebar").css({"min-height": jq(window).height() +"px", "height": (jq("#rightbar").height()) +"px"});
}
function popup(tp, url){
	jq("#ifpopcontent").html('<center><img class="ifloading" src="'+ base_url('static/img/loader.gif') +'" alt="Loading.." title="Loading.."></center>');
	switch(tp){
		case 1:
			jq("#ifbox").bPopup({loadUrl:url, contentContainer:"#ifpopcontent"});
			break;
		case 2:
			jq("#ifbox").bPopup({loadUrl:url, contentContainer:"#ifpopcontent", follow:false});
			break;
		case 3:
			jq("#ifbox").bPopup({loadUrl:url, contentContainer:"#ifpopcontent", modalClose:false});
			break;
		default:
			jq("#ifbox").bPopup({loadUrl:url, contentContainer:"#ifpopcontent", follow:false, modalClose:false});
			break;
	}
}
function credit_type(id){
	window.location.href = site_url('user/'+ id);
}
function iForm_s(id){
	jq("#iform_r"+ id).html('<center><img src="'+ base_url('static/img/loading.gif') +'" alt="Please wait.." title="Please wait.."></center>').fadeIn(function(){ jq("#iform_f"+ id).slideUp(); });
	jq("#iform_f"+ id).ajaxSubmit({
		success:function(response){
			jq("#iform_r"+ id).html(response);
		},
		timeout:(60 * 1000),
		error:function(response){
			jq("#iform_r"+ id).html('<div class="error-box">'+ response.status +' - '+ response.statusText +'</div>');
			jq("#iform_f"+ id).slideDown();
		}
	});
	return true;
}
function iForms_s(id){
	jq("#iforms_r"+ id).html('<center><img src="'+ base_url('static/img/loading.gif') +'" alt="Please wait.." title="Please wait.."></center>').fadeIn(function(){ jq("#iforms_f"+ id).slideUp() });
	jq("#iforms_f"+ id).ajaxSubmit({
		success:function(response){
			if(id==10) jq(window).unbind("beforeunload");
			jq("#iforms_r"+ id).html(response);
		}
	});
	return false;
}
function xlabel(val){
	if(val == "new"){
		jq("#new_label").slideDown().focus();
	}
	else jq("#new_label").slideUp();
}
function setLen(){
	var maxLen = Number(jq("#form_counter").attr("maxlength")), curLen = jq("#form_counter").val().length, amountLen = curLen ? (maxLen - curLen) : maxLen;
	jq("#text_counter").html(amountLen +'/'+ maxLen);
}
jq(window).resize(loaded);
jq("#form_counter").live("keyup", function(){
	var maxLen = Number(jq(this).attr("maxlength")),
	curLen = jq(this).val().length,
	amountLen = maxLen - curLen;
	jq("#text_counter").html(amountLen +'/'+ maxLen);
});
jq(".delete").live("click", function(){
	var t = jq(this).attr("t"),
	tp = jq(this).attr("tp"),
	dx = jq(this).attr("dx"),
	dataString = 'idx='+ dx;
	if(confirm("WARNING: This action may affect to the other data.\r\nAre you sure you want to delete this "+ t +"?")){
		$.ajax({
			type: "POST",
			url: site_url('process/'+ tp +'/delete'),
			data: dataString,
			cache: false,
			success: function(response){
				window.location.reload();
			},
			error: function(response){
				alert(response.status +' - '+ response.statusText);
			}
		});
	}
});
jq(".remove").live("click", function(){
	var t = jq(this).attr("t"),
	tp = jq(this).attr("tp"),
	dx = jq(this).attr("dx"),
	dataString = 'idx='+ dx;
	if(confirm("PERINGATAN:\r\nAksi ini mungkin akan berpengaruh terhadap data lainnya.\r\nApakah Anda yakin ingin menghapus "+ t +" ini?")){
		jq("#attr_"+ tp + dx).html('Deleting..');
		$.ajax({
			type: "POST",
			url: site_url('process/'+ tp +'/delete'),
			data: dataString,
			cache: false,
			success: function(response){
				jq("#list_"+ tp +"_"+ dx).remove();
				window.location.reload();
			},
			error: function(response){
				alert(response.status +' - '+ response.statusText);
				window.location.reload();
			}
		});
	}
});
function Inint_AJAX(){
	try{ return new ActiveXObject("Msxml2.XMLHTTP"); }catch(e){}
	try{ return new ActiveXObject("Microsoft.XMLHTTP"); }catch(e){}
	try{ return new XMLHttpRequest(); }catch(e){}
	alert("XMLHttpRequest not supported");
	return null;
};
function dochange(src, val, sel){
	var req = Inint_AJAX();
	req.onreadystatechange = function(){
		if(req.readyState==4){
			if(req.status==200) document.getElementById(src).innerHTML=req.responseText;
		}
	};
	req.open("GET", base_urls +"index.php/process/autocomplete/"+ src +"/"+ val +"/"+ sel);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=iso-8859-1");
	req.send(null);
};
function sum(){
    var elems = document.getElementsByName('koreksi[]');

    var sum = 0;
    for (var i = 0; i < elems.length; i++)
    {
        sum += parseInt(elems[i].value);
    }

    document.getElementById('total').value = sum;
}
function check(val){
    var koreksi = document.getElementById('total').value;

    if(koreksi != val){
    	alert("Koreksi rincian dana tidak sesuai dengan nominal dari TAPD.");
    	return false;
    }else return;    
}