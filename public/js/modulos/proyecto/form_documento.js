var $formDoc = (modulo => {

    modulo.ini = () => {
        var tempo = 0, itera = 0;

        tempo = setInterval(() => {
            if (itera>99) {
                clearInterval(tempo);
            }
            if ($('.jq_select').length==0) {
                itera++; return;
            }
            $('.jq_select').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            clearInterval(tempo);
        }, 500); 
    };
    
    return modulo;
})($formDoc || {});

$(function() {

    $formDoc.ini();
});