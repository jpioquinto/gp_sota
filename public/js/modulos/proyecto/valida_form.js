var $objValida = (modulo => {
    modulo.params = {};

    modulo.validar = () => {
        var valido = true;
        var me = undefined;

        $('.content-form form input, .content-form form textarea').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }

            $(this).parents('.form-group').removeClass('has-error');

            me = $(this);

            if ($.trim($(this).val())=='' && $(this).attr('required')) {
                modulo.params = {}; $(this).parents('.form-group').addClass('has-error');
                notificacion('El campo ' + $(this).parents('.form-group').find('label').text() + ' es requerido', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");                 
                return valido = false;
            }
            
            if ($.trim($(this).val())!='') {
                modulo.params[$(this).attr('name')] = $(this).attr('type')=='radio' 
                                                    ? $("input[name='" + $(this).attr('name') +"']:checked").val()
                                                    : $.trim($(this).val());
            }
        });

        $('.content-form form select').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }

            $(this).parents('.form-group').removeClass('has-error');

            me = !me ? $(this) : me;

            if ($(this).find('option:selected').val()=='' && $(this).attr('required')) {
                modulo.params = {}; $(this).parents('.form-group').addClass('has-error');
                notificacion('El campo ' + $(this).parents('.form-group').find('label').text() + ' es requerido', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");                 
                return valido = false;
            }
            
            if ($(this).find('option:selected').val()!='') {
                modulo.params[$(this).attr('name')] = $(this).find('option:selected').val();
            }
        });
        
        if (me) {
            setTimeout(() => {me.focus();}, 1000);
        }

        return valido && Object.keys(modulo.params).length>0;
    };


    return modulo;
})($objValida || {});
