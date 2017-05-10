/**
 * Created by Naman Attri on 8/26/2016.
 */
var sendPaymentFormValidator = null;

$(function() {
    $.validator.setDefaults({
        onkeyup:function() {
            return false;
        }
    });

    $.validator.addMethod('not-own-email', function(val, element) {
        return $(element).val().trim() != $(element).data('own-email');
    });

    $.validator.addMethod('email-exists', function (val, element) {
        var found = false;
        $.ajax({
            async:false,
            data:{email:val.trim()},
            dataType:'json',
            type:'get',
            url:emailExistsCheckLnk,
            success:function(response) {
                found = response
            }
        });
        return found;
    }, function(params, element) {
        return 'There is no user registered with the email address '+$(element).val()+'.'
    });

    $.validator.addMethod('enough-available', function(val, element) {
        return $(element).data('total-cost') <= $('#availableBalanceTxt').data('available-balance');
    });

    sendPaymentFormValidator = $('#sendPaymentForm').validate({
        rules:{
            'sendAmountTxt':{
                required:true,
                number:true,
                min:5
            },
            'emailTxt':{
                required:true,
                email:true,
                'not-own-email':true,
                'email-exists':true
            },
            'paymentTypeSlct':{
                required:true
            },
            'totalCostTxt':{
                'enough-available':true
            }
        },
        messages:{
            'sendAmountTxt':{
                required:'Please enter amount to send.',
                number:'Only numeric value allowed (e.g. 5.00).',
                min:'Minimum amount to send is $5.00.'
            },
            'emailTxt':{
                required:"Please supply email.",
                email:"Enter a valid email.",
                'not-own-email':"You can't send money to your own email address"
            },
            'paymentTypeSlct':{
                required:"Select a payment type."
            },
            'totalCostTxt': {
                'enough-available':'Insufficient available balance.'
            }
        }
    });

    $('body').on('blur', '#sendAmountTxt', function(event) {
        $(this).val(numeral($(this).val().trim()).format('0.00'));
    });
    $('body').on('change', '#paymentTypeSlct, #emailTxt, #sendAmountTxt', function(event) {
        sendPaymentFormValidator.resetElements($('#totalCostTxt'));
        fetchFeeAndTotalAmount();
    }).off('keyup', '#emailTxt').on('keyup', '#emailTxt', function(event) { return false; });
});

/**
 * fetchFeeAndTotalAmount
 *
 * method to fetch fee and total amount
 * created Aug 26, 2016
 *
 * @author NA
 */
function fetchFeeAndTotalAmount() {
    $('#feeTxt, #totalCostTxt').val("");
    $('#totalCostTxt').data('total-cost', 0);
    if(sendPaymentFormValidator.checkForm()) {
        //send an ajax request to fetch fee and net amount
        //populate & show fields
        $.ajax({
            dataType:'json',
            data:{
                sendAmountTxt:roundToPlaces(parseFloat($('#sendAmountTxt').val().trim()), 2),
                emailTxt:$('#emailTxt').val().trim(),
                paymentTypeSlct:$('#paymentTypeSlct').val().trim()
            },
            success:function(response) {
                $('#feeTxt').val("$"+numeral(response.fee).format('0.00'));
                $('#totalCostTxt').val("$"+numeral(response.totalCost).format('0.00'));
                $('#totalCostTxt').data('total-cost', response.totalCost);
                $('.fetched-fields').show();
                $('#sendPaymentForm').valid();
            },
            type:'get',
            url:fetchFeeAndTotalAmountURL
        });
    } else {
        //empty & hide fee & net amount fields
        $('#feeTxt, #totalCostTxt').val("");
        $('.fetched-fields').hide();
    }
}