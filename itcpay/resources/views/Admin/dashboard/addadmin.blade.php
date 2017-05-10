@extends('Admin.layouts.master')

@section('content')
<div class="col-md-12" style="height:100">
    @if(Session::has('message'))
    <div class="alert alert-success" role="alert">
       {{Session::get('message')}}
    
    </div>

    
    @endif
    	<div class="row" style="height:100%;">
            <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Admin</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{URL::to('admin/addadmin')}}" > 
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>

                  <div class="col-sm-10">
                    <input type="text" name="fname" class="form-control" id="inputEmail3" placeholder="First Name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">
                    <input type="text" name="lname" class="form-control" id="inputPassword3" placeholder="Last Name">
                  </div>
                </div>
                  
                   <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputPassword3" placeholder="Email">
                  </div>
                </div>
                   <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                  </div>
                </div>
               
              <!-- /.box-body -->
              <div class="box-footer">
               <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <button type="submit" class="btn btn-info pull-right">Add</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
</div>


        </div>

    

</div>
@stop