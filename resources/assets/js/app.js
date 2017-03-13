/*

 /!**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 *!/

 require('./bootstrap');

 /!**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 *!/

 Vue.component('example', require('./components/Example.vue'));

 const app = new Vue({
 el: '#app'
 });
 */

$.fn.editable.defaults.mode = 'inline';
$.fn.editable.defaults.ajaxOptions = {type: 'PUT'};

$(document).ready(function () {
    $('.set-guide-number').editable();
    $('.select-status').editable({
        source: [
            {value: 'creado', text: 'Creado'},
            {value: 'enviado', text: 'Enviado'},
            {value: 'recibido', text: 'Recibido'}
        ]
    });
});

$('.add-to-cart').on('submit', function (e) {
    e.preventDefault();

    var $form = $(this);
    var $button = $form.find('[type=submit]');

    // Petición AJAX
    $.ajax({
        url: $form.attr('action'),
        method: $form.attr('method'),
        data: $form.serialize(),
        dataType: 'JSON',
        beforeSend: function () {
            $button.val('Cargando...');
        },
        success: function (data) {
            $button.css('background-color', '#00c583').val('Agregado');
            $('.circle-shopping-cart').html(data.products_count).addClass('highlight');
            setTimeout(function () {
                restartButton($button);
            }, 2000);
        },
        error: function () {
            $button.css('background-color', '#d50000').val('Ocurrio un error');
            setTimeout(function () {
                restartButton($button);
            }, 2000);
        }
    });

    function restartButton($button) {
        $button.val('Agregar al carrito').attr('style', '');
        $('.circle-shopping-cart').removeClass('highlight');
    }

});
