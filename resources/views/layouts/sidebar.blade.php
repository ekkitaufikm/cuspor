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
                <li><a href="{{ route('product-order-history') }}"><i class="fa fa-history"><span class="path1"></span><span class="path2"></span></i>Product Order History</a></li>
                <li><a href="#"><i class="fa fa-truck"><span class="path1"></span><span class="path2"></span></i>Tracking Product</a></li>
                <li><a href="#"><i class="fa fa-paperclip"><span class="path1"></span><span class="path2"></span></i>E-Certificate Product</a></li>
                @if(Helpers::hasPrivilege('satisfactionr'))
                    <li>
                        <a class="{{ request()->routeIs('customer-satisfaction') ? 'c-active' : '' }}" href="{{ route('customer-satisfaction') }}"><i class="fa fa-handshake-o"><span class="path1"></span><span class="path2"></span></i>Customer Satisfaction</a>
                    </li> 
                @endif
                @if(Helpers::hasPrivilege('complaintr'))
                    <li>
                        <a class="{{ request()->routeIs('customer-complaint') ? 'c-active' : '' }}" href="{{ route('customer-complaint') }}"><i class="fa fa-tags"><span class="path1"></span><span class="path2"></span></i>Customer Complaint</a>
                    </li> 
                @endif  
                @if(Helpers::hasPrivilege('companyr'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cog"><span class="path1"></span><span class="path2"></span></i>
                            <span>Settings</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">       
                            {{-- @if(Helpers::hasPrivilege('companyr'))     
                                <li>
                                    <a class="{{ request()->routeIs('company') ? 'c-active' : '' }}" href="{{ route('company') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Company</a>
                                </li>  
                            @endif            --}}
                            @if(Helpers::hasPrivilege('userr'))     
                                <li>
                                    <a class="{{ request()->routeIs('users') ? 'c-active' : '' }}" href="{{ route('users') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Users</a>
                                </li>  
                            @endif      
                            @if(Helpers::hasPrivilege('roler'))     
                                <li>
                                    <a class="{{ request()->routeIs('user-group') ? 'c-active' : '' }}" href="{{ route('user-group') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>User Group</a>
                                </li>  
                            @endif
                        </ul>
                    </li>
                @endif              
            </ul>
        </div>
    </div>
</section>