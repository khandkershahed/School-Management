<x-frontend-app-layout :title="'Your Wishlist'">
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
    <div class="ps-wishlist">
        <div class="user-dashboard py-8">
            <div class="container">
                <div class="row g-3 g-xl-4 tab-wrap">
                    <div class="col-lg-4 col-xl-3 sticky">
                        <!-- Sidebar here -->
                        @include('user.layouts.sidebar')
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        <h3 class="ps-wishlist__title">My wishlist</h3>
                        <div class="ps-wishlist__content">
                            <ul class="ps-wishlist__list">
                                @foreach ($wishlists as $wishlist)
                                    <li>
                                        <div class="ps-product ps-product--wishlist">
                                            <div class="ps-product__remove"><a href="#"><i
                                                        class="icon-cross"></i></a>
                                            </div>
                                            <div class="ps-product__thumbnail"><a class="ps-product__image"
                                                    href="{{ route('product.details', $wishlist->product->slug) }}">
                                                    <figure>
                                                        <img src="{{ asset('storage/' . $wishlist->product->thumbnail) }}"
                                                            alt="alt">
                                                    </figure>
                                                </a></div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title">
                                                    <a href="{{ route('product.details', $wishlist->product->slug) }}">
                                                        {{ $wishlist->product->name }}
                                                    </a>
                                                </h5>
                                                @if (!empty($wishlist->product->box_discount_price))
                                                    <div class="ps-product__row">
                                                        <div class="ps-product__label">Price:</div>
                                                        <div class="ps-product__value">
                                                            <span
                                                                class="ps-product__price sale">£{{ $wishlist->product->box_discount_price }}</span>
                                                            <span
                                                                class="ps-product__del">£{{ $wishlist->product->box_price }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="ps-product__row">
                                                        <div class="ps-product__label">Price:</div>
                                                        <div class="ps-product__value">
                                                            <span
                                                                class="ps-product__price sale">£{{ $wishlist->product->box_price }}
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="ps-product__row ps-product__stock">
                                                    <div class="ps-product__label">Stock:</div>
                                                    <div class="ps-product__value"><span
                                                            class="ps-product__out-stock">Out
                                                            of stock </span>
                                                    </div>
                                                </div>
                                                <div class="ps-product__cart">
                                                    <a href="{{ route('cart.store', $wishlist->product->id) }}"
                                                        class="btn ps-btn--warning add_to_cart"
                                                        data-product_id="{{ $wishlist->product->id }}"
                                                        data-product_qty="1">Add To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="ps-wishlist__table">
                                <div class="table-responsive">
                                    <table class="table table-striped order-history-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">Sl</th>
                                                <th width="10%">Image</th>
                                                <th width="30%">Product Name</th>
                                                <th width="20%">Unit price</th>
                                                <th width="15%">Stock</th>
                                                <th width="15%">Add Cart</th>
                                                <th width="5%">
                                                    <i class="fa fa-trash" title="Delete quick order"></i>
                                                </th>
                                            </tr>
                                        <tbody>
                                            @foreach ($wishlists as $wishlist)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a class="ps-product__image"
                                                            href="{{ route('product.details', $wishlist->product->slug) }}">
                                                            <img src="{{ asset('storage/' . $wishlist->product->thumbnail) }}"
                                                                alt="alt">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('product.details', $wishlist->product->slug) }}">
                                                            {{ $wishlist->product->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if (!empty($wishlist->product->box_discount_price))
                                                            <div class="ps-product__row">
                                                                <div class="ps-product__value">
                                                                    <span
                                                                        class="ps-product__price sale">£{{ $wishlist->product->box_discount_price }}</span>
                                                                    <span
                                                                        class="ps-product__del">£{{ $wishlist->product->box_price }}</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="ps-product__row">
                                                                <div class="ps-product__value">
                                                                    <span
                                                                        class="ps-product__price sale">£{{ $wishlist->product->box_price }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        {{-- <span
                                                                class="ps-product__price">{{ $wishlist->product->box_price }}</span> --}}
                                                    </td>
                                                    <td class="ps-product__status"> <span>In Stock</span>
                                                    </td>
                                                    <td class="ps-product__cart">
                                                        <a href="{{ route('cart.store', $wishlist->product->id) }}"
                                                            class="btn ps-btn--warning add_to_cart"
                                                            data-product_id="{{ $wishlist->product->id }}"
                                                            data-product_qty="1">Add To Cart</a>
                                                    </td>
                                                    <td>
                                                        <a class="delete" href="{{ route('wishlist.destroy',$wishlist->id) }}">
                                                            <i class="icon-cross"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="ps-wishlist__share">
                                <label>Share on:</label>
                                <ul class="ps-social ps-social--color">
                                    <li><a class="ps-social__link facebook" href="#"><i class="fa fa-facebook">
                                            </i><span class="ps-tooltip">Facebook</span></a></li>
                                    <li><a class="ps-social__link twitter" href="#"><i
                                                class="fa fa-twitter"></i><span class="ps-tooltip">Twitter</span></a>
                                    </li>
                                    <li><a class="ps-social__link pinterest" href="#"><i
                                                class="fa fa-pinterest-p"></i><span
                                                class="ps-tooltip">Pinterest</span></a></li>
                                    <li class="ps-social__linkedin"><a class="ps-social__link linkedin"
                                            href="#"><i class="fa fa-linkedin"></i><span
                                                class="ps-tooltip">Linkedin</span></a></li>
                                    <li class="ps-social__reddit"><a class="ps-social__link reddit-alien"
                                            href="#"><i class="fa fa-reddit-alien"></i><span
                                                class="ps-tooltip">Reddit Alien</span></a></li>
                                    <li class="ps-social__email"><a class="ps-social__link envelope"
                                            href="#"><i class="fa fa-envelope-o"></i><span
                                                class="ps-tooltip">Email</span></a></li>
                                    <li class="ps-social__whatsapp"><a class="ps-social__link whatsapp"
                                            href="#"><i class="fa fa-whatsapp"></i><span
                                                class="ps-tooltip">WhatsApp</span></a></li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-app-layout>
