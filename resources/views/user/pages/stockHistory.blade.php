<x-frontend-app-layout :title="'Stock History'">
    <style>
        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #ffffff;
            background-color: #029f9a;
            border-color: #dee2e6 #dee2e6 #fff;
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
                    <div class="col-lg-3 col-xl-3 sticky">
                        <!-- Sidebar here -->
                        @include('user.layouts.sidebar')
                    </div>
                    <div class="col-lg-9 col-xl-9">
                        <div class="row g-5 bg-light p-3">
                            <div class="col-lg-3 pl-0">
                                <div class="shadow-sm">
                                    <p class="pt-2 pl-3">Product Category</p>
                                    <nav>
                                        <div class="nav nav-tabs flex-column border-0" id="nav-tab" role="tablist">
                                            @foreach ($categories as $category)
                                                <a class="nav-item nav-link {{ $loop->first ? 'active' : '' }}"
                                                    id="homewares-{{ $category->id }}-tab" data-toggle="tab"
                                                    href="#homewares-{{ $category->id }}" role="tab"
                                                    aria-controls="homewares-{{ $category->id }}"
                                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $category->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-lg-9 pl-0">
                                <div class="tab-content" id="nav-tabContent">
                                    @foreach ($categories as $category)
                                        @php
                                            $catProducts = $category->products()->get();
                                        @endphp
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                            id="homewares-{{ $category->id }}" role="tabpanel"
                                            aria-labelledby="nav-home-tab">
                                            <!-- Order History Table -->
                                            <h4>{{ $category->name }} Category Product Stocks</h4>

                                            <div class="table-responsive">
                                                <table class="table table-striped order-history-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">SL</th>
                                                            <th width="15%">Image</th>
                                                            <th width="40%">Name</th>
                                                            <th width="20%">Status</th>
                                                            <th width="20%">Total QTY</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Example Row -->
                                                        @foreach ($catProducts as $catProduct)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    <div>
                                                                        <img src="{{ asset('storage/' . $catProduct->thumbnail) }}"
                                                                            class="" width="50px" height="50px"
                                                                            alt="">
                                                                    </div>
                                                                </td>
                                                                <td>{{ $catProduct->name }}</td>
                                                                <td>
                                                                    @if (!empty($catProduct->box_stock) && $catProduct->box_stock > 0)
                                                                        <span class="ps-badge bg-success">
                                                                            {{ $catProduct->box_stock }} In
                                                                            Stock</span>
                                                                    @else
                                                                        <span class="ps-badge ps-badge--outstock">Out Of
                                                                            Stock</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $catProduct->box_stock }}</td>
                                                                {{-- <td>105</td> --}}
                                                            </tr>
                                                        @endforeach
                                                        <!-- Additional rows go here -->
                                                    </tbody>
                                                </table>
                                            </div>
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
