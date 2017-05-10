<style>
    .parsley-errors-list>li {
        color:red;
        list-style-type: none;
    }
    .parsley-errors-list {
        padding:0;
    }

</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <!-- <h4 class="modal-title" id="myModalLabel">Authorization</h4> -->
    <h4 class="modal-title" id="myModalLabel">Contact</h4>
</div>
<div class="modal-body clearfix">
    <form id="authorizationPasswordFrm" class="form-horizontal" action="{{URL::to('dashboard/change/email')}}" onsubmit="" method="post">
        <div class="col-sm-12">
            <div class="row">
                <div class="form-group">
                    <!-- <label for="authorizationPasswordPwd"  class="col-sm-4 control-label">Enter Your Password <em style='color:red;'>*</em></label> -->
                    <!-- <div class="col-sm-8">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <input type="password" data-parsley-required="true" data-parsley-required-message="Password is required" name="authorizationPasswordPwd" class="form-control" id="authorizationPasswordPwd" placeholder="Enter Your Password">
                    </div> -->
                    <label for="authorizationPasswordPwd"  class="col-sm-10 control-label">Contact our <a href="/pages/Support"> customer support </a>to change your email address.</label>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelBtn">Cancel</button>
    <!-- <button type="button" class="btn btn-success" id="submitBtn">Continue</button> -->
</div>
<script>
    $(function () {
        $('#authorizationPasswordFrm').on('submit', function(event) {
            event.preventDefault();
        });

        var instance = $('#authorizationPasswordFrm').parsley();

        $('body').off().on('click', '#submitBtn', function(event) {
            instance.validate();
            if(instance.isValid()) {
                var postData = {};
                $.ajax({
                    data:{
                        authorizationPassword:$('#authorizationPasswordPwd').val(),
                        _token:$('[name="_token"]').val()
                    },
                    dataType:'json',
                    type:'post',
                    success:function(response) {
                         if(!response.error) {
                            $('#authorizationPasswordFrm').unbind("submit");
                            $('#authorizationPasswordFrm').submit();
                        } else {
                            $('#cancelBtn').trigger('click');
                        }
                    },
                    error:function() {
                        $.notify("Security Threat - Tampered Request Payload!", "error");
                    },
                    url:"{{ URL::to('/auth/verify/authorizationPassword') }}"
                });
            }
        });
    });
</script>