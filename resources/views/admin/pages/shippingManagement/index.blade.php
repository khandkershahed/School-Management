<x-admin-app-layout :title="'Shipping Methods'">
    <div class="card card-flush mt-10">
        <div class="card-header bg-primary align-items-center">
            <h3 class="card-title text-white">Manage Your Shipping</h3>
            <div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-white btn btn-sm" data-bs-toggle="modal"
                    data-bs-target="#shipping_methodsAdd">
                    <i class="fa-solid fa-plus"></i> Create
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table my-datatable table-striped table-row-bordered gy-5 gs-7 border rounded">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                        <th>ID</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Duration</th>
                        <th>Min Weight</th>
                        <th>Max Weight</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipping_methods as $method)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $method->title }}</td>
                            <td>{{ $method->location }}</td>
                            <td>{{ $method->duration }}</td>
                            <td>{{ $method->min_weight }}</td>
                            <td>{{ $method->max_weight }}</td>
                            <td>£{{ $method->price }}</td>
                            <td><span class="badge {{ $method->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $method->status == 'active' ? 'Active' : 'InActive' }}</span></td>
                            <td class="text-start">
                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                    data-bs-toggle="modal" data-bs-target="#shipping_methodsEdit_{{ $method->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.shipping-management.destroy',$method->id) }}"
                                    class="btn btn-icon btn-bg-light-danger btn-active-color-danger btn-sm me-1 delete"
                                    data-kt-docs-table-filter="delete_row">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Shippng Create Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="shipping_methodsAdd" tabindex="-1" aria-labelledby="shipping_methodsAddLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shipping_methodsAddLabel">Shipping Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.shipping-management.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body pt-0 row">
                                <div class="mb-5 fv-row col-12">
                                    <x-admin.label class="form-label">Title</x-admin.label>
                                    <x-admin.input type="text" name="title" class="form-control mb-2"
                                        placeholder="Enter title" :value="old('title')">
                                    </x-admin.input>
                                    <div class="text-muted fs-7">
                                        A unique title for the shipping method.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row col-6">
                                    <x-admin.label class="form-label">Location</x-admin.label>
                                    <x-admin.input type="text" name="location" class="form-control mb-2"
                                        placeholder="Enter location" :value="old('location')">
                                    </x-admin.input>
                                    <div class="text-muted">
                                        Location shipping method.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row w-50 col-6">
                                    <x-admin.label class="form-label">Duration</x-admin.label>
                                    <x-admin.input type="text" name="duration" class="form-control mb-2"
                                        placeholder="Enter duration" :value="old('duration')">
                                    </x-admin.input>
                                    <div class="text-muted fs-7">
                                        Estimated delivery time.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row">
                                    <x-admin.label class="form-label">Description</x-admin.label>
                                    <textarea name="description" class="ckeditor form-control mb-2" placeholder="Add detailed description">{!! old('description') !!}</textarea>
                                    <div class="text-muted fs-7">
                                        Detailed description of the shipping method.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row col-4">
                                    <x-admin.label class="form-label">Carrier</x-admin.label>
                                    <x-admin.input type="text" name="carrier" class="form-control mb-2"
                                        placeholder="Enter carrier name" :value="old('carrier')">
                                    </x-admin.input>
                                    <div class="text-muted fs-7">
                                        The carrier or service provider for the shipping method.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row col-4">
                                    <x-admin.label class="form-label">Min Weight</x-admin.label>
                                    <x-admin.input type="number" name="min_weight" class="form-control mb-2"
                                        placeholder="Enter minimum weight" :value="old('min_weight')">
                                    </x-admin.input>
                                    <div class="text-muted fs-7">
                                        Minimum weight for the shipping method.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row col-4">
                                    <x-admin.label class="form-label">Max Weight</x-admin.label>
                                    <x-admin.input type="number" name="max_weight" class="form-control mb-2"
                                        placeholder="Enter maximum weight" :value="old('max_weight')">
                                    </x-admin.input>
                                    <div class="text-muted fs-7">
                                        Maximum weight for the shipping method.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row col-6">
                                    <x-admin.label class="form-label">Price</x-admin.label>
                                    <x-admin.input type="number" name="price" class="form-control mb-2"
                                        placeholder="Enter price" :value="old('price')">
                                    </x-admin.input>
                                    <div class="text-muted fs-7">
                                        Cost associated with the shipping method.
                                    </div>
                                </div>
                                <div class="mb-5 fv-row col-6">
                                    <x-admin.label class="form-label">Status</x-admin.label>
                                    <select class="form-select" name="status" data-control="select2"
                                        data-hide-search="true" data-allow-clear="true"
                                        data-placeholder="Select status">
                                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <div class="text-muted fs-7">
                                        Status of the shipping method (Active/Inactive).
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-white" data-bs-dismiss="modal">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($shipping_methods as $method)
        <div class="modal fade" id="shipping_methodsEdit_{{ $method->id }}" tabindex="-1" aria-labelledby="shipping_methodsEditLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shipping_methodsEditLabel">Shipping Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.shipping-management.update',$method->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body pt-0 row">
                                    <div class="mb-5 fv-row col-12">
                                        <x-admin.label class="form-label">Title</x-admin.label>
                                        <x-admin.input type="text" name="title" class="form-control mb-2"
                                            placeholder="Enter title" :value="old('title',$method->title)">
                                        </x-admin.input>
                                        <div class="text-muted fs-7">
                                            A unique title for the shipping method.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row col-6">
                                        <x-admin.label class="form-label">Location</x-admin.label>
                                        <x-admin.input type="text" name="location" class="form-control mb-2"
                                            placeholder="Enter location" :value="old('location',$method->location)">
                                        </x-admin.input>
                                        <div class="text-muted">
                                            Location shipping method.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row w-50 col-6">
                                        <x-admin.label class="form-label">Duration</x-admin.label>
                                        <x-admin.input type="text" name="duration" class="form-control mb-2"
                                            placeholder="Enter duration" :value="old('duration',$method->duration)">
                                        </x-admin.input>
                                        <div class="text-muted fs-7">
                                            Estimated delivery time.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row">
                                        <x-admin.label class="form-label">Description</x-admin.label>
                                        <textarea name="description" class="ckeditor form-control mb-2" placeholder="Add detailed description">{!! old('description',$method->description) !!}</textarea>
                                        <div class="text-muted fs-7">
                                            Detailed description of the shipping method.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row col-4">
                                        <x-admin.label class="form-label">Carrier</x-admin.label>
                                        <x-admin.input type="text" name="carrier" class="form-control mb-2"
                                            placeholder="Enter carrier name" :value="old('carrier',$method->carrier)">
                                        </x-admin.input>
                                        <div class="text-muted fs-7">
                                            The carrier or service provider for the shipping method.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row col-4">
                                        <x-admin.label class="form-label">Min Weight</x-admin.label>
                                        <x-admin.input type="number" name="min_weight" class="form-control mb-2"
                                            placeholder="Enter minimum weight" :value="old('min_weight',$method->min_weight)">
                                        </x-admin.input>
                                        <div class="text-muted fs-7">
                                            Minimum weight for the shipping method.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row col-4">
                                        <x-admin.label class="form-label">Max Weight</x-admin.label>
                                        <x-admin.input type="number" name="max_weight" class="form-control mb-2"
                                            placeholder="Enter maximum weight" :value="old('max_weight',$method->max_weight)">
                                        </x-admin.input>
                                        <div class="text-muted fs-7">
                                            Maximum weight for the shipping method.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row col-6">
                                        <x-admin.label class="form-label">Price</x-admin.label>
                                        <x-admin.input type="number" name="price" class="form-control mb-2"
                                            placeholder="Enter price" :value="old('price',$method->price)">
                                        </x-admin.input>
                                        <div class="text-muted fs-7">
                                            Cost associated with the shipping method.
                                        </div>
                                    </div>
                                    <div class="mb-5 fv-row col-6">
                                        <x-admin.label class="form-label">Status</x-admin.label>
                                        <select class="form-select" name="status" data-control="select2"
                                            data-hide-search="true" data-allow-clear="true"
                                            data-placeholder="Select status">
                                            <option value="active" {{ old('status',$method->status) === 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive" {{ old('status',$method->status) === 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        <div class="text-muted fs-7">
                                            Status of the shipping method (Active/Inactive).
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-white" data-bs-dismiss="modal">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- Shippng Create Modal ENd --}}
    @push('scripts')
        <script>
            // Define form element
            const form = document.getElementById('kt_docs_formvalidation_text');

            // Init form validation rules
            var validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'title': {
                            validators: {
                                notEmpty: {
                                    message: 'Title is required'
                                }
                            }
                        },
                        'zone': {
                            validators: {
                                notEmpty: {
                                    message: 'Zone is required'
                                }
                            }
                        },
                        'cost': {
                            validators: {
                                notEmpty: {
                                    message: 'Cost is required'
                                },
                                numeric: {
                                    message: 'Cost must be a number'
                                }
                            }
                        },
                        'status': {
                            validators: {
                                notEmpty: {
                                    message: 'Status is required'
                                }
                            }
                        }
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Handle modal data population
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const zone = this.getAttribute('data-zone');
                    const cost = this.getAttribute('data-cost');
                    const status = this.getAttribute('data-status');

                    const form = document.getElementById('kt_docs_formvalidation_text');
                    form.querySelector('input[name="title"]').value = title;
                    form.querySelector('input[name="zone"]').value = zone;
                    form.querySelector('input[name="cost"]').value = cost;
                    form.querySelector('select[name="status"]').value = status;
                });
            });

            // Submit button handler
            const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                if (validator) {
                    validator.validate().then(function(status) {
                        console.log('validated!');

                        if (status == 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            setTimeout(function() {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }, 2000);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-admin-app-layout>
