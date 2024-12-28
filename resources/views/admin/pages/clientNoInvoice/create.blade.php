<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Non Payment Invoice</h4>
                                <a href="{{ route('admin.client-invoice.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.client-invoice.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="client" class="form-label">Client</label>
                                            <x-admin.select-option id="client" name="client" :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                <option value="Walking Customer">Walking Customer</option>
                                                <option value="Ruth Miles">Ruth Miles</option>
                                                <option value=" Reed Montoya"> Reed Montoya</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <x-admin.select-option id="type" name="type" :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                <option value="Walking Customer">Walking Customer</option>
                                                <option value="Ruth Miles">Ruth Miles</option>
                                                <option value=" Reed Montoya"> Reed Montoya</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label"> Amount </x-admin.label>
                                            <x-admin.input type="text" :value="old('amount')" id="amount"
                                                name="amount" required placeholder="28836.5"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label"> Payment
                                                Date</x-admin.label>
                                            <x-admin.input type="text" :value="old('date')" id="date"
                                                name="date" required placeholder="35000"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                                placeholder="write your note here"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Save Invoice <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
