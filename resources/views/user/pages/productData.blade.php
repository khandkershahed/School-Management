<x-frontend-app-layout :title="'Product Data'">
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
                            Product Data
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
                        <h4>Download Image Or Data</h4>
                        <p>Please select the information you require below to download a product image or product data.
                        </p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                    role="tab" aria-controls="home" aria-selected="true">Download all Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Download Selected Products</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="pt-5">
                                            <p>Please select whether you would like to download all product images or
                                                all product data.
                                            </p>
                                            <form action="">
                                                <div class="form-check ml-0">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="exampleRadios1" value="option1" checked>
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        All Product Data
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="form-check ml-0">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="exampleRadios2" value="option2">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        All Product Images (Low Res)
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="form-check ml-0">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="exampleRadios3" value="option3">
                                                    <label class="form-check-label" for="exampleRadios3">
                                                        All Product Images (High Res)
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="pt-5">
                                                    <button type="submit" class="btn btn-sm btn-info">Download</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="pt-5">
                                            <form action="">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Product Category</label>
                                                            <input type="email" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                placeholder="Enter email">
                                                            <small id="emailHelp" class="form-text text-muted">We'll
                                                                never share
                                                                your email with anyone else.</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Product Sub
                                                                Category</label>
                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                            <small id="emailHelp" class="form-text text-muted">Add
                                                                Product Sub
                                                                Category.</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Product Sub Sub
                                                                Category</label>
                                                            <select class="form-control" name="SubSubCategory"
                                                                id="exampleFormControlSelect1">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                            <small id="emailHelp" class="form-text text-muted">Add
                                                                Product Sub
                                                                Sub Category.</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h4 class="text-center">Search Your Specific Product</h4>
                                                        <div class="bg-light p-3">
                                                            <form action="">
                                                                <label for="exampleInputEmail1">Product Search</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Recipient's username"
                                                                        aria-label="Recipient's username"
                                                                        aria-describedby="basic-addon2">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-white"
                                                                            type="button">
                                                                            <i class="fa fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="homewares" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <!-- Order History Table -->
                                        <hr class="pt-5 mt-5">
                                        <h4>All Filterd Data</h4>
                                        <table class="table table-striped order-history-table">
                                            <thead>
                                                <tr>
                                                    <th width="5%"></th>
                                                    <th width="5%">SL</th>
                                                    <th width="20%">Product Image</th>
                                                    <th width="40%">Product Title</th>
                                                    <th width="15%">SKU</th>
                                                    <th width="25%">Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Row -->
                                                <tr>
                                                    <td></td>
                                                    <td>1</td>
                                                    <td>
                                                        <div>
                                                            <img src="#" class="" width="50px"
                                                                height="50px" alt="">
                                                        </div>
                                                    </td>
                                                    <td>Thie Shoup Spoon</td>
                                                    <td>#sku354</td>
                                                    <td>
                                                        Home & Kitchen
                                                    </td>
                                                </tr>
                                                <!-- Additional rows go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="pestControl" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <!-- Order History Table -->
                                        <h4>Pest Control Category Product Stocks</h4>
                                        <table class="table table-striped order-history-table">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>SKU</th>
                                                    <th>Status</th>
                                                    <th>Total QTY</th>
                                                    <th>In Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Row -->
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <div>
                                                            <img src="#" class="" width="50px"
                                                                height="50px" alt="">
                                                        </div>
                                                    </td>
                                                    <td>Thie Shoup Spoon</td>
                                                    <td>#sku354</td>
                                                    <td>
                                                        <span class="badge bg-info text-white">Available</span>
                                                    </td>
                                                    <td>555</td>
                                                    <td>105</td>
                                                </tr>
                                                <!-- Additional rows go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="catering" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <!-- Order History Table -->
                                        <h4>Catering Category Product Stocks</h4>
                                        <table class="table table-striped order-history-table">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>SKU</th>
                                                    <th>Status</th>
                                                    <th>Total QTY</th>
                                                    <th>In Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Row -->
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <div>
                                                            <img src="#" class="" width="50px"
                                                                height="50px" alt="">
                                                        </div>
                                                    </td>
                                                    <td>Thie Shoup Spoon</td>
                                                    <td>#sku354</td>
                                                    <td>
                                                        <span class="badge bg-info text-white">Available</span>
                                                    </td>
                                                    <td>555</td>
                                                    <td>105</td>
                                                </tr>
                                                <!-- Additional rows go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="gardenLighting" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <!-- Order History Table -->
                                        <h4>Download </h4>
                                        <table class="table table-striped order-history-table">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>SKU</th>
                                                    <th>Status</th>
                                                    <th>Total QTY</th>
                                                    <th>In Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Row -->
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <div>
                                                            <img src="#" class="" width="50px"
                                                                height="50px" alt="">
                                                        </div>
                                                    </td>
                                                    <td>Thie Shoup Spoon</td>
                                                    <td>#sku354</td>
                                                    <td>
                                                        <span class="badge bg-info text-white">Available</span>
                                                    </td>
                                                    <td>555</td>
                                                    <td>105</td>
                                                </tr>
                                                <!-- Additional rows go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="games" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <!-- Order History Table -->
                                        <h4>Games Category Product Stocks</h4>
                                        <table class="table table-striped order-history-table">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>SKU</th>
                                                    <th>Status</th>
                                                    <th>Total QTY</th>
                                                    <th>In Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Row -->
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <div>
                                                            <img src="#" class="" width="50px"
                                                                height="50px" alt="">
                                                        </div>
                                                    </td>
                                                    <td>Thie Shoup Spoon</td>
                                                    <td>#sku354</td>
                                                    <td>
                                                        <span class="badge bg-info text-white">Available</span>
                                                    </td>
                                                    <td>555</td>
                                                    <td>105</td>
                                                </tr>
                                                <!-- Additional rows go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="BBQ" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <!-- Order History Table -->
                                        <h4>BBQ Category Product Stocks</h4>
                                        <table class="table table-striped order-history-table">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>SKU</th>
                                                    <th>Status</th>
                                                    <th>Total QTY</th>
                                                    <th>In Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Row -->
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <div>
                                                            <img src="#" class="" width="50px"
                                                                height="50px" alt="">
                                                        </div>
                                                    </td>
                                                    <td>Thie Shoup Spoon</td>
                                                    <td>#sku354</td>
                                                    <td>
                                                        <span class="badge bg-info text-white">Available</span>
                                                    </td>
                                                    <td>555</td>
                                                    <td>105</td>
                                                </tr>
                                                <!-- Additional rows go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-frontend-app-layout>
