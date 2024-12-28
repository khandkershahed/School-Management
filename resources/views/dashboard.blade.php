<x-frontend-app-layout :title="'User Dashboard'">
    {{-- <div class="breadcrumb-wrap">
        <div class="banner b-top bg-size bread-img">
            <img class="bg-img bg-top" src="img/banner-p.jpg" alt="banner" style="display: none;">
            <div class="container-lg">
                <div class="breadcrumb-box">
                    <div class="title-box3 text-center">
                        <h1>
                            <span class="text-info">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            <br>Welcome To Your Dashboard
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @if (Auth::user()->status == 'active')
        <div class="ps-account">
            <section class="user-dashboard py-5">
                <div class="container">
                    <div class="row g-3 g-xl-4 tab-wrap">
                        <div class="col-lg-4 col-xl-3 sticky">
                            <button class="setting-menu btn-solid btn-sm d-lg-none">Setting Menu <i
                                    class="arrow"></i></button>
                            @include('user.layouts.sidebar')
                        </div>
                        <div class="col-lg-8 col-xl-9">
                            <div class="right-content tab-content" id="myTabContent">
                                <!-- User Dashboard Start -->
                                <div class="tab-pane show active" id="dashboard" role="tabpanel"
                                    aria-labelledby="dashboard-tab">
                                    <div class="dashboard-tab">
                                        <div class="title-box3">
                                            <div class="title-box3 text-center">
                                                <h1>
                                                    <span class="text-info">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                                    <br>Welcome To Your Dashboard
                                                </h1>
                                            </div>
                                            <p>
                                                Welcome to your account page, where you can manage your trade account
                                                effortlessly. Here, you can view your order history, update your
                                                details, and place quick orders. Additionally, you can subscribe to our daily
                                                stock feed, check stock availability, download product images and data, view
                                                your saved shopping lists, and download a PDF product catalog.
                                            </p>
                                        </div>
                                        <div class="row g-0 option-wrap">
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{ route('user.order.history') }}" data-class="orders"
                                                    class="tab-box">
                                                    <img src="{{ asset('frontend/img/icon/1.svg') }}"
                                                        alt="shopping bag">
                                                    <h5>Order History</h5>
                                                    <p>Search and View Your Online Order History with Ease.</p>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{ route('user.account.details') }}" data-class="wishlist"
                                                    class="tab-box">
                                                    <img src="{{ asset('frontend/img/icon/2.svg') }}" alt="wishlist">
                                                    <h5>Account Details</h5>
                                                    <p>Update Your Contact Details and Address</p>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{ route('user.quick.order') }}" data-class="savedAddress"
                                                    class="tab-box">
                                                    <img src="{{ asset('frontend/img/icon/3.svg') }}" alt="address">
                                                    <h5>Quick order</h5>
                                                    <p>Search and Add Products to Your Basket for Quick Orders.</p>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{ route('user.stock.history') }}" data-class="payment"
                                                    class="tab-box">
                                                    <img src="{{ asset('frontend/img/icon/4.svg') }}" alt="payment">
                                                    <h5>Stock Availability</h5>
                                                    <p>Easily Check Stock Availability with Our User-Friendly Page.</p>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{ route('user.product.data') }}" data-class="profile"
                                                    class="tab-box">
                                                    <img src="{{ asset('frontend/img/icon/5.svg') }}" alt="profile">
                                                    <h5>Product Data Download</h5>
                                                    <p>Search and Download Product Data or Images with Ease.</p>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{ route('user.view.catalouge') }}" data-class="security"
                                                    class="tab-box">
                                                    <img src="{{ asset('frontend/img/icon/6.svg') }}" alt="security">
                                                    <h5>View Catalogue</h5>
                                                    <p>Download Our Next Year's Full PDF Catalog Here!</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- User Dashboard End -->
                                <!-- Order Tabs Start -->
                                <div class="tab-pane" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="cart-wrap order-content">
                                        <div class="title-box3">
                                            <h3>My Orders</h3>
                                            <p>H thanks for placing a delivery order with Oslo! Your order should be
                                                home
                                                with you in soon</p>
                                        </div>
                                        <div class="order-wraper">
                                            <div class="order-box">
                                                <div class="order-header">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-box">
                                                            <path
                                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                            </path>
                                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                            <line x1="12" y1="22.08" x2="12"
                                                                y2="12"></line>
                                                        </svg>
                                                    </span>
                                                    <div class="order-content">
                                                        <h5 class="order-status success">Delivered</h5>
                                                        <p>Place July 15 2022 and Delivered on July 18 2022</p>
                                                    </div>
                                                </div>
                                                <div class="order-info">
                                                    <div class="product-details" data-productdetail="product-detail">
                                                        <div class="img-box"><img
                                                                src="../assets/images/fashion/product/front/4.jpg"
                                                                alt="product"></div>
                                                        <div class="product-content">
                                                            <h5>Women’s long sleeve Jacket</h5>
                                                            <p class="truncate-3">
                                                                Versatile sporty slogans short sleeve quirky laid back
                                                                orange lux hoodies vests pins badges. Versatile sporty
                                                                slogans short sleeve quirky laid back orange lux hoodies
                                                                vests pins badges. Cutting edge crops stone transparent.
                                                            </p>
                                                            <span>Prize : <span>$120.00</span></span>
                                                            <span>Size : <span>M</span></span>
                                                            <span>Order Id : <span>edf125qa1d35</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box">
                                                        <span>Rate Product : </span>
                                                        <ul class="rating p-0 mb">
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-box">
                                                <div class="order-header">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-box">
                                                            <path
                                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                            </path>
                                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96">
                                                            </polyline>
                                                            <line x1="12" y1="22.08" x2="12"
                                                                y2="12"></line>
                                                        </svg>
                                                    </span>
                                                    <div class="order-content">
                                                        <h5 class="order-status success">Delivered</h5>
                                                        <p>Place July 15 2022 and Delivered on July 18 2022</p>
                                                    </div>
                                                </div>
                                                <div class="order-info">
                                                    <div class="product-details" data-productdetail="product-detail">
                                                        <div class="img-box"><img
                                                                src="../assets/images/fashion/product/front/5.jpg"
                                                                alt="product"></div>
                                                        <div class="product-content">
                                                            <h5>Women’s long sleeve Jacket</h5>
                                                            <p class="truncate-3">
                                                                Tunic knitted stretch leather spaghetti straps triangle
                                                                top
                                                                patterned panelled purple blush. Versatile sporty
                                                                slogans
                                                                short sleeve quirky laid back orange lux hoodies
                                                                vests pins badges.
                                                            </p>
                                                            <span>Prize : <span>$120.00</span></span>
                                                            <span>Size : <span>M</span></span>
                                                            <span>Order Id : <span>edf125qa1d35</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box">
                                                        <span>Rate Product : </span>
                                                        <ul class="rating p-0 mb">
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-box">
                                                <div class="order-header">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-box">
                                                            <path
                                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                            </path>
                                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96">
                                                            </polyline>
                                                            <line x1="12" y1="22.08" x2="12"
                                                                y2="12"></line>
                                                        </svg>
                                                    </span>
                                                    <div class="order-content">
                                                        <h5 class="order-status success">Delivered</h5>
                                                        <p>Place July 15 2022 and Delivered on July 18 2022</p>
                                                    </div>
                                                </div>
                                                <div class="order-info">
                                                    <div class="product-details" data-productdetail="product-detail">
                                                        <div class="img-box"><img
                                                                src="../assets/images/fashion/product/front/6.jpg"
                                                                alt="product"></div>
                                                        <div class="product-content">
                                                            <h5>Women’s long sleeve Jacket</h5>
                                                            <p class="truncate-3">
                                                                Pop top sporty stripe trims mesh inserts denim turtle
                                                                neck
                                                                casual white cotton button silver.Back print tattoo
                                                                graphics
                                                                printed expensive photos colors sun psychedelic
                                                                super casual tag.
                                                            </p>
                                                            <span>Prize : <span>$120.00</span></span>
                                                            <span>Size : <span>M</span></span>
                                                            <span>Order Id : <span>edf125qa1d35</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box">
                                                        <span>Rate Product : </span>
                                                        <ul class="rating p-0 mb">
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star fill">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                            <li>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Order Tabs End -->
                                <!-- Order Detail Tab Start -->
                                <div class="tab-pane" id="orders-details" role="tabpanel"
                                    aria-labelledby="orders-details">
                                    <div class="order-detail-wrap order-content">
                                        <div class="row g-3 g-md-4">
                                            <div class="col-12">
                                                <div class="order-summery-wrap mt-0 order-data">
                                                    <div class="banner-box">
                                                        <div class="media">
                                                            <div class="img">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-package">
                                                                    <line x1="16.5" y1="9.4"
                                                                        x2="7.5" y2="4.21"></line>
                                                                    <path
                                                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                                    </path>
                                                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96">
                                                                    </polyline>
                                                                    <line x1="12" y1="22.08"
                                                                        x2="12" y2="12"></line>
                                                                </svg>
                                                            </div>
                                                            <div class="media-body">
                                                                <h2>Order Delivered</h2>
                                                                <span class="font-sm">Delivered On July 15 2022</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="product-details">
                                                    <div class="img-box"><img
                                                            src="../assets/images/fashion/product/front/4.jpg"
                                                            alt="product"></div>
                                                    <div class="product-content">
                                                        <h5>Women’s long sleeve Jacket</h5>
                                                        <p class="truncate-3">
                                                            Versatile sporty slogans short sleeve quirky laid back
                                                            orange
                                                            lux hoodies vests pins badges. Versatile sporty slogans
                                                            short
                                                            sleeve quirky laid back orange lux hoodies
                                                            vests pins badges. Cutting edge crops stone transparent.
                                                        </p>
                                                        <span>Prize : <span>$120.00</span></span>
                                                        <span>Size : <span>M</span></span>
                                                        <span>Order Id : <span>edf125qa1d35</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="order-data summery-wrap">
                                                    <div class="order-summery-box">
                                                        <h5 class="cart-title">Price Details (1 Quantity)</h5>
                                                        <ul class="order-summery">
                                                            <li>
                                                                <span>Bag total</span>
                                                                <span>$220.00</span>
                                                            </li>
                                                            <li>
                                                                <span>Bag savings</span>
                                                                <span class="theme-color">-$20.00</span>
                                                            </li>
                                                            <li>
                                                                <span>Coupon Discount</span>
                                                                <a href="offer.html" class="font-danger">$120.00</a>
                                                            </li>
                                                            <li>
                                                                <span>Delivery</span>
                                                                <span>$50.00</span>
                                                            </li>
                                                            <li class="pb-0">
                                                                <span>Total Amount</span>
                                                                <span>$270.00</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row gy-3 gy-sm-0 g-3 g-md-4">
                                                    <div class="col-sm-6">
                                                        <div class="order-data general-details">
                                                            <!-- Payment Method Start -->
                                                            <div class="payment-method mt-0">
                                                                <h5 class="cart-title">Payment Method</h5>
                                                                <div class="payment-box">
                                                                    <img src="../assets/icons/png/1.png"
                                                                        alt="card">
                                                                    <span class="font-sm title-color"> **** **** ****
                                                                        6502</span>
                                                                </div>
                                                            </div>
                                                            <!-- Payment Method End -->
                                                            <button class="btn-solid mb-line btn-sm mt-4">Get Invoice
                                                                <i class="arrow"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="order-data general-details">
                                                            <!-- Contact Start -->
                                                            <div class="payment-method mt-0">
                                                                <h5 class="cart-title">Contact Us</h5>
                                                                <div class="payment-box">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-phone">
                                                                        <path
                                                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="font-sm title-color">
                                                                        <a class="content-color fw-500"
                                                                            href="tel:2554-4454-5646">2554-4454-5646</a>
                                                                    </span>
                                                                </div>
                                                                <div class="payment-box mt-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-phone">
                                                                        <path
                                                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="font-sm title-color">
                                                                        <a class="content-color fw-500"
                                                                            href="tel:5452-2545-2154">5452-2545-2154</a>
                                                                    </span>
                                                                </div>
                                                                <div class="payment-box mt-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-mail">
                                                                        <path
                                                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                                        </path>
                                                                        <polyline points="22,6 12,13 2,6"></polyline>
                                                                    </svg>
                                                                    <span class="font-sm title-color">
                                                                        <a class="content-color fw-500"
                                                                            href="mailto:someone@example.com">someone@example.com</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- Contact End -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="order-data general-details">
                                                    <!-- Address Section Start -->
                                                    <div class="address-ordered p-0">
                                                        <h5 class="cart-title">Order Address</h5>
                                                        <div class="address">
                                                            <h5 class="font-default title-color">Nadine Vogt <span
                                                                    class="badges badges-pill badges-theme">Home</span>
                                                            </h5>
                                                            <p class="font-default content-color">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-map-pin">
                                                                    <path
                                                                        d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z">
                                                                    </path>
                                                                    <circle cx="12" cy="10" r="3">
                                                                    </circle>
                                                                </svg>
                                                                1418 Riverwood Drive, Suite 3245 Cottonwood, CA 96052,
                                                                United States
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- Address Section End -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Order Detail Tab End -->
                                <!-- Saved Address Tabs Start -->
                                <div class="tab-pane" id="savedAddress" role="tabpanel"
                                    aria-labelledby="savedAddress-tab">
                                    <div class="address-tab">
                                        <div class="title-box3">
                                            <h3>Your Saved Address</h3>
                                            <p>here is your saved address, from here you can easily add or modify your
                                                address</p>
                                        </div>
                                        <div class="row g-3 g-md-4">
                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                <div class="address-box checked">
                                                    <div class="radio-box">
                                                        <div>
                                                            <input class="radio-input" type="radio" checked=""
                                                                id="radio1" name="radio1">
                                                            <label class="radio-label" for="radio1">Abigail</label>
                                                        </div>
                                                        <span class="badges badges-pill badges-theme">Home</span>
                                                        <div class="option-wrap">
                                                            <span class="edit" data-bs-toggle="modal"
                                                                data-bs-target="#edditAddress">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit">
                                                                    <path
                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                    </path>
                                                                    <path
                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span class="delet ms-0" data-bs-toggle="modal"
                                                                data-bs-target="#conformation">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="address-detail">
                                                        <p class="content-color font-default">3385 Happy Hollow Road
                                                            Wilmington, NC 28412</p>
                                                        <p class="content-color font-default">United State,325014</p>
                                                        <span class="content-color font-default">Mobile: <span
                                                                class="title-color font-default fw-500">
                                                                423-772-0570</span></span>
                                                        <span class="content-color font-default mt-1">Delivery: <span
                                                                class="title-color font-default fw-500"> 2
                                                                March</span></span>
                                                        <span class="content-color font-default mt-1">Cash on Delivery:
                                                            <span class="title-color font-default fw-500">
                                                                Available</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                <div class="address-box">
                                                    <div class="radio-box">
                                                        <div>
                                                            <input class="radio-input" type="radio" id="radio3"
                                                                name="radio1">
                                                            <label class="radio-label" for="radio3">Freddy J.
                                                                Burns</label>
                                                        </div>
                                                        <span class="badges badges-pill badges-theme">Home</span>
                                                        <div class="option-wrap">
                                                            <span class="edit" data-bs-toggle="modal"
                                                                data-bs-target="#edditAddress">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit">
                                                                    <path
                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                    </path>
                                                                    <path
                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span class="delet ms-0" data-bs-toggle="modal"
                                                                data-bs-target="#conformation">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="address-detail">
                                                        <p class="content-color font-default">198 Terry Lane Orlando,
                                                            FL
                                                            32809</p>
                                                        <p class="content-color font-default">Germany,254685</p>
                                                        <span class="content-color font-default">Mobile: <span
                                                                class="title-color font-default fw-500">
                                                                353-582-5870</span></span>
                                                        <span class="content-color font-default mt-1">Delivery: <span
                                                                class="title-color font-default fw-500"> 4
                                                                March</span></span>
                                                        <span class="content-color font-default mt-1">Cash on Delivery:
                                                            <span class="title-color font-default fw-500">
                                                                Available</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                <div class="address-box">
                                                    <div class="radio-box">
                                                        <div>
                                                            <input class="radio-input" type="radio" id="radio2"
                                                                name="radio1">
                                                            <label class="radio-label" for="radio2">Nadine
                                                                Vogt</label>
                                                        </div>
                                                        <span class="badges badges-pill badges-theme">Office</span>
                                                        <div class="option-wrap">
                                                            <span class="edit" data-bs-toggle="modal"
                                                                data-bs-target="#edditAddress">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit">
                                                                    <path
                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                    </path>
                                                                    <path
                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span class="delet ms-0" data-bs-toggle="modal"
                                                                data-bs-target="#conformation">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="address-detail">
                                                        <p class="content-color font-default">Wachaustrasse 22 8045
                                                            WEINITZEN</p>
                                                        <p class="content-color font-default">Austria,35546</p>
                                                        <span class="content-color font-default">Mobile: <span
                                                                class="title-color font-default fw-500">
                                                                454-254-3654</span></span>
                                                        <span class="content-color font-default mt-1">Delivery: <span
                                                                class="title-color font-default fw-500"> 5
                                                                March</span></span>
                                                        <span class="content-color font-default mt-1">Cash on Delivery:
                                                            <span class="title-color font-default fw-500">Not
                                                                Available</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                <div class="address-box add-new d-flex flex-column gap-2 align-items-center justify-content-center"
                                                    data-bs-toggle="modal" data-bs-target="#addNewAddress">
                                                    <span class="plus-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-plus">
                                                            <line x1="12" y1="5" x2="12"
                                                                y2="19"></line>
                                                            <line x1="5" y1="12" x2="19"
                                                                y2="12"></line>
                                                        </svg>
                                                    </span>
                                                    <h4 class="theme-color font-xl fw-500">Add New Address</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Saved Address Tabs End -->
                                <!-- Payment Tabs Start -->
                                <div class="tab-pane" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                    <div class="payment-tab">
                                        <div
                                            class="d-flex align-items-start align-items-sm-center justify-content-between title-box3">
                                            <div>
                                                <h3>Your Saved Card</h3>
                                                <p>here is your saved card, from here you can easily add or modify your
                                                    card
                                                </p>
                                            </div>
                                            <button class="btn btn-outline btn-sm white-space-no"
                                                data-bs-toggle="modal" data-bs-target="#addNewcard">Add Card</button>
                                        </div>
                                        <div class="payment-section">
                                            <div class="row g-3 g-xl-4">
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="payment-card bg-theme-blue border-color-blue">
                                                        <div class="bank-info">
                                                            <img class="bank" src="../assets/icons/png/bank1.png"
                                                                alt="bank1">
                                                            <div class="card-type">
                                                                <img class="bank-card" src="../assets/icons/png/1.png"
                                                                    alt="card">
                                                            </div>
                                                        </div>
                                                        <div class="card-details">
                                                            <span>Card Number</span>
                                                            <h5>6458 50XX XXXX 0851</h5>
                                                        </div>
                                                        <div class="card-details-wrap">
                                                            <div class="card-details">
                                                                <span>Name On Card</span>
                                                                <h5>Josephin water</h5>
                                                            </div>
                                                            <div class="text-center card-details">
                                                                <span>Validity</span>
                                                                <h5>XX/XX</h5>
                                                            </div>
                                                        </div>
                                                        <div class="btn-box">
                                                            <span data-bs-toggle="modal" data-bs-target="#editCard">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit">
                                                                    <path
                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                    </path>
                                                                    <path
                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span data-bs-toggle="modal"
                                                                data-bs-target="#conformation">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="payment-card bg-theme-orange border-color-orange">
                                                        <div class="bank-info">
                                                            <img class="bank" src="../assets/icons/png/bank2.png"
                                                                alt="bank1">
                                                            <div class="card-type">
                                                                <img class="bank-card" src="../assets/icons/png/2.png"
                                                                    alt="card">
                                                            </div>
                                                        </div>
                                                        <div class="card-details">
                                                            <span>Card Number</span>
                                                            <h5>2564 75XX XXXX 3545</h5>
                                                        </div>
                                                        <div class="card-details-wrap">
                                                            <div class="card-details">
                                                                <span>Name On Card</span>
                                                                <h5>Josephin water</h5>
                                                            </div>
                                                            <div class="text-center card-details">
                                                                <span>Validity</span>
                                                                <h5>XX/XX</h5>
                                                            </div>
                                                        </div>
                                                        <div class="btn-box">
                                                            <span data-bs-toggle="modal" data-bs-target="#editCard">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit">
                                                                    <path
                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                    </path>
                                                                    <path
                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span data-bs-toggle="modal"
                                                                data-bs-target="#conformation">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="payment-card bg-theme-yellow border-color-yellow">
                                                        <div class="bank-info">
                                                            <img class="bank" src="../assets/icons/png/bank3.png"
                                                                alt="bank1">
                                                            <div class="card-type">
                                                                <img class="bank-card" src="../assets/icons/png/5.png"
                                                                    alt="card">
                                                            </div>
                                                        </div>
                                                        <div class="card-details">
                                                            <span>Card Number</span>
                                                            <h5>8564 34XX XXXX 9564</h5>
                                                        </div>
                                                        <div class="card-details-wrap">
                                                            <div class="card-details">
                                                                <span>Name On Card</span>
                                                                <h5>Josephin water</h5>
                                                            </div>
                                                            <div class="text-center card-details">
                                                                <span>Validity</span>
                                                                <h5>XX/XX</h5>
                                                            </div>
                                                        </div>
                                                        <div class="btn-box">
                                                            <span data-bs-toggle="modal" data-bs-target="#editCard">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit">
                                                                    <path
                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                    </path>
                                                                    <path
                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span data-bs-toggle="modal"
                                                                data-bs-target="#conformation">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Payment Tabs End -->
                                <!-- Profile Tabs Start -->
                                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="profile">
                                        <div class="title-box3">
                                            <h3>Basics Information</h3>
                                        </div>
                                        <form action="javascript:void(0)" class="custom-form form-pill">
                                            <div class="row g-3 g-xl-4">
                                                <div class="col-sm-6">
                                                    <div class="input-box">
                                                        <label for="fullname">Full Name</label>
                                                        <input class="form-control" id="fullname" name="fullname"
                                                            type="text" value="Josephin water">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-box">
                                                        <label for="email">Email</label>
                                                        <input class="form-control" id="email" name="email"
                                                            type="email" value="Josephin.water@gmail.com">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-box">
                                                        <label for="mobile">Mobile</label>
                                                        <input maxlength="10" class="form-control" id="mobile"
                                                            name="mobile" type="number" value="9645823465">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-box">
                                                        <label for="gender">Gender</label>
                                                        <select name="gender" id="gender" class="form-control">
                                                            <option selected="">Male</option>
                                                            <option>Female</option>
                                                            <option>Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-box">
                                                        <label for="location">Location</label>
                                                        <select name="location" id="location" class="form-control">
                                                            <option selected="">london</option>
                                                            <option>United State</option>
                                                            <option>India</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-box">
                                                        <label for="photo">Profile Photo</label>
                                                        <input class="form-control" id="photo" name="photo"
                                                            accept="application/pdf" type="file">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-box">
                                                        <label for="address1">Address 1</label>
                                                        <input class="form-control" id="address1" name="address1"
                                                            type="text" value="123, Main Str.">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-box">
                                                        <label for="address2">Address 1</label>
                                                        <input class="form-control" id="address2" name="address2"
                                                            type="text" value="123, Main Str.">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-box">
                                                        <label for="al-mobile">Alternate Mobile</label>
                                                        <input maxlength="10" class="form-control" id="al-mobile"
                                                            name="al-mobile" type="number" value="7565441862">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-box">
                                                        <label for="hint-name">Nick Name</label>
                                                        <input class="form-control" id="hint-name" name="hint-name"
                                                            type="text" value="Josephin ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-box">
                                                <button class="btn-outline btn-sm">Cancel</button>
                                                <button class="btn-solid btn-sm">Save Changes <i
                                                        class="arrow"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Profile Tabs End -->
                                <!-- Security Tabs Start -->
                                <div class="tab-pane" id="security" role="tabpanel" aria-labelledby="security-tab">
                                    <div class="privacy-tab">
                                        <div class="privacy box">
                                            <div class="title-box3">
                                                <h3>Privacy</h3>
                                            </div>
                                            <div class="setting-option">
                                                <div class="content-box">
                                                    <h6 class="font-roboto">Allows others to see my profile</h6>
                                                    <p class="font-roboto">all peoples will be able to see my profile.
                                                    </p>
                                                </div>
                                                <label class="switch"> <input checked="" type="checkbox"
                                                        name="chk1" value="option1" class="setting-check"><span
                                                        class="switch-state"></span> </label>
                                            </div>
                                            <div class="setting-option mt-3">
                                                <div class="content-box">
                                                    <h6 class="font-roboto">Who has save this profile only that people
                                                        see
                                                        my profile</h6>
                                                    <p class="font-roboto">all peoples will not be able to see my
                                                        profile.
                                                    </p>
                                                </div>
                                                <label class="switch"> <input type="checkbox" name="chk2"
                                                        value="option1" class="setting-check"><span
                                                        class="switch-state"></span> </label>
                                            </div>
                                            <button class="btn-solid btn-sm">Save Changes <i
                                                    class="arrow"></i></button>
                                        </div>
                                        <div class="account-box">
                                            <div class="title-box3">
                                                <h3>Account settings</h3>
                                            </div>
                                            <div class="setting-option">
                                                <div class="content-box">
                                                    <h6 class="font-roboto">Deleting Your Account Will Permanently</h6>
                                                    <p class="font-roboto">Once your account is deleted, you will be
                                                        logged
                                                        out and will be unable to log in back.</p>
                                                </div>
                                                <label class="switch"> <input type="checkbox" name="chk3"
                                                        value="option2" class="setting-check" checked=""><span
                                                        class="switch-state"></span> </label>
                                            </div>
                                            <div class="setting-option mt-3">
                                                <div class="content-box">
                                                    <h6 class="font-roboto">Deleting Your Account Will Temporary</h6>
                                                    <p class="font-roboto">Once your account is deleted, you will be
                                                        logged
                                                        out and you will be create new account.</p>
                                                </div>
                                                <label class="switch"> <input type="checkbox" name="chk4"
                                                        value="option4" class="setting-check"><span
                                                        class="switch-state"></span> </label>
                                            </div>
                                            <button class="btn-solid btn-sm">Save Changes <i
                                                    class="arrow"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Security Tabs End -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @else
        <section class="user-dashboard py-8">
            <div class="container">
                <div>
                    <h6 class="text-warning display-4 text-center">Thank you for registering. <br> Our team is
                        reviewing your information. You'll receive a confirmation email once your account is active.
                    </h6>
                    <div class="d-flex justify-content-center">
                        <img class="img-fluid" style="width: 100px;"
                            src="https://cdni.iconscout.com/illustration/premium/thumb/wait-a-minute-6771645-5639826.png?f=webp"
                            alt="">
                    </div>
                    <div class="w-25 mx-auto">
                        <a href="{{ route('home') }}" class="ps-btn ps-btn--warning">Back To Home</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
</x-frontend-app-layout>
