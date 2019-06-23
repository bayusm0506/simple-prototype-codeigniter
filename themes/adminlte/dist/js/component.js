Component = {
	show_load : true,
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
		//Component.set_load();
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
					Component.show_alert('error',$str.msg);
					
					//return;
				}else if( $str.status == 'info' ){
					Component.show_alert('info',$str.msg);
					
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
		Component.set_load();
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
					myXhr.upload.addEventListener('progress',Component.progressHandlingFunction, false);
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
		Component.hide_load();
		
	},
	complete : function(){
		Component.hide_load();
	},
	show_alert : function( $type , $str){
		
		if( $type =='error' ){
			// $("#t-message").text("Pesan Error!");
			// $("div#container-m").removeClass().addClass('alert alert-danger');
			// $("p#m-message").html($str);
			// $("div.message-container").show();

			$(".modal-title").text("Pesan Error!");
			$("div#modal-compare").removeClass().addClass('modal modal-danger fade');
			$("p#m-message").html($str);
			$("div#modal-compare").modal();
		}else if( $type == "info" ){
			// $("#t-message").text("INFO!");
			// $("div#container-m").removeClass().addClass('alert alert-info');
			// $("p#m-message").html($str);
			// $("div.message-container").show();

			$(".modal-title").text("Pesan Success!");
			$("div#modal-compare").removeClass().addClass('modal modal-success fade');
			$("p#m-message").html($str);
			$("div#modal-compare").modal();
		}else{
			alert( "info tidak terdeteksi" );
			return;
		}
	}
}
