<x-frontend-app-layout :title="'Your Order History'">
    <style>
        input {
            font-family: 'HelveticaNeue', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #555860;
        }

        .search {
            position: relative;
            margin: 0 auto;
            width: 400px;
        }

        .search input {
            height: 40px;
            width: 400px;
            padding: 0 12px 0 25px;
            background: white url("https://cssdeck.com/uploads/media/items/5/5JuDgOa.png") 8px 14px no-repeat;
            border-radius: 20px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -moz-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -ms-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -o-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
        }

        .search input:focus {
            outline: none;
            border-color: #66b1ee;
            -webkit-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -moz-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -ms-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -o-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
        }

        .search input:focus+.results {
            display: block
        }

        .search .results {
            display: none;
            position: absolute;
            top: 40px;
            left: 0;
            right: 0;
            z-index: 10;
            width: 400px;
            padding: 0;
            margin: 0;
            border-radius: 3px;
            background-color: #fdfdfd;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fdfdfd), color-stop(100%, #eceef4));
            background-image: -webkit-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -moz-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -ms-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -o-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: linear-gradient(top, #fdfdfd, #eceef4);
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -ms-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -o-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .search .results li {
            display: block
        }

        .search .results li:first-child {
            margin-top: -1px
        }

        .search .results li:first-child:before,
        .search .results li:first-child:after {
            display: block;
            content: '';
            width: 0;
            height: 0;
            position: absolute;
            left: 50%;
            margin-left: -5px;
            border: 5px outset transparent;
        }

        .search .results li:first-child:before {
            border-bottom: 5px solid #c4c7d7;
            top: -11px;
        }

        .search .results li:first-child:after {
            border-bottom: 5px solid #fdfdfd;
            top: -10px;
        }

        .search .results li:first-child:hover:before,
        .search .results li:first-child:hover:after {
            display: none
        }

        .search .results li:last-child {
            margin-bottom: -1px
        }

        .search .results a {
            display: block;
            position: relative;
            margin: 0 -1px;
            padding: 6px 40px 6px 10px;
            color: #808394;
            font-weight: 500;
            text-shadow: 0 1px #fff;
            border: 1px solid transparent;
            border-radius: 3px;
        }

        .search .results a span {
            font-weight: 200
        }

        .search .results a:before {
            content: '';
            width: 18px;
            height: 18px;
            position: absolute;
            top: 50%;
            right: 10px;
            margin-top: -9px;
            background: url("https://cssdeck.com/uploads/media/items/7/7BNkBjd.png") 0 0 no-repeat;
        }

        .search .results a:hover {
            text-decoration: none;
            color: #fff;
            text-shadow: 0 -1px rgba(0, 0, 0, 0.3);
            background-color: var(--site-green);
            box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
        }

        :-moz-placeholder {
            color: #a7aabc;
            font-weight: 200;
        }

        ::-webkit-input-placeholder {
            color: #a7aabc;
            font-weight: 200;
        }

        .lt-ie9 .search input {
            line-height: 26px
        }

        .custom-btn {
            position: relative;
            left: -40px;
            top: 0px;
            padding: 10px 12px;
            border-radius: 100%;
            width: 150px;
            height: 40px;
            border: 1px solid #ffffff;
            background: var(--site-green);
            color: white;
        }

        .bg-info {
            background-color: var(--site-green) !important;
            border-color: var(--site-green) !important;
        }

        /* TRack Orders Result */
        .track-mark {
            width: 25px;
            background: var(--site-red);
            padding: 0px;
            text-align: center;
            border-radius: 100%;
            color: white;
            padding: 4px 24px 0px 14px;
            font-size: 20px;
            font-weight: bold;
            position: relative;
            z-index: 6;
        }

        .track-range {
            left: 3px;
            background: var(--site-green);
            height: 10px;
            position: relative;
            top: -32px;
            z-index: 5;
        }

        .active {
            width: 25px;
            background: var(--site-green) !important;
            padding: 0px;
            text-align: center;
            border-radius: 100%;
            color: white;
            padding: 4px 24px 0px 14px;
            font-size: 20px;
            font-weight: bold;
            position: relative;
            z-index: 6;
        }
    </style>
    <div class="breadcrumb-wrap">
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
    </div>

    <div class="ps-account">
        <section class="user-dashboard py-8">
            <div class="container">
                <div class="row g-3 g-xl-4 tab-wrap">
                    <div class="col-lg-4 col-xl-3 sticky">
                        <!-- Sidebar here -->
                        @include('user.layouts.sidebar')
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border-0 bg-info w-75 mx-auto">
                                    <div class="card-body p-5" style="padding-top: 20px; padding-bottom: 20px;">
                                        <section class="main">
                                            <div class="mb-5">
                                                <h3 class="text-center text-white">Track Your Order With <br> Product
                                                    Id....</h3>
                                            </div>
                                            <form class="search d-flex" method="post" action="index.html">
                                                <div style="width: 400px;">
                                                    <input type="text" name="q" placeholder="Search..." />
                                                    <ul class="results">
                                                        <li><a href="index.html">Search Result
                                                                #1<br /><span>Description...</span></a></li>
                                                        <li><a href="index.html">Search Result
                                                                #2<br /><span>Description...</span></a></li>
                                                        <li><a href="index.html">Search Result
                                                                #3<br /><span>Description...</span></a></li>
                                                        <li><a href="index.html">Search Result #4</a></li>
                                                    </ul>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-outline-whtie custom-btn">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card my-5">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-info">
                                        <div>
                                            <p class="mb-0 text-white">Order: #sdasd56</p>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-white">Expected Arraival</p>
                                            <p class="mb-0 text-white">Grasssh Shoppers : VHF568</p>
                                        </div>
                                    </div>
                                    <div class="card-body p-5">
                                        {{-- Track Status --}}
                                        <div class="row p-5">
                                            <div class="col-lg-2 px-0">
                                                <p class="track-mark active">1</p>
                                                <div class="track-range">
                                                </div>
                                                {{-- Status --}}
                                                <div>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="50"
                                                            height="50" x="0" y="0" viewBox="0 0 48 48"
                                                            style="enable-background:new 0 0 512 512"
                                                            xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M33.37 45H10.63a7 7 0 0 1-6.965-7.7l2.16-21.6A2.986 2.986 0 0 1 8.81 13h26.38a2.987 2.987 0 0 1 2.985 2.7l.91 9.077a1 1 0 1 1-1.99.2l-.91-9.08a.994.994 0 0 0-1-.9H8.81a.994.994 0 0 0-1 .9L5.655 37.5A5 5 0 0 0 10.63 43h22.721a1.039 1.039 0 0 1 1.169.99.976.976 0 0 1-.951 1 1.621 1.621 0 0 1-.199.01z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                                <path
                                                                    d="M30 18a1 1 0 0 1-1-1v-5a7 7 0 0 0-14 0v5a1 1 0 0 1-2 0v-5a9 9 0 0 1 18 0v5a1 1 0 0 1-1 1zM34 45a11 11 0 1 1 11-11 11.013 11.013 0 0 1-11 11zm0-20a9 9 0 1 0 9 9 9.01 9.01 0 0 0-9-9z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                                <path
                                                                    d="M33 38a1 1 0 0 1-.707-.293l-3-3a1 1 0 0 1 1.414-1.414L33 35.586l5.293-5.293a1 1 0 0 1 1.414 1.414l-6 6A1 1 0 0 1 33 38z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <p class="mb-0" style="color: var(--site-green)">Confirmed Order
                                                    </p>
                                                    <small>25 Aug 2024</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 px-0">
                                                <p class="track-mark active">2</p>
                                                <div class="track-range">
                                                </div>
                                                {{-- Status --}}
                                                <div>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="50"
                                                            height="50" x="0" y="0" viewBox="0 0 100 100"
                                                            style="enable-background:new 0 0 512 512"
                                                            xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M73.76 38.48v23.07a1.74 1.74 0 0 1-1.27 1.71l-21.8 7.65a1.59 1.59 0 0 1-1.38 0l-21.9-7.65a1.73 1.73 0 0 1-1.17-1.71l-.11-23.07a1.83 1.83 0 0 1 1.38-1.7l21.91-7.65a1.14 1.14 0 0 1 1.16 0l22 7.65a1.73 1.73 0 0 1 1.17 1.7zM29.21 89.94a1.81 1.81 0 0 1 1.71-3.19A41.41 41.41 0 0 0 82.27 24a.41.41 0 0 0-.75.32l.32 1.28c.64 2.34-2.87 3.19-3.51 1l-2.55-9.79A1.74 1.74 0 0 1 78 14.67l9.68 2.55a1.82 1.82 0 0 1-1 3.51l-1.91-.53c-.43-.11-.75.32-.43.63a45.06 45.06 0 0 1-55.13 69.11zm42.64-79.31c2.12 1.17.32 4.36-1.7 3.19A41.43 41.43 0 0 0 17.73 76a.44.44 0 0 0 .75-.42l-.32-1.17c-.64-2.34 2.87-3.19 3.51-1l2.55 9.78A1.75 1.75 0 0 1 22 85.37l-9.68-2.55c-2.34-.64-1.38-4.15.85-3.51l2 .53c.43.11.75-.32.43-.74C.51 61.45 1.68 34.66 18.16 18.18a45.07 45.07 0 0 1 53.69-7.55zm-20.1 37.1v18.4a.47.47 0 0 0 .64.42l17.54-6.17c.11-.1.32-.21.32-.42V41.57c0-.22-.32-.43-.63-.32l-17.55 6.06c-.21.1-.32.21-.32.42zm-3.61 18.4v-18.4a.55.55 0 0 0-.21-.42l-7.13-2.45a.47.47 0 0 0-.63.43v6.8a1.8 1.8 0 0 1-1.81 1.81 1.86 1.86 0 0 1-1.81-1.81v-8.4a.55.55 0 0 0-.21-.42l-6-2c-.31-.11-.63.1-.63.32V60c0 .21.1.32.32.42l17.54 6.17c.32.11.53-.11.53-.42zm-13.5-27.22 4.68 1.59a.19.19 0 0 0 .31 0l15.21-5.31c.21 0 .32-.21.32-.43a.35.35 0 0 0-.32-.32l-4.68-1.7h-.32l-15.2 5.32a.44.44 0 0 0 0 .85zm11.48 4 3.72 1.27h.32l15.2-5.31a.44.44 0 0 0 0-.85l-3.82-1.38h-.32l-15.1 5.46c-.43.1-.43.64 0 .85zm19.56 12.27a1.8 1.8 0 0 1 1.17 3.4L60.9 60.7a1.8 1.8 0 0 1-1.17-3.4z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <p class="mb-0" style="color: var(--site-green)">
                                                        Process order
                                                    </p>
                                                    <small>26 Aug 2024</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 px-0">
                                                <p class="track-mark active">3</p>
                                                <div class="track-range">
                                                </div>
                                                {{-- Status --}}
                                                <div>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="50"
                                                            height="50" x="0" y="0" viewBox="0 0 100 100"
                                                            style="enable-background:new 0 0 512 512"
                                                            xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M95.5 68c-.7.4-1.4.8-2.1 1.3-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-.8-.5-1.6-1-2.5-1.5l12.4-23c.2-.3.2-.7 0-1s-.5-.5-.9-.5H78.7c-.3 0-.5.1-.7.3L75.6 46h-7.7v-5.5c0-3-2.5-5.5-5.5-5.5v-4.3c0-.6-.4-1-1-1h-6.1v-8.8c0-.6-.4-1-1-1h-7.8c-.6 0-1 .4-1 1V35H36c-3 0-5.5 2.5-5.5 5.5v4.4h-5.1c-3 0-5.5 2.5-5.5 5.5v1H6.6c-.4 0-.7.2-.9.5s-.1.7.1 1L16.2 68c-.6.3-1.2.7-1.8 1.1-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-.4-.3-.8-.5-1.2-.7-.5-.3-1.1-.1-1.4.3-.3.5-.1 1.1.3 1.4.4.2.7.5 1.1.7 1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c.6-.4 1.2-.8 1.9-1.1.5-.3.7-.9.4-1.3s-.9-.6-1.4-.4zM60.3 31.8V35h-5.1v-3.3h5.1zm-12.9-9.9h5.8V35h-5.8zM21.8 50.5c0-1.9 1.6-3.5 3.5-3.5h28.9c.6 0 1-.4 1-1s-.4-1-1-1H32.5v-4.4c0-1.9 1.6-3.5 3.5-3.5H62.3c1.9 0 3.5 1.6 3.5 3.5V46h-2.3c-.3 0-.5.1-.7.3l-5.1 5.1H21.8zm51.9 18.8c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1-.7 0-1.3.1-1.8.3l-9.5-14h49.6c.3 0 .5-.1.7-.3L64 48h12c.3 0 .5-.1.7-.3l2.4-2.4h13L80.3 67.2c-.3-.1-.7-.1-1.1-.1-2.3 0-4 1.2-5.5 2.2zM79.2 74.1c-2.3 0-4 1.1-5.5 2.1-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8-.6 0-1 .4-1 1s.4 1 1 1c2.3 0 4-1.1 5.5-2.1 1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8.6 0 1-.4 1-1s-.4-1-1-1z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                                <circle cx="22.6" cy="60.3" r="2.3"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></circle>
                                                                <circle cx="33.9" cy="60.3" r="2.3"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></circle>
                                                                <circle cx="45.2" cy="60.3" r="2.3"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></circle>
                                                                <circle cx="56.6" cy="60.3" r="2.3"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></circle>
                                                                <path
                                                                    d="M82.5 53.6c0-.6-.4-1-1-1s-1 .4-1 1c0 .7-.6 1.3-1.3 1.3s-1.2-.6-1.2-1.3c0-.6-.4-1-1-1s-1 .4-1 1c0 1.8 1.5 3.3 3.3 3.3s3.2-1.5 3.2-3.3z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <p class="mb-0" style="color: var(--site-green)">
                                                        Order Shipped
                                                    </p>
                                                    <small>27 Aug 2024</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 px-0">
                                                <p class="track-mark">4</p>
                                                <div class="track-range">
                                                </div>
                                                {{-- Status --}}
                                                <div>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="50"
                                                            height="50" x="0" y="0" viewBox="0 0 520 520"
                                                            style="enable-background:new 0 0 512 512"
                                                            xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M159.152 240.606a46.546 46.546 0 1 0-46.546 46.546 46.6 46.6 0 0 0 46.546-46.546zm-77.576 0a31.03 31.03 0 1 1 31.03 31.03 31.065 31.065 0 0 1-31.03-31.03zM477.212 147.515a31.03 31.03 0 1 0-31.03 31.03 31.065 31.065 0 0 0 31.03-31.03zm-46.545 0a15.515 15.515 0 1 1 15.515 15.515 15.53 15.53 0 0 1-15.515-15.515z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                                <path
                                                                    d="M481.949 224.72C498.725 205.164 516 177.76 516 147.515a69.818 69.818 0 1 0-139.636 0c0 30.244 17.274 57.648 34.05 77.2-8.179 3.963-13.935 9.223-16.671 15.3-.4-.035-.726-.065-1.16-.1a7.758 7.758 0 1 0-1.288 15.462c.738.062 1.339.116 1.978.172 5.386 13.989 26.315 23.847 52.909 23.847 30.958 0 54.3-13.341 54.3-31.03.003-9.566-6.782-17.951-18.533-23.646zM446.182 93.212a54.364 54.364 0 0 1 54.3 54.3c0 41.36-40.379 79.083-54.307 90.868-13.939-11.766-54.3-49.417-54.3-90.868a54.364 54.364 0 0 1 54.307-54.3zm0 170.667c-23.678 0-38.788-9.19-38.788-15.515 0-3.418 4.85-8.2 14.167-11.57a205.5 205.5 0 0 0 19.966 17.774 7.753 7.753 0 0 0 9.31 0A205.757 205.757 0 0 0 470.8 236.8c9.318 3.373 14.168 8.155 14.168 11.569.002 6.32-15.108 15.51-38.786 15.51zM198.333 396.261c-.669-.038-1.2-.07-1.787-.105-4.045-10.827-17.075-19.76-36.977-25.346 28.8-31.163 61.643-78.1 61.643-130.2A108.606 108.606 0 0 0 4 240.606c0 52.1 32.846 99.041 61.643 130.2-24.26 6.809-38.37 18.585-38.37 32.7 0 25.193 43.966 38.788 85.333 38.788 36.637 0 75.247-10.682 83.613-30.623l1.243.074c.148.007.3.011.443.011a7.758 7.758 0 0 0 .428-15.5zm-85.727-248.746a93.2 93.2 0 0 1 93.094 93.091c0 72.379-73.682 137.2-93.091 153.023-19.409-15.818-93.094-80.644-93.094-153.023a93.2 93.2 0 0 1 93.091-93.091zm0 279.273c-42.621 0-69.818-13.784-69.818-23.273 0-6.215 12.473-14.944 35.437-19.748a316.566 316.566 0 0 0 29.752 25.972 7.751 7.751 0 0 0 9.258 0 316.421 316.421 0 0 0 29.752-25.972c22.964 4.8 35.437 13.533 35.437 19.748 0 9.485-27.197 23.273-69.818 23.273zM269.307 273.186a20.185 20.185 0 0 1 7.447-7.213.59.59 0 0 1 .31-.155l.08-.079a7.672 7.672 0 0 0 3.644-6.595 8.294 8.294 0 0 0-1.083-4.034 7.949 7.949 0 0 0-10.629-2.637c-6.129 3.724-10.629 8.144-13.421 13.345a7.717 7.717 0 0 0 6.826 11.4 7.888 7.888 0 0 0 6.826-4.032zM242.932 397.462h-.466c-4.811 0-9.7 0-14.428-.076h-.155a7.8 7.8 0 0 0-7.758 7.6 7.677 7.677 0 0 0 7.6 7.833c4.887.155 9.773.155 14.739.155h.39a7.758 7.758 0 0 0 .076-15.515zM397 342.307v-.08a7.959 7.959 0 0 0-10.007-4.341 7.759 7.759 0 0 0-4.421 10.084 24.858 24.858 0 0 1 1.553 9 15.942 15.942 0 0 1-.079 2.015 7.753 7.753 0 0 0 6.905 8.534h.776a7.751 7.751 0 0 0 7.758-6.981c.076-1.163.155-2.405.155-3.568a41.337 41.337 0 0 0-2.484-14.353c-.08-.079-.08-.234-.156-.31zM370.856 376.674a74.514 74.514 0 0 1-12.182 6.049 7.846 7.846 0 0 0-4.344 10.084 7.757 7.757 0 0 0 7.215 4.89 7.244 7.244 0 0 0 2.872-.545 87.153 87.153 0 0 0 14.738-7.368 7.731 7.731 0 0 0 3.568-6.519 8.14 8.14 0 0 0-1.162-4.189 7.935 7.935 0 0 0-10.705-2.402zM287.383 395.989c-4.966.386-9.928.621-14.739.852a7.687 7.687 0 0 0-7.447 8.068 7.718 7.718 0 0 0 7.758 7.447h.31a679.792 679.792 0 0 0 15.205-.852 7.842 7.842 0 0 0 7.212-7.758v-.541a7.8 7.8 0 0 0-8.299-7.216zM331.136 390.481c-4.269.852-8.92 1.629-14.428 2.481a7.11 7.11 0 0 0-5.045 3.027 7.55 7.55 0 0 0-1.474 5.742 7.705 7.705 0 0 0 7.682 6.591 5.579 5.579 0 0 0 1.084-.076c5.121-.7 10.242-1.553 15.208-2.56a7.862 7.862 0 0 0 6.28-7.523 9.386 9.386 0 0 0-.155-1.553 7.881 7.881 0 0 0-9.152-6.129zM280.943 311.508a7.743 7.743 0 0 0 2.871-14.97 37.375 37.375 0 0 1-10.784-5.974 7.964 7.964 0 0 0-10.935.853 7.755 7.755 0 0 0 .852 10.939c3.955 3.413 8.845 6.129 15.2 8.61a7.176 7.176 0 0 0 2.796.542zM323.534 321.6a8.713 8.713 0 0 0 1.394.075 7.742 7.742 0 0 0 1.322-15.359l-3.648-.622c-3.879-.7-7.447-1.394-11.094-2.015a7.764 7.764 0 0 0-9.076 6.129 8.6 8.6 0 0 0-.076 1.394 7.608 7.608 0 0 0 6.284 7.682c4.5.852 9.076 1.708 13.5 2.481zM361.235 253.792a7.936 7.936 0 0 0 7.837-7.678v-.156a7.792 7.792 0 0 0-7.606-7.681c-3.724-.156-7.368-.156-11.015-.156h-4.265a7.758 7.758 0 1 0 .155 15.515c4.966-.075 9.928 0 14.739.156zM317.1 255.189a7.7 7.7 0 0 0 6.9-7.757v-.777a7.823 7.823 0 0 0-8.534-6.905c-5.508.621-10.7 1.322-15.515 2.25a7.745 7.745 0 0 0 1.394 15.36 9.372 9.372 0 0 0 1.477-.155c4.42-.773 9.231-1.474 14.278-2.016zM368.451 333.076a7.754 7.754 0 0 0 3.178-14.818 101.8 101.8 0 0 0-14.739-5.277 1.114 1.114 0 0 0-.466-.151h-.076a7.829 7.829 0 0 0-9.541 5.352 9.618 9.618 0 0 0-.235 2.095 7.659 7.659 0 0 0 5.587 7.446 93.893 93.893 0 0 1 13.11 4.652 7.585 7.585 0 0 0 3.182.701z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </span>

                                                    <p class="mb-0" style="color: var(--site-green)">
                                                        Order En Route
                                                    </p><small>28 Aug 2024</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 px-0">
                                                <p class="track-mark">5</p>
                                                <div class="track-range">
                                                </div>
                                                {{-- Status --}}
                                                <div>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="50"
                                                            height="50" x="0" y="0" viewBox="0 0 16.933 16.933"
                                                            style="enable-background:new 0 0 512 512"
                                                            xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M5.556 1.984A2.386 2.386 0 0 0 3.189 4.1H1.587C.86 4.1.265 4.696.265 5.424v7.672a.265.265 0 0 0 .263.265h1.607c.13.895.903 1.588 1.833 1.588a1.86 1.86 0 0 0 1.834-1.588h5.859c.13.895.903 1.588 1.832 1.588.93 0 1.703-.693 1.832-1.588h1.078a.265.265 0 0 0 .266-.265V8.863a.265.265 0 0 0-.01-.07l-.793-2.91a.265.265 0 0 0-.256-.196h-4.764v-.263c0-.728-.594-1.325-1.322-1.325H7.921a2.385 2.385 0 0 0-2.365-2.115zm0 .53c1.026 0 1.851.825 1.851 1.85s-.825 1.852-1.851 1.852-1.852-.825-1.852-1.851.826-1.852 1.852-1.852zm.832 1.114a.265.265 0 0 0-.158.06l-.977.8-.363-.322a.265.265 0 0 0-.373.021.265.265 0 0 0 .021.373l.533.475a.265.265 0 0 0 .344.006l1.15-.943a.265.265 0 0 0 .037-.373.265.265 0 0 0-.18-.096.265.265 0 0 0-.034-.002zM1.587 4.629H3.189c.132 1.188 1.144 2.117 2.367 2.117S7.79 5.817 7.92 4.63h1.603a.79.79 0 0 1 .793.795v7.408H5.802a1.858 1.858 0 0 0-1.834-1.588c-.93 0-1.705.692-1.833 1.588H.794V5.424a.79.79 0 0 1 .793-.795zm9.26 1.587h4.56l.733 2.682v3.934h-.814a1.856 1.856 0 0 0-1.833-1.588c-.93 0-1.704.692-1.833 1.588h-.814zm.795.53a.265.265 0 0 0-.266.266v1.586a.265.265 0 0 0 .266.265h3.591a.265.265 0 0 0 .256-.334l-.434-1.586a.265.265 0 0 0-.253-.195l-1.838-.002zm.263.53h1.059l1.635.001.288 1.057h-2.982zm-7.937 4.497c.722 0 1.306.57 1.324 1.289v.034a1.32 1.32 0 0 1-1.324 1.324c-.734 0-1.323-.59-1.323-1.324s.589-1.323 1.323-1.323zm9.525 0c.723 0 1.304.57 1.322 1.289v.034c0 .733-.588 1.324-1.322 1.324s-1.322-.59-1.322-1.324.588-1.323 1.322-1.323zm-9.525.53c-.436 0-.794.357-.794.793s.358.794.794.794c.435 0 .795-.36.795-.794s-.36-.794-.795-.794zm9.525 0c-.435 0-.793.357-.793.793s.358.794.793.794.795-.36.795-.794-.36-.794-.795-.794zm-9.54.53h.015c.149 0 .265.113.265.263s-.116.265-.265.265a.26.26 0 0 1-.264-.265c0-.145.107-.257.25-.264zm9.526 0h.014c.15 0 .266.113.266.263s-.117.265-.266.265-.264-.116-.264-.265a.26.26 0 0 1 .25-.264z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <p class="mb-0" style="color: var(--site-green)">
                                                        Order Arrived
                                                    </p>
                                                    <small>29 Aug 2024</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 px-0">
                                                <p class="track-mark">6</p>
                                                <div class="track-range">
                                                </div>
                                                {{-- Status --}}
                                                <div>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="50"
                                                            height="50" x="0" y="0" viewBox="0 0 64 64"
                                                            style="enable-background:new 0 0 512 512"
                                                            xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M37 12H21a1 1 0 0 0-1 1v1.11a7.01 7.01 0 0 0-2.596-1.676A6.986 6.986 0 0 0 20 7h4V5h-4.295c-.863-2.888-3.54-5-6.705-5-3.86 0-7 3.14-7 7a6.986 6.986 0 0 0 2.596 5.434C5.919 13.418 4 15.986 4 19v11c0 2.459.72 4.846 2 6.894v10.87L.105 59.553a1.001 1.001 0 0 0 .38 1.305l5 3a1.002 1.002 0 0 0 1.367-.334l8-13c.075-.122.123-.258.141-.4l.616-4.918L20 48.5V63a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V44c0-.245-.09-.481-.252-.665L20 34.62V34h9c2.757 0 5-2.243 5-5v-1h3a1 1 0 0 0 1-1V13a1 1 0 0 0-1-1zm-7 2v4h-2v-4zM13 2a5.003 5.003 0 0 1 4.576 3H8.424A5.003 5.003 0 0 1 13 2zM8 7h10c0 2.757-2.243 5-5 5S8 9.757 8 7zm5.035 42.661L5.667 61.634l-3.358-2.015 5.586-11.172C7.964 48.309 8 48.155 8 48v-8.626c.378.364.776.708 1.2 1.026l4.566 3.424zM32 29c0 1.654-1.346 3-3 3H19c-1.654 0-3-1.346-3-3v-9h-2v9a5.008 5.008 0 0 0 4 4.899V35c0 .245.09.481.252.665L26 44.38V62h-4V48a1 1 0 0 0-.4-.8l-11.2-8.4A11.052 11.052 0 0 1 6 30V19c0-2.757 2.243-5 5-5h4c2.757 0 5 2.243 5 5v8a1 1 0 0 0 1 1h11zm4-3H22V14h4v5a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-5h4zM64 1a1 1 0 0 0-1-1H43a1 1 0 0 0-1 1v26h-1a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h1v28a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1zM44 2h18v16h-4.11A6.977 6.977 0 0 0 60 13c0-3.86-3.14-7-7-7s-7 3.14-7 7c0 3.244 2.222 5.972 5.222 6.762C50.471 20.637 50 21.759 50 23v4h-6zm7 12a2.991 2.991 0 0 1-1.481 2.577A4.978 4.978 0 0 1 48 13c0-2.757 2.243-5 5-5s5 2.243 5 5-2.243 5-5 5c-.584 0-1.136-.12-1.657-.304A4.991 4.991 0 0 0 53 14zm-9 15h9a1 1 0 0 0 1-1v-5c0-1.654 1.346-3 3-3h7v18.586l-5.279-5.279C57.507 32.423 58 31.273 58 30v-4h-2v4c0 1.654-1.346 3-3 3H42zm2 33V35h9a4.94 4.94 0 0 0 2.105-.481L62 41.414V62z"
                                                                    fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                                <path d="M24 22h2v2h-2z" fill="#000000" opacity="1"
                                                                    data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <p class="mb-0" style="color: var(--site-green)">
                                                        Delivered
                                                    </p>
                                                    <small>30 Aug 2024</small>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Track Status End --}}
                                    </div>
                                </div>
                            </div>
                            {{-- Order Track List --}}
                            <div class="col-lg-12">
                                <div class="card w-50 mx-auto">
                                    <div class="card-body text-center pt-5">
                                        <h4>Current Status</h4>
                                        <h3 class="text-info">Order Shipped</h3>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="50"
                                                    height="50" x="0" y="0" viewBox="0 0 100 100"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="M95.5 68c-.7.4-1.4.8-2.1 1.3-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-.8-.5-1.6-1-2.5-1.5l12.4-23c.2-.3.2-.7 0-1s-.5-.5-.9-.5H78.7c-.3 0-.5.1-.7.3L75.6 46h-7.7v-5.5c0-3-2.5-5.5-5.5-5.5v-4.3c0-.6-.4-1-1-1h-6.1v-8.8c0-.6-.4-1-1-1h-7.8c-.6 0-1 .4-1 1V35H36c-3 0-5.5 2.5-5.5 5.5v4.4h-5.1c-3 0-5.5 2.5-5.5 5.5v1H6.6c-.4 0-.7.2-.9.5s-.1.7.1 1L16.2 68c-.6.3-1.2.7-1.8 1.1-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-.4-.3-.8-.5-1.2-.7-.5-.3-1.1-.1-1.4.3-.3.5-.1 1.1.3 1.4.4.2.7.5 1.1.7 1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c.6-.4 1.2-.8 1.9-1.1.5-.3.7-.9.4-1.3s-.9-.6-1.4-.4zM60.3 31.8V35h-5.1v-3.3h5.1zm-12.9-9.9h5.8V35h-5.8zM21.8 50.5c0-1.9 1.6-3.5 3.5-3.5h28.9c.6 0 1-.4 1-1s-.4-1-1-1H32.5v-4.4c0-1.9 1.6-3.5 3.5-3.5H62.3c1.9 0 3.5 1.6 3.5 3.5V46h-2.3c-.3 0-.5.1-.7.3l-5.1 5.1H21.8zm51.9 18.8c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1-.7 0-1.3.1-1.8.3l-9.5-14h49.6c.3 0 .5-.1.7-.3L64 48h12c.3 0 .5-.1.7-.3l2.4-2.4h13L80.3 67.2c-.3-.1-.7-.1-1.1-.1-2.3 0-4 1.2-5.5 2.2zM79.2 74.1c-2.3 0-4 1.1-5.5 2.1-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8s-3-.9-4.4-1.8c-1.5-1-3.2-2.1-5.5-2.1s-4 1.1-5.5 2.1c-1.4.9-2.7 1.8-4.4 1.8-.6 0-1 .4-1 1s.4 1 1 1c2.3 0 4-1.1 5.5-2.1 1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8s3 .9 4.4 1.8c1.5 1 3.2 2.1 5.5 2.1s4-1.1 5.5-2.1c1.4-.9 2.7-1.8 4.4-1.8.6 0 1-.4 1-1s-.4-1-1-1z"
                                                            fill="#000000" opacity="1" data-original="#000000"
                                                            class=""></path>
                                                        <circle cx="22.6" cy="60.3" r="2.3" fill="#000000"
                                                            opacity="1" data-original="#000000" class="">
                                                        </circle>
                                                        <circle cx="33.9" cy="60.3" r="2.3" fill="#000000"
                                                            opacity="1" data-original="#000000" class="">
                                                        </circle>
                                                        <circle cx="45.2" cy="60.3" r="2.3" fill="#000000"
                                                            opacity="1" data-original="#000000" class="">
                                                        </circle>
                                                        <circle cx="56.6" cy="60.3" r="2.3" fill="#000000"
                                                            opacity="1" data-original="#000000" class="">
                                                        </circle>
                                                        <path
                                                            d="M82.5 53.6c0-.6-.4-1-1-1s-1 .4-1 1c0 .7-.6 1.3-1.3 1.3s-1.2-.6-1.2-1.3c0-.6-.4-1-1-1s-1 .4-1 1c0 1.8 1.5 3.3 3.3 3.3s3.2-1.5 3.2-3.3z"
                                                            fill="#000000" opacity="1" data-original="#000000"
                                                            class=""></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="text-left pl-3">
                                                25 Aug 2024 <br>
                                                <span>#56Prod</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script></script>
    @endpush
</x-frontend-app-layout>
