window.loading = function (op) {
    if (op) {
        $('body').waitMe({
            effect: 'pulse',
            text: 'Cargando...',
            bg: 'rgba(255,255,255,0.6)',
            color: '#007BFF'
        });
    } else {
        $('body').waitMe('hide');
    }
};

$(document).on("click", "#accordionSidebar li a", function () {
    let datat = $(this).attr("id");
    document.cookie = "currentmenu=" + datat + ";path=/";

});

$(document).ready(function () {
    let cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)currentmenu\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    $('#accordionSidebar li').each(function (i) {
        let a = $(this).find('a');
        let datat = a.attr("id");
        let datatId = a.attr("id");
        if (datat === cookieValor) {
            a.addClass("active");
            $('#'+datatId).parent().addClass("active");
        }
    });
});

