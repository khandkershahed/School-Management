<x-frontend-app-layout :title="'View Catalouge'">
    <style>
        .catalouge-container {
            position: relative;
            margin: 0 auto;
            padding: 1em 0 4em;
            max-width: 1000px;
            list-style: none;
            text-align: center;
        }

        /* Common style */
        .catalouge-container figure {
            position: relative;
            float: left;
            overflow: hidden;
            margin: 10px 1%;
            height: 380px;
            background: #3085a3;
            text-align: center;
            cursor: pointer;
        }

        .catalouge-container figure img {
            position: relative;
            display: block;
            min-height: 100%;
            max-width: 100%;
            opacity: 0.8;
            object-fit: cover;
        }

        .catalouge-container figure figcaption {
            padding: 2em;
            color: #fff;
            text-transform: uppercase;
            font-size: 1.25em;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .catalouge-container figure figcaption::before,
        .catalouge-container figure figcaption::after {
            pointer-events: none;
        }

        .catalouge-container figure figcaption,
        .catalouge-container figure figcaption>a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Anchor will cover the whole item by default */
        /* For some effects it will show as a button */
        .catalouge-container figure figcaption>a {
            z-index: 1000;
            text-indent: 200%;
            white-space: nowrap;
            font-size: 0;
            opacity: 0;
        }

        .catalouge-container figure h3 {
            word-spacing: -0.15em;
            font-weight: 300;
        }

        .catalouge-container figure h3 span {
            font-weight: 800;
        }

        .catalouge-container figure h3,
        .catalouge-container figure p {
            margin: 0;
        }

        .catalouge-container figure p {
            letter-spacing: 1px;
            font-size: 68.5%;
        }

        /*---------------*/
        /***** Sadie *****/
        /*---------------*/

        figure.catalouge-box figcaption::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: -webkit-linear-gradient(top, rgba(72, 76, 97, 0) 0%, rgba(72, 76, 97, 0.8) 75%);
            background: linear-gradient(to bottom, rgba(72, 76, 97, 0) 0%, rgba(72, 76, 97, 0.8) 75%);
            content: '';
            opacity: 0;
            -webkit-transform: translate3d(0, 50%, 0);
            transform: translate3d(0, 50%, 0);
        }

        figure.catalouge-box h3 {
            position: absolute;
            top: 50%;
            left: 0;
            background: #ffffff80;
            width: 100%;
            color: #484c61;
            -webkit-transition: -webkit-transform 0.35s, color 0.35s;
            transition: transform 0.35s, color 0.35s;
            -webkit-transform: translate3d(0, -50%, 0);
            transform: translate3d(0, -50%, 0);
        }

        figure.catalouge-box figcaption::before,
        figure.catalouge-box p {
            -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
            transition: opacity 0.35s, transform 0.35s;
        }

        figure.catalouge-box p {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 2em;
            width: 100%;
            opacity: 0;
            -webkit-transform: translate3d(0, 10px, 0);
            transform: translate3d(0, 10px, 0);
        }

        figure.catalouge-box:hover h3 {
            color: #fff;
            -webkit-transform: translate3d(0, -50%, 0) translate3d(0, -40px, 0);
            transform: translate3d(0, -50%, 0) translate3d(0, -40px, 0);
        }

        figure.catalouge-box:hover figcaption::before,
        figure.catalouge-box:hover p {
            opacity: 1;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }

        @media screen and (max-width: 50em) {
            .content {
                padding: 0 10px;
                text-align: center;
            }

            .catalouge-container figure {
                display: inline-block;
                float: none;
                margin: 10px auto;
                width: 100%;
            }
        }

        .clearfix:before,
        .clearfix:after {
            display: table;
            content: '';
        }

        .clearfix:after {
            clear: both;
        }

        .content {
            margin: 0 auto;
            max-width: 1000px;
        }

        .content>h3 {
            clear: both;
            margin: 0;
            padding: 4em 1% 0;
            color: #484B54;
            font-weight: 800;
            font-size: 1.5em;
        }

        .content>h3:first-child {
            padding-top: 0em;
        }

        @media screen and (max-width: 25em) {
            .codrops-header {
                font-size: 75%;
            }

            .codrops-icon span {
                display: none;
            }
        }
    </style>
    <div class="breadcrumb-wrap">
        <div class="banner b-top bg-size bread-img">
            <img class="bg-img bg-top" src="img/banner-p.jpg" alt="banner" style="display: none;">
            <div class="container-lg">
                <div class="breadcrumb-box">
                    <div class="title-box3 text-center">
                        <h1>
                            Catalogue Library
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

                        <div class="content">
                            <h4>Please View / Download our latest catalogues by clicking on a catalogue below.</h4>
                            <div class="catalouge-container row">
                                @foreach ($catalogues as $catalogue)
                                    <div class="col-lg-4">
                                        @php
                                            $thumbnailPath = 'storage/' . $catalogue->image;
                                            $thumbnailSrc = !empty($catalogue->image) && file_exists(public_path($thumbnailPath))
                                                    ? asset($thumbnailPath)
                                                    : asset('images/no_image.jpg');

                                        @endphp
                                        <figure class="catalouge-box">
                                            <img src="{{ $thumbnailSrc }}" alt="img02" />
                                            <figcaption>
                                                <h3 class="p-4">{{ $catalogue->title }}</h3>
                                                @if (!empty($catalogue->attachment) && file_exists(public_path('storage/' . $catalogue->attachment)))
                                                    <p>
                                                        <a href="{{ asset('storage/' . $catalogue->attachment) }}">
                                                            Download
                                                        </a>
                                                    </p>
                                                @endif
                                            </figcaption>
                                        </figure>
                                        <p class="fw-bold">{{ $catalogue->title }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
</x-frontend-app-layout>
