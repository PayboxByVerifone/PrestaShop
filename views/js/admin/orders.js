/**
* Verifone e-commerce PrestaShop Module
*
* Feel free to contact Verifone e-commerce at support@paybox.com for any
* question.
*
* LICENSE: This source file is subject to the version 3.0 of the Open
* Software License (OSL-3.0) that is available through the world-wide-web
* at the following URI: http://opensource.org/licenses/OSL-3.0. If
* you did not receive a copy of the OSL-3.0 license and are unable
* to obtain it through the web, please send a note to
* support@paybox.com so we can mail you a copy immediately.
*
*  @category  Module / payments_gateways
*  @version   3.0.6
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

$(document).ready(function () {

    if (refundAvailable == 1) {
        payboxCreateCreditSlip();

        $('#generateDiscount').on('click', function () {
            payboxToggleCreditSlip();
        });
        $('#generateCreditSlip').on('click', function () {
            payboxToggleCreditSlip();
        });
    }

    /**
     * Intercept Ajax calls for page reload on product modification or deletion
     */
    $(document).ajaxSuccess(function (event, xhr, settings, data) {
        if (typeof data !== 'undefined' && data !== null) {
            if (typeof data.documents_html !== 'undefined' && data.documents_html !== null) {
                window.location.reload(true);
            }
        }
    });


    if ($('.alert-epayment').length) {
        $('html, body').animate({
            scrollTop: ($('.alert-epayment').offset().top - 150)
        }, 2000);
    }
});

/**
 * Create Checkbox for refund
 */
function payboxCreateCreditSlip()
{
    html =
        '<p class="checkbox" id="payboxRefundSpan" style="display: none;">'+
            '<label for="payboxRefund">'+
                '<input type="checkbox" id="payboxRefund" name="payboxRefund" />'+
                refundCheckboxText +
            '</label>'+
        '</p>';

    $('#spanShippingBack').after(html);

}

/**
 * Handle validation of refund checkbox
 * => only available if generateCreditSlip checked and generateDiscount unchecked
 */
function payboxToggleCreditSlip()
{
    generateDiscount = $('#generateDiscount').attr("checked");
    generateCreditSlip = $('#generateCreditSlip').attr("checked");
    if (generateDiscount != 'checked' && generateCreditSlip == 'checked') {
        $('#payboxRefundSpan').css('display', 'block');
    } else {
        $('#payboxRefundSpan input[type=checkbox]').attr("checked", false);
        // $('#payboxRefundSpan').css('display', 'none');
    }
}
