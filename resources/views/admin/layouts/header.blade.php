<nav class="app-header navbar navbar-expand bg-body main-header">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link sidebar-toggler-btn" id="sidebarToggler" data-lte-toggle="sidebar" href="#"
                    role="button">
                    <i class="fa-solid fa-arrow-left" id="arrowLeft"></i>
                    <i class="fa-solid fa-arrow-right d-none" id="arrowRight"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link px-1">Home</a>
            </li>
            @if (isset($breadcrumbs))
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ $breadcrumb['url'] }}" class="nav-link px-1">- {{ $breadcrumb['name'] }}</a>
                    </li>
                @endforeach
            @endif
        </ul>

        <ul class="navbar-nav ms-auto">
            {{-- <li class="nav-item dropdown">
                <a class="nav-link pe-2" data-bs-toggle="dropdown" href="#">
                    <i class="fa-regular fa-comment"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/user.jpg') }}" alt="User Avatar"
                                    class="img-size-50 rounded-circle me-3" />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-end fs-7 text-danger"><i class="fa-solid fa-star"></i></span>
                                </h3>
                                <p class="fs-7">Call me whenever you can...</p>
                                <p class="fs-7 text-secondary">
                                    <i class="fa-solid fa-clock me-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link pe-2" data-bs-toggle="dropdown" href="#">
                    <i class="fa-regular fa-bell"></i>
                    <span class="navbar-badge badge text-bg-warning rounded-circle" style="margin-top: 20px;">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fa-solid fa-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span>
                    </a>
                </div>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="fa-solid fa-expand"></i>
                    <i data-lte-icon="minimize" class="fa-solid fa-compress" style="display: none"></i>
                </a>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle user-top-icons" data-bs-toggle="dropdown">
                    <img class="img-fluid users-img" src="{{ asset('images/user.jpg') }}"
                        class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">{{ Auth::guard('admin')->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header">
                        <img src="{{ asset('images/user.jpg') }}" class="rounded-circle shadow users-img"
                            alt="User Image" />
                        <p>
                            {{ Auth::guard('admin')->user()->name }}
                            <small>Member since {{ Auth::guard('admin')->user()->created_at->format('M , Y') }}</small>
                        </p>
                        <p>
                            <small> <a class="user-email"
                                href="mailto:{{ Auth::guard('admin')->user()->email }}">{{ Auth::guard('admin')->user()->email }}</a></small>
                        </p>
                    </li>
                    <li class="user-footer mx-auto">
                        <a href="{{ route('admin.profile.edit') }}" class="btn-common-one btn-sm"><i class="fa-solid fa-user pe-2"></i>
                            Profile</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <a href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                class="btn-common-one float-end"><i class="fa-solid fa-arrow-right-from-bracket pe-2"></i> {{ __('Sign Out') }}
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
