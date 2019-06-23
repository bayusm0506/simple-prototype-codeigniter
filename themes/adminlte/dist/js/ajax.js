Ajax = {
	show_load : true,
	get_cookie : function(cname){
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return false;
		
	},
	set_load : function(){	
		$("div.messsage-container").hide();
		if( this.show_load == true ){
			$("div.messsage-container").show();
		}
	},
	hide_load : function(){
		$("div.messsage-container").hide();
	},
	run : function( $url, $type, $data,$callback,datatype='json'){
		Ajax.set_load();
		$("div.error-all").remove();
		$("div.message-container").hide();
		$.ajax({
			url: $url,
			dataType: datatype,
			type: $type,
			data: $data,
			cache:false,
			success: function($str){
				if( $str.status == 'error' ){
					Ajax.show_alert('error',$str.msg);
					
					//return;
				}else if( $str.status == 'info' ){
					Ajax.show_alert('info',$str.msg);
					
					//return;
				}
				$callback( $str )
			},
			error: this.error,
			complete:this.complete,
			statusCode: {
				403: function($param) {
					alert("Anda Tidak Memiliki Akses untuk ini, Silahkan Login Kembali");
					//window.location.href = url_administrator;
				},
				404: function($param) {
					alert("URL Aksi Tidak ditemukan, Silahkan hubungi Administrator Anda");
				},
				500: function($param) {
					alert("URL Aksi Tidak ditemukan, Silahkan hubungi Administrator Anda");
				}
			}
		});
	},
	upload : function($url, $form, $callback,$dataType = 'json'){
		Ajax.set_load();
		//var editor_data = CKEDITOR.instances.editor1.getData();
		var frm = $('form[name='+$form+']');
		var formData = new FormData(frm.get(0));
		
		$("div.error-all").remove();
		$("div.message-container").hide();
		
		$.ajax({
			url: $url,
			type: 'POST',
			dataType: $dataType,
			xhr: function() {
				myXhr = $.ajaxSettings.xhr();
				if(myXhr.upload){
					myXhr.upload.addEventListener('progress',Ajax.progressHandlingFunction, false);
				}
				return myXhr;
			},
			success:completeHandler = $callback,
			error: errorHandler = this.error,
			complete:this.complete,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			statusCode: {
				403: function($param) {
					alert("Anda Tidak Memiliki Akses untuk ini, Silahkan Login Kembali");
					//window.location.href = url_administrator;
				},
				404: function($param) {
					alert("URL Aksi Tidak ditemukan, Silahkan hubungi Administrator Anda");
				},
				500: function($param) {
					alert("URL Aksi Tidak ditemukan, Silahkan hubungi Administrator Anda");
				}
			}
		});
		
	},
	progressHandlingFunction : function(e){
		if(e.lengthComputable){
			var nilai = (parseInt(e.loaded)/100) * parseInt(e.total);
			
			var percent = (e.loaded / e.total) * 100;	
			
			var strProgress = "<div class='progress'>";
				strProgress += "<div class='progress-bar' id='bar-prog' role='progressbar' aria-valuenow='70' aria-valuemin='0' aria-valuemax='100' style='width:0%'>";
				strProgress += "0%";
				strProgress += "</div>";
				strProgress += "</div>";
			if($("div#element-progress").length){
				if( $("div#bar-prog").length){
					
				}else{
					$("div#element-progress").html(strProgress);
				}
				$("div#bar-prog").css('width','0%').text('0%');
				var number = Math.round(percent);
				var str_label = "..."+number+"%";
				if(parseInt(number) == 100){
					str_label = "... 80%";
					number = "80%";
					$("div#bar-prog").css('width',number).text(str_label);
				}
			
			}	
				
			//console.log(percent);
			/*if($("span#loading_"+append_div).length){
				$("span#loading_"+append_div).remove();
			}
			var number = Math.round(percent);
			var str_label = "..."+number+"%";
			if(parseInt(number) == 100){
				str_label = "100%";
			}
			var str = '<span class="alert alert-success loading-page" id="loading_'+append_div+'">'+str_label+'</span>';
			$("input[name="+append_div+"]").after(str);*/
		}
	},
	progressFull : function(){
		$("div#bar-prog").css('width','100%').text('100%');
	},
	error : function( $param ){
		console.log($param)
		Ajax.hide_load();
		
	},
	complete : function(){
		Ajax.hide_load();
	},
	run_error : function( $str , $format = 'name'){
		$.each( $str, function( key, value ) {
		 var keyn = key;
		  key = key.replace("[]", "");
		  
			if( $format == 'name' ){ 
			  $("div#"+key).remove();
			  var _element = $( "[name='"+keyn+"']" );
			  if(_element.parent().hasClass('input-group') ){
				 //console.log(key);
				_element.parent().after( '<div class="error-validation error-all" id="'+key +'" >'+value+'</div>' ); 
			  }else{
				_element.last().after( '<div class="error-validation error-all" id="'+key +'" >'+value+'</div>' );
			  }
			}else if( $format == 'id' ){
				 $("div#"+key).remove();
				 $( "#"+keyn).last().after( '<div class="error-validation error-all" id="'+key +'" >'+value+'</div>' );
			}
		});

	},
	run_error_top : function( $str ){
		$("div.error-all").remove();
		$.each( $str, function( key, value ) {
		 var keyn = key;
			key = key.replace("[]", "");
			//$("div#"+key).remove();
			//$( "[name='"+keyn+"']" ).after( '<div class="error-validation error-all" id="'+key +'" >'+value+'</div>' );
		});

	},
	error_line : function( $type, $str ){
		Ajax.show_alert( $type, $str );
	},
	show_alert : function( $type , $str){
		
		if( $type =='error' ){
			$("#t-message").text("Pesan Error!");
			$("div#container-m").removeClass().addClass('alert alert-danger');
			$("p#m-message").html($str);
			$("div.message-container").show();
		}else if( $type == "info" ){
			$("#t-message").text("INFO!");
			$("div#container-m").removeClass().addClass('alert alert-info');
			$("p#m-message").html($str);
			$("div.message-container").show();
		}else{
			alert( "info tidak terdeteksi" );
			return;
		}
	}
}
