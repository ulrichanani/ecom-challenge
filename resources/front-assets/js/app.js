$(document).ready(function () {

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


    function onShippingTypeChange(regionId) {
        $('#shipping_id option[data-region-id]').css('display', 'none')
        $(`#shipping_id option[data-region-id=${regionId}]`).css('display', 'inline')
        $('#shipping_id').val('')
    }

    function parseToFloat(nb) {
        let amount = Number.parseFloat(nb)
        if (Number.isNaN(amount)) {
            amount = 0;
        }
        return amount
    }

    onShippingTypeChange($('#shipping_region_id').val())

    let subTotal = parseToFloat($('#cartSubtotal').text())

    $('#shipping_region_id').change(e => {
        let val = e.currentTarget.value
        onShippingTypeChange(val)
    })

    $('#shipping_id').change(e => {
        let region_id = $('#shipping_id').val()
        let shippingAmount = $(e.currentTarget).children(`option[value="${region_id}"]`).attr('data-cost')
        shippingAmount = parseToFloat(shippingAmount)

        if(shippingAmount < 0.0001) {
            $('#shippingAmount').text('Free')
            $('#cartTotal').text(subTotal)
        } else {
            $('#shippingAmount').text(shippingAmount)
            let total = shippingAmount + subTotal
            $('#cartTotal').text(total.toFixed(2))
        }
    })
})
