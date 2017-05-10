/**
 * Created by Naman Attri on 8/26/2016.
 */
var withdrawMoneyFormValidator = null;

$(function() {
    //$.validator.setDefaults({
    //    onkeyup:function() {
    //        return false;
    //    }
    //});

    function getMinimumWithdrawAmountForBank()
    {
        return typeof minimumWithdrawAmounts[$('#accountSlct option:selected').data('account-country')] != undefined &&
            minimumWithdrawAmounts[$('#accountSlct option:selected').data('account-country')] != null ?
                minimumWithdrawAmounts[$('#accountSlct option:selected').data('account-country')] :
                minimumWithdrawAmounts['others'];
    }

    function getFee()
    {
        var fee = 0;
        var paymentType = $('#withdrawToSlct').val();
        if (isCardWithdrawAvailable && paymentType == 'card')
            fee = cardWithdrawalFee;
        else
            fee = typeof bankWithdrawFee[$('#accountSlct option:selected').data('account-country')] != undefined &&
                bankWithdrawFee[$('#accountSlct option:selected').data('account-country')] != null ?
                    bankWithdrawFee[$('#accountSlct option:selected').data('account-country')] :
                    bankWithdrawFee['others'];

        return fee;
    }

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
        if(withdrawMoneyFormValidator.checkForm()) {
            //send an ajax request to fetch fee and net amount
            //populate & show fields
            var fee = parseFloat(getFee());
            var gross = parseFloat(roundToPlaces(parseFloat($('#withdrawAmountTxt').val().trim()), 2));
            var total = gross + fee;
            $('#feeTxt').val("$"+numeral(fee).format('0.00'));
            $('#totalCostTxt').val("$"+numeral(total).format('0.00'));
            $('#totalCostTxt').data('total-cost', total);
            $('.fetched-fields').show();
            $('#withdrawform').valid();
        } else {
            //empty & hide fee & net amount fields
            $('.fetched-fields').hide();
            $('#feeTxt, #totalCostTxt').val("");
        }
    }

    $.validator.addMethod('minimum-withdraw-amount', function(val, element) {
        var paymentType = $('#withdrawToSlct').val();
        if (isCardWithdrawAvailable && paymentType == 'card')
            return val >= parseFloat(minimumWithdrawAmountCard);
        else
            return val >= parseFloat(getMinimumWithdrawAmountForBank());
    }, function(params, element) {
        var paymentType = $('#withdrawToSlct').val();
        if (isCardWithdrawAvailable && paymentType == 'card')
            return 'Minimum withdrawal amount is $' + minimumWithdrawAmountCard + '.';
        else
            return 'Minimum withdrawal amount is $' + getMinimumWithdrawAmountForBank() + '.';

    });

    $.validator.addMethod('enough-available', function(val, element) {
        return $(element).data('total-cost') <= $('#availableBalanceTxt').data('available-balance');
    });

    $.validator.addMethod('positive-value', function(val, element) {
        return val >= 0;
    });

    withdrawMoneyFormValidator = $('#withdrawform').validate({
        rules:{
            'withdrawAmountTxt':{
                required:true,
                number:true,
                'positive-value':true,
                'minimum-withdraw-amount':true
            },
            'accountSlct':{
                required: function(element) {
                    var paymentType = $('#withdrawToSlct').val();
                    if (isCardWithdrawAvailable && paymentType == 'card')
                        return false;
                    else
                        return true;
                }
            },
            'cardSlct':{
                required: function(element) {
                    var paymentType = $('#withdrawToSlct').val();
                    if (isCardWithdrawAvailable && paymentType == 'card')
                        return true;
                    else
                        return false;
                }
            },
            'withdrawToSlct':{
                required: function(element) {
                    if (isCardWithdrawAvailable)
                        return true;
                    else
                        return false;
                }
            },
            'totalCostTxt':{
                'enough-available':true
            }
        },
        messages:{
            'withdrawAmountTxt':{
                required:'Please enter amount to send.',
                number:'Only numeric value allowed (e.g. 5.00).',
                'positive-value':'Invalid amount'
            },
            'accountSlct':{
                required:"This value is required. Please add a bank account to withdraw money."
            },
            'cardSlct':{
                required:"This value is required. Please add a card to withdraw money."
            },
            'withdrawToSlct':{
                required:"This value is required."
            },
            'totalCostTxt': {
                'enough-available':'Insufficient available balance.'
            }
        }
    });

    $('body').on('blur', '#withdrawAmountTxt', function(event) {
        $(this).val(numeral($(this).val().trim()).format('0.00'));
    }).on('change keyup', '#withdrawAmountTxt, #withdrawToSlct, #accountSlct, #cardSlct', function(event) {
        withdrawMoneyFormValidator.resetElements($('#totalCostTxt'));
        fetchFeeAndTotalAmount();
    });
});
