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

// $(document).ajaxStart(function () {
//     loading(true);
// });
//
// $(document).ajaxComplete(function () {
//     loading(false);
// });
