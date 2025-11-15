<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{url('/')}}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{url('/')}}" class="pc-link">
                        <span class="pc-micon"><i class="fa-solid fa-gauge"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('foods') }}" class="pc-link">
                        <span class="pc-micon"><i class="fa-solid fa-utensils"></i></span>
                        <span class="pc-mtext">Foods</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('cart-view') }}" class="pc-link">
                        <span class="pc-micon"><i class="fa-solid fa-cart-plus"></i></span>
                        <span class="pc-mtext">Sale/Cart</span>
                        @if($cartCount > 0)
                            <span class="badge bg-primary">{{ $cartCount ?? 0 }}</span>
                        @endif
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('order-details-list') }}" class="pc-link">
                        <span class="pc-micon"><i class="fa-solid fa-user-astronaut"></i></span>
                        <span class="pc-mtext">Order Details</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('due-list-view') }}" class="pc-link">
                        <span class="pc-micon"><i class="fa-solid fa-comments-dollar"></i></span>
                        <span class="pc-mtext">Due Details</span>
                    </a>
                </li>
                <!-- <li class="pc-item">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="fa-solid fa-bookmark"></i></span>
                        <span class="pc-mtext">Reserved</span>
                    </a>
                </li> -->
                <li class="pc-item">
                    <a href="{{ route('kitchen-view') }}" class="pc-link">
                        <span class="pc-micon"><i class="fa-solid fa-kitchen-set"></i></span>
                        <span class="pc-mtext">Kitchen</span>
                    </a>
                </li>

                

                <li class="pc-item pc-caption">
                    <label>Reports</label>
                    <i class="fa-solid fa-gear"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link"><span class="pc-micon"><i class="fa-solid fa-magnifying-glass"></i></span><span class="pc-mtext">Reports</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#" class="pc-link">Total Sale<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#" class="pc-link">Total Sale<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#" class="pc-link">Total Sale<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#" class="pc-link">Total Sale<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#">Total Sale</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> 

                <li class="pc-item pc-caption">
                    <label>Account</label>
                    <i class="fa-solid fa-gear"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link"><span class="pc-micon"><i class="fa-solid fa-comments-dollar"></i></span><span class="pc-mtext">Accounts</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('daily-expenses') }}"><i class="fa-solid fa-sack-dollar"></i> Daily Expenses</a></li>
                        <li class="pc-item"><a class="pc-link" href="#"><i class="fa-solid fa-filter-circle-dollar"></i> Setting</a></li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#" class="pc-link"><i class="fa-solid fa-money-check-dollar"></i> Account Report<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#"><i class="fa-solid fa-money-bill-1-wave"></i> Total Expenses</a></li>
                                <li class="pc-item"><a class="pc-link" href="#"><i class="fa-solid fa-money-bill-trend-up"></i> Date Expenses</a></li>
                                <li class="pc-item"><a class="pc-link" href="#"><i class="fa-solid fa-yen-sign"></i> Category</a></li>
                                <li class="pc-item"><a class="pc-link" href="#"><i class="fa-solid fa-wallet"></i> Sub-Category</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                
                <li class="pc-item pc-caption">
                    <label>Settings</label>
                    <i class="fa-solid fa-gear"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link"><span class="pc-micon"><i class="fa-solid fa-gear"></i></span><span class="pc-mtext">Settings</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('create-foods') }}"><i class="fa-solid fa-pizza-slice"></i> Foods</a></li>
                        <li class="pc-item"><a class="pc-link" href="#"><i class="fa-solid fa-table"></i> Table</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ url('/stock') }}"><i class="fa-solid fa-chart-gantt"></i> Stock</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('all-user') }}"><i class="fa-solid fa-circle-user"></i> Empolyee</a></li>                        
                    </ul>
                </li>
                <li class="pc-item pc-caption">
                    <label>Authentication</label>
                    <i class="ti ti-news"></i>
                </li>
                <li class="pc-item"><a class="pc-link" href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>