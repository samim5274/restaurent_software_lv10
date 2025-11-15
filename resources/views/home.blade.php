<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a
                        class="pc-head-link dropdown-toggle arrow-none m-0"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-haspopup="false"
                        aria-expanded="false">
                    <i class="ti ti-search"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="form-group mb-0 d-flex align-items-center">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="header-search">
                        <i data-feather="search" class="icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search here. . .">
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-mail"></i>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Message</h5>
                            <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-x text-danger"></i></a>
                        </div>
                        <div class="dropdown-divider"></div>
                            <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
                                <div class="list-group list-group-flush w-100">
                                    <a class="list-group-item list-group-item-action">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                        <img src="{{ asset('img/employee/' . Auth::guard('admin')->user()->photo) }}" alt="user-image" class="user-avtar">
                                        </div>
                                        <div class="flex-grow-1 ms-1">
                                        <span class="float-end text-muted">3:00 AM</span>
                                        <p class="text-body mb-1">It's <b>Cristina danny's</b> birthday today.</p>
                                        <span class="text-muted">2 min ago</span>
                                        </div>
                                    </div>
                                    </a>
                                    <a class="list-group-item list-group-item-action">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                        <img src="../assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar">
                                        </div>
                                        <div class="flex-grow-1 ms-1">
                                        <span class="float-end text-muted">6:00 PM</span>
                                        <p class="text-body mb-1"><b>Aida Burg</b> commented your post.</p>
                                        <span class="text-muted">5 August</span>
                                        </div>
                                    </div>
                                    </a>
                                    <a class="list-group-item list-group-item-action">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                        <img src="../assets/images/user/avatar-3.jpg" alt="user-image" class="user-avtar">
                                        </div>
                                        <div class="flex-grow-1 ms-1">
                                        <span class="float-end text-muted">2:45 PM</span>
                                        <p class="text-body mb-1"><b>There was a failure to your setup.</b></p>
                                        <span class="text-muted">7 hours ago</span>
                                        </div>
                                    </div>
                                    </a>
                                    <a class="list-group-item list-group-item-action">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                        <img src="../assets/images/user/avatar-4.jpg" alt="user-image" class="user-avtar">
                                        </div>
                                        <div class="flex-grow-1 ms-1">
                                        <span class="float-end text-muted">9:10 PM</span>
                                        <p class="text-body mb-1"><b>Cristina Danny </b> invited to join <b> Meeting.</b></p>
                                        <span class="text-muted">Daily scrum meeting time</span>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        <div class="dropdown-divider"></div>
                        <div class="text-center py-2">
                        <a href="#!" class="link-primary">View all</a>
                        </div>
                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                <a
                    class="pc-head-link dropdown-toggle arrow-none me-0"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-haspopup="false"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                >
                    <img src="{{ asset('img/employee/' . Auth::guard('admin')->user()->photo) }}" alt="user-image" class="user-avtar">
                    <span>{{ Auth::guard('admin')->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                    <div class="dropdown-header">
                        <div class="d-flex mb-1">
                            <div class="flex-shrink-0">
                            <img src="{{ asset('img/employee/' . Auth::guard('admin')->user()->photo) }}" alt="user-image" class="user-avtar wid-35">
                            </div>
                            <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ Auth::guard('admin')->user()->name }}</h6>
                            @php
                                $roleName = match(Auth::guard('admin')->user()?->role) {
                                    1 => 'Admin',
                                    2 => 'Manager',
                                    3 => 'Chef',
                                    4 => 'Waiter',
                                    default => 'Unknown',
                                };
                            @endphp
                            <span>{{ $roleName }}</span>
                            </div>
                            <a href="{{route('logout')}}" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a>
                        </div>
                    </div>
                    <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="drp-t1" data-bs-toggle="tab" data-bs-target="#drp-tab-1" type="button" role="tab" aria-controls="drp-tab-1" aria-selected="true" ><i class="ti ti-user"></i> Profile</button >
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2" type="button" role="tab" aria-controls="drp-tab-2"
                            aria-selected="false"><i class="ti ti-settings"></i> Setting</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="mysrpTabContent">
                        <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">                        
                            <a href="{{ route('user-profile-view') }}" class="dropdown-item"><i class="ti ti-user"></i><span>View Profile</span></a>
                            <a href="#!" class="dropdown-item"><i class="ti ti-wallet"></i><span>Billing</span></a>
                            <a href="{{route('logout')}}" class="dropdown-item"><i class="ti ti-power"></i><span>Logout</span></a>
                        </div>
                        <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
                            <a href="#!" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="ti ti-help"></i><span>Support</span></a>
                            <a href="{{ route('all-user') }}" class="dropdown-item"><i class="ti ti-user"></i><span>Permission</span></a>
                            <a href="#!" class="dropdown-item"><i class="ti ti-list"></i><span>History</span></a>
                        </div>
                    </div>
                </div>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- Support Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Contact Support</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body py-5">
                <div class="text-center mb-5">
                    <h2>Need Help? Contact Us with Developer only</h2>
                    <p class="text-muted">We’re here to assist you 24/7 via your preferred communication channel.</p>
                </div>

                <div class="row g-4 justify-content-center px-3">

                    <!-- Phone -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-telephone-fill fs-2 text-primary"></i>
                            </div>
                            <h5>Call Us</h5>
                            <p class="text-muted">Available 9am - 10pm</p>
                            <a href="tel:+8801762164746" class="btn btn-outline-primary btn-sm">+880 1762-164746</a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-whatsapp fs-2 text-success"></i>
                            </div>
                            <h5>WhatsApp</h5>
                            <p class="text-muted">Chat with our agent</p>
                            <a href="https://wa.me/+8801762164746" target="_blank" class="btn btn-outline-success btn-sm">Start Chat</a>
                        </div>
                    </div>

                    <!-- Telegram -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-telegram fs-2 text-info"></i>
                            </div>
                            <h5>Telegram</h5>
                            <p class="text-muted">Send us a message</p>
                            <a href="https://t.me/SAMIMHosseN5274" target="_blank" class="btn btn-outline-info btn-sm">SAMIM-HosseN</a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-envelope-fill fs-2 text-danger"></i>
                            </div>
                            <h5>Email</h5>
                            <p class="text-muted">Get support via email</p>
                            <a href="mailto:cse.shamim.cub@gmail.com" class="btn btn-outline-danger btn-sm">cse.shamim.cub@gmail.com</a>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>