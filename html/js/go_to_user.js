/**
 * script: go_to_user
 *
 * method to go to a particular user
 * created Sep 13, 2016
 *
 * @author Naman Attri<naman@it7solutions.com>
 */
var goToUserAccountByEmailFormValidator = null;

$(function() {
    $.validator.setDefaults({
        /*onkeyup:function() {
            return false;
        }*/
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
	if(response==true) {$('#goBtnInGoToUser').click();}
            }
        });
        return found;
    }, function(params, element) {
        return 'There is no user registered with the email address '+$(element).val()+'.'
    });

    goToUserAccountByEmailFormValidator = $('#goToUserFrm').validate({
        rules:{
            'go_to_email':{
                required:true,
                email:true
                //'email-exists':true
            }
        },
        messages:{
            'go_to_email':{
                required:"Please supply email.",
                email:"Enter a valid email."
            }
        }
    });

    $('body').off('hidden.bs.modal', '#goToUserAccountByEmail').on('hidden.bs.modal', '#goToUserAccountByEmail', function(event) {
        $('#go-to-email').val("");
        goToUserAccountByEmailFormValidator.resetForm();
    });
});
