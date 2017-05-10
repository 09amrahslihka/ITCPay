<section class="sidebar">

    <!-- Sidebar user panel (optional) -->


    <!-- search form (Optional) -->

    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">MY ACCOUNT</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{ Request::is('/admin') ? 'active' : '' }}"><a href="{{URL::to('/admin')}}"><i
                        class="fa fa-user"></i> <span>Users</span></a></li>
        <li class="{{ Request::is('admin/addadmin') ? 'active' : '' }}"><a href="{{URL::to('/admin/addadmin')}}"><i
                        class="fa fa-user"></i> <span>Add Admin</span></a></li>

    </ul>


    <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
 