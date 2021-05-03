var $login = (modulo => {
	modulo.ingresar = e => {
		e.preventDefault();
		if ( $.trim($('#usuario').val())=='' || $.trim($('#password').val())=='' ) {
			/*objUtil.notificacion('Llene los campos por favor', "warning", 200, "bottomRight", "fadeInUp", "fadeOutDown");
			setTimeout(function() {
				$.noty.closeAll();
			}, 4300);*/
			return;
		}

	}
    return modulo;
})($login || {});

$(function() {
	/*$.ajaxSetup({
		headers: {
			"<?=$this->security->get_csrf_token_name();?>":  "<?=$this->security->get_csrf_hash();?>",
			   data:{"<?=$this->security->get_csrf_token_name();?>":  "<?=$this->security->get_csrf_hash();?>"}
		}
	});*/
    setTimeout(function(){
		$('.login-html').addClass('animated shake');
		$('.historial-html').addClass('animated shake');
	},500);

	$(".jq_ver_historial").off("click").on("click",function(event) {
		event.preventDefault();
		$(".login-html").hide();
		$(".historial-html").show();

	});
    
	$("body").find(".jq_back_login").off("click").on("click",function(event) {
		event.preventDefault();
		$(".login-html").show("slow");
		$(".historial-html").hide();
	});

	$("#btn_logino").off("click").on("click", $login.ingresar);
});