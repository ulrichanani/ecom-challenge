
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./app-vue');


/**
 * PLUGINS
 */
// require('./plugins-setup/datatables');
// require('./plugins-setup/select2');

$(document).ready(function() {

   /* $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });*/

    /*
     * DELETE FORM SUBMIT
     */
    $('.btn-delete').click(function (e) {
        e.preventDefault();
        if (confirm('Are you sure ?')) {
            let frm = $(e.currentTarget).attr('form') || 'form-delete'
            let url = $(e.currentTarget).attr('href') || $(e.currentTarget).attr('data-delete-url')
            $('#' + frm).attr('action', url).submit()
        }
    });

    $('[data-submit-form]').click(function (e) {
        e.preventDefault();

        if (confirm('Are you sure ?')) {
            let frm = $(e.currentTarget).attr('data-submit-form')
            let url = $(e.currentTarget).attr('[data-submit-url]') || $(e.currentTarget).attr('href')

            if(!frm || !url) return

            $('#' + frm).attr('action', url).submit()
        }
    });
});
