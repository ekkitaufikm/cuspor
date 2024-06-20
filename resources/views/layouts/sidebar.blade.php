<section class="sidebar position-relative"> 
    <div class="multinav">
      <div class="multinav-scroll" style="height: 100%;">   
          <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Dashboard & Apps</li>
                @if(Helpers::hasPrivilege('dashboardr'))
                    <li>
                        <a class="{{ request()->routeIs('dashboard') ? 'c-active' : '' }}" href="{{ route('dashboard') }}"><i class="fa fa-home"><span class="path1"></span><span class="path2"></span></i>Dashboard</a>
                    </li> 
                @endif
                <li><a href="#"><i class="fa fa-line-chart"><span class="path1"></span><span class="path2"></span></i>Company News</a></li>

                <li class="header">Menu </li>
                <li><a href="#"><i class="fa fa-history"><span class="path1"></span><span class="path2"></span></i>Product Order History</a></li>
                <li><a href="#"><i class="fa fa-truck"><span class="path1"></span><span class="path2"></span></i>Tracking Product</a></li>
                <li><a href="#"><i class="fa fa-paperclip"><span class="path1"></span><span class="path2"></span></i>E-Certificate Product</a></li>
                <li><a href="#"><i class="fa fa-handshake-o"><span class="path1"></span><span class="path2"></span></i>Customer Satisfaction</a></li>
                <li><a href="#"><i class="fa fa-tags"><span class="path1"></span><span class="path2"></span></i>Customer Complaint</a></li>    
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cog"><span class="path1"></span><span class="path2"></span></i>
                        <span>Settings</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">            
                        <li><a href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Company</a></li>    
                        <li><a href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Users</a></li>
                        <li><a href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>User Group</a></li>
                    </ul>
                </li>            
            </ul>
        </div>
    </div>
</section>