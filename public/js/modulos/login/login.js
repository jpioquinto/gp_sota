var $login = (modulo => {
	modulo.ingresar = e => {
		e.preventDefault();
		if ( $.trim($('#usuario').val())=='' || $.trim($('#password').val())=='' ) {
			notificacion('Llene los campos por favor', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
			return;
		}
		$util.post({
			controlador: "Login",
			metodo: "loguear",
			datos: "usuario=" + $("#usuario").val() + "&password=" + $("#password").val(),
			funcion: function(data) {
				if (data.Solicitud) {					
					setTimeout(function() {
						location.reload();
					}, 200)
					$(this).removeClass('clicked');
				} else {					
					$.noty.closeAll();
					$(this).removeClass('clicked');					
				}
			}
		});

	};

	modulo.capturaUsuario = function(e) {
		e.preventDefault();
		
		if (e.which == 13) {
			$.trim($(this).val()) != '' ? $('#password').focus() : '';
		}
	};
	
	modulo.capturaPassword = function(e) {
		//e.preventDefault();
		
		if (e.which == 13) {
			$('#btn_logino').trigger('click');
		}
		
		$.trim($(this).val()) != ''
		? $('#verContra').find('.iconoPassword').removeClass('hide')
		: $('#verContra').find('.iconoPassword').addClass('hide');
	};

	modulo.clickVerPassword = function(e) {
		//e.preventDefault();
		
		if ($('#password').attr('type')=='password') {
			$('#password').attr('type', 'text');
			$('#password').attr('data-type', 'text');
			$('#verContra').find('.iconoPassword').attr('src', "images/iconos/svg/vision-off.svg");
		} else {
			$('#password').attr('type', 'password');
			$('#password').attr('data-type', 'password');
			$('#verContra').find('.iconoPassword').attr('src', "images/iconos/svg/observe.svg");
		}
	};

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
	$("#usuario").off("keyup").on("keyup", $login.capturaUsuario);
	$("#password").off("keyup").on("keyup", $login.capturaPassword);
	$("#verContra").off("click").on("click", $login.clickVerPassword);
	$("#usuario").focus();
});