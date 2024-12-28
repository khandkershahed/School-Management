<div class="side-bar">
    <span class="back-side d-lg-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </span>
    <div class="profile-box">
        <div class="img-box">
            @if (Auth::user()->image)
                <img class="img-fluid" src="{{ asset('storage/' . Auth::user()->image) }}"
                    alt="{{ Auth::user()->name }}">
            @else
                <div class="symbol-label" style="background-color: #d3d3d3;">
                    <span class="text-gray-800 text-hover-primary mb-1">
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                    </span>
                </div>
            @endif

            <div class="edit-btn" data-toggle="modal" data-target="#editProfileImage">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-edit" id="openModal">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                <!-- Hidden input for updating the profile image -->
                <input class="updateimg" type="file" name="img" id="profileImageUpload" style="display: none;">
            </div>
        </div>
        <div class="user-name">
            <h5>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
            <h6 class="mb-0">{{ Auth::user()->email }}</h6>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProfileImage" tabindex="-1" role="dialog" aria-labelledby="editProfileImageLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="editImageModalLabel">Update Profile Image</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="profileImageUpload">Choose a new profile image</label>
                            <input type="file" class="form-control-file" name="profile_image" id="profileImageUploadModal"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-white">Update Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs nav-tabs2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('user.order.history') }}"
                class="nav-link {{ Route::is('user.order.history') ? 'active' : '' }}">
                My Order History
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('user.account.details') }}"
                class="nav-link {{ Route::is('user.account.details') ? 'active' : '' }}">
                My Account Details
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('user.quick.order') }}"
                class="nav-link {{ Route::is('user.quick.order') ? 'active' : '' }}">
                Quick Order
            </a>
        </li>
        {{-- <li class="nav-item" role="presentation">
            <a href="{{ route('user.order.tracking') }}"
                class="nav-link {{ Route::is('user.order.tracking') ? 'active' : '' }}">
                Track Order
            </a>
        </li> --}}
        <li class="nav-item" role="presentation">
            <a href="{{ route('user.stock.history') }}"
                class="nav-link {{ Route::is('user.stock.history') ? 'active' : '' }}">
                Stock Availability
            </a>
        </li>
        {{-- <li class="nav-item" role="presentation">
            <a href="{{ route('user.product.data') }}" class="nav-link {{ Route::is('user.product.data') ? 'active' : '' }} ">
                Product Data Download
            </a>
        </li> --}}
        <li class="nav-item" role="presentation">
            <a href="{{ route('user.view.catalouge') }}" class="nav-link {{ Route::is('user.view.catalouge') ? 'active' : '' }}">
                View Catalogue
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('user.wishlist') }}"
                class="nav-link {{ Route::is('user.wishlist') ? 'active' : '' }}">
                My Shopping List
            </a>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function() {
        // Open modal on clicking the edit button
        $('#openModal').on('click', function() {
            $('#editImageModal').modal('show');
        });

        // Trigger file input click on edit icon click
        $('#profileImageUploadModal').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(fileName);
        });
    });
</script>
