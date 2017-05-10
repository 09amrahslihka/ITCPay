<nav class="navbar fixed">
    <div class="heade-container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::to('/')}}"><img src="{{URL::asset(getLogo())}}" /></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li  class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{URL::to('/')}}"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                <li class="{{ Request::is('/pages/mass_payment_service') ? 'active' : '' }}"><a href="{{URL::to('/pages/mass_payment_service')}}"><i class="fa fa-user-plus" aria-hidden="true"></i>Mass Payment Service</a></li>
                <li class="{{ Request::is('/pages/individual_payment_service') ? 'active' : '' }}"><a href="{{URL::to('/pages/individual_payment_service')}}"><i class="fa fa-user-plus" aria-hidden="true"></i>Individual Payment Service</a></li>
                <li class="{{ Request::is('/pages/services') ? 'active' : '' }}"><a href="{{URL::to('/pages/merchant-services')}}"><i class="fa fa-user-plus" aria-hidden="true"></i>Merchant Services</a></li>
                <li class="{{ Request::is('login') ? 'active' : '' }}"><a href="{{URL::to('/login')}}"><i class="fa fa-sign-in" aria-hidden="true"></i>Log in</a></li>
                <li class="{{ Request::is('register') ? 'active' : '' }}"><a href="{{URL::to('/register')}}"><i class="fa fa-user-plus" aria-hidden="true"></i>Sign up</a></li>
            </ul>
        </div>
    </div>
</nav>