/**
 * script: admin_users_manage
 * created Sep 13, 2016
 * @author Naman Attri<naman@it7solutions.com>
 */
$(function() {
    var addFundsFormInstance = $('#addFundsFrm').parsley();
    var modifyInformationInstance = $('#modifyInformationFrm').parsley();
		
    $('body').on('click', '#verifyUserEmailBtn', function(event) {
        $.ajax({
            data:{
                email:$('#emailTxt').val(),
                _token:$('[name="verifyEmailToken"]').val()
            },
            dataType:'json',
            success:function(response) {
                if(!response.error) {
                    $('.hide-able').hide();
                    if(!response.verified){ $('#verifyAccountDiv').show(); }
                    $('.active-show').show();
                    $.notify("User email verified!", "success");
                }
            },
            error:function() {
                $.notify("Something went wrong!", "error");
            },
            type:'post',
            url:verifyUserEmailUrl
        });
    }).on('click', '#verifyUserAccountBtn', function(event) {
        $.ajax({
            data:{
                email:$('#emailTxt').val(),
                _token:$('[name="verifyAccountToken"]').val()
            },
            dataType:'json',
            success:function(response) {
                if(!response.error) {
                    $('.hide-able').hide();
                    $('.active-show').show();
                    $.notify("User account verified!", "success");
                }
            },
            error:function() {
                $.notify("Something went wrong!", "error");
            },
            type:'post',
            url:verifyUserAccountUrl
        })
    }).on('click', '#unverifyUserAccountBtn', function(event) {
 if (confirm('Are you sure you want to unverified account for this User ?')) {
        $.ajax({
            data:{
                email:$('#emailTxt').val(),
                _token:$('[name="verifyAccountToken"]').val()
            },
            dataType:'json',
            success:function(response) {
                if(!response.error) {
                    $('.hide-able').hide();
                    $('.active-show').show();
                    $.notify("User account unverified!", "success");
                }
            },
            error:function() {
                $.notify("Something went wrong!", "error");
            },
            type:'post',
            url:unverifyUserAccountUrl
        })
}
    }).on('click', '#regenerateAuthPasswordBtn', function(event) {
        if(confirm('Are you sure you want to generate a new authorization password for this user?')) {
            $.ajax({
                data: {
                    email: $('#emailTxt').val()
                },
                dataType: 'json',
                error: function () {
                    $.notify("Something went wrong!", "error");
                },
                success: function (response) {
                    if (!response.error) {
                        $('#authorizationPasswordTxt').val(response.authorizationPassword);
                        $.notify("New authorization password generated for user!", "success");
                    }
                },
                type:'get',
                url:generateAuthPasswordUrl
            });
        }
    }).on('click', '#addFundsBtn', function(event) {
        if(addFundsFormInstance.isValid()) {
            $.ajax({
                data:{
                    email:$('#emailTxt').val(),
                    amountTxt:$('#amountTxt').val(),
                    _token:$('#addFundsModal').find('[name="_token"]').val()
                },
                dataType:'json',
                error:function() {
                    $.notify("Something went wrong!", "error");
                },
                success:function(response) {
                    if(!response.error) {
                        addFundsFormInstance.reset();
                        $('#amountTxt').val("");
                        $('#addFundsCancelBtn').trigger('click');
                        $.notify(response.message, "success");
                    }
                },
                type:'post',
                url:addFundsUrl
            });
        }
    }).on('click', '#modifyInformationSubmitBtn', function(event) {
        if (modifyInformationInstance.isValid())
        {
            $.ajax({
                data:     {
						//TODO: add all fields
                    oldEmail:    $('#emailTxt').val(),
                    email:    	 $('#newEmailTxt').val(),
                    firstName:   $('#firstNameTxt').val(),
                    middleName:  $('#middleNameTxt').val(),
                    lastName:    $('#lastNameTxt').val(),
                    addressOne:  $('#addressOneTxt').val(),
                    addressTwo:  $('#addressTwoTxt').val(),
                    country:     $('#countrySelect').val(),
                    city:        $('#cityTxt').val(),
                    state:       $('#stateTxt').val(),
                    postal:      $('#postalTxt').val(),
                    day:         $('#daySelect').val(),
                    month:       $('#monthSelect').val(),
                    year:        $('#yearSelect').val(),
                    nationality: $('#nationalitySelect').val(),

                    businessName:        $('#businessNameTxt').val(),
                    businessAddressOne:  $('#businessAddressOneTxt').val(),
                    businessAddressTwo:  $('#businessAddressTwoTxt').val(),
                    businessCountry:     $('#businessCountrySelect').val(),
                    businessCity:        $('#businessCityTxt').val(),
                    businessState:       $('#businessStateTxt').val(),
                    businessPostal:      $('#businessPostalTxt').val(),

                    _token:      $('#modifyInformationModal').find('[name="_token"]').val()
                },
                dataType: 'json',
				success:  function(response)
                {
                    if (!response.error)
                    {
                        $('#modifyInformationCancelBtn').trigger('click');
						if($('#emailTxt').val() != $('#newEmailTxt').val()){
							$.notify("Email will be updated after user's verification.","success");
						}
						else{
							$.notify(response.message, "success");
						}
                         setTimeout(function() { window.location.reload() }, 2000);
                    }
					else{
                        $.notify(response.message, "error");
                    }
                },
                error:    function(e)
                {
                    $.notify("Something went wrong!", "error");
                },
             
                type:     'post',
                url:      modifyInformationUrl
            });
        }
    }).off('hidden.bs.modal', '#addFundsModal').on('hidden.bs.modal', '#addFundsModal', function(event) {
        addFundsFormInstance.reset();
        $('#amountTxt').val("");
    }).off('click', '#deleteAccountDiv').on('click', '#deleteAccountDiv', function(event) {
          $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete this user account?',
                confirmButton: 'Remove',
                cancelButton: 'Cancel',
                confirm: function () { 
                      var userIDs = [];
            $('.users-checked:checked').each(function (index, element) {
                userIDs.push($(element).val());
            });
            $.ajax({
                type: 'post',
                dataType: 'json',
                data: {
                    userIDs: [$('#deleteAccountDiv').data('user-id')],
                    _token:_token
                },
                url: deleteUserAccountURL,
                success: function (response) {
                    window.location = deleteDashRedirectUrl + "/?count=1";
                }
            });
                },
                cancel: function () {
                }
            });
    });
});
