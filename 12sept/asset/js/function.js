function pnotifyAlert(argument){
	if(argument.status=='success'){
		var icon = 'fa fa-check-circle';
		var addClass = 'alert-success';
	}else{
		var icon = 'fa fa-times-circle';
		var addClass = 'alert-danger';
	}
	if(typeof argument.hide !== "undefined"){
		var hide = argument.hide;
	} else {
		var hide = true;
	}

	new PNotify({
				text:argument.msg,
				hide:hide,
				type:argument.status,
				delay:6000,
				nonblock:false,
				icon:icon,
				addclass:addClass,
				history:false,
				before_init:function(){
					if(typeof argument.nestable=='undefined' || !argument.nestable)
						$('.ui-pnotify ').hide();
				}
			});
}
function ajax_request(url,data,callback,nestable)
{
	var return_data;
	var nestable = (nestable!=''?true:false);
	pnotifyAlert({msg:'Please wait..','status':'success',nestable:nestable});
	$.ajax({
			'url':url,
			'type':'POST',
			'data':data,
			success:function(responce)
			{
				if(callback!=''  && typeof(callback) === "function" ){
					callback(responce);
				}
			},
			error: function () 
			{
				//pnotifyAlert({msg:'Some error occured, please try later!','status':'notice'});
			}
	});
}
function hidePnotify(){
    $('.ui-pnotify ').hide();
}