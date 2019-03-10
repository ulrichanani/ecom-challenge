

require('../../js/bootstrap');
require('../../js/app-vue');
require('../../js/utilities/global-functions')

require('./main');

$(document).ready(function () {

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

        let needConfirm = $(e.currentTarget).attr('data-submit-noconfirm') === undefined;
        if (needConfirm && !confirm('Are you sure ?'))
            return

        let frm = $(e.currentTarget).attr('data-submit-form')
        let url = $(e.currentTarget).attr('[data-submit-url]') || $(e.currentTarget).attr('href')

        if (!frm || !url) return

        $('#' + frm).attr('action', url).submit()

    });
});
