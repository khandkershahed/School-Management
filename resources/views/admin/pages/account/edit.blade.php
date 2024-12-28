<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Edit An Account</h4>
                                <a href="{{ route('admin.account.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.account.update',$account->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.label for="bankName" class="form-label">Bank Name</x-admin.label>
                                            <x-admin.input type="text" :value="old('bank_name',$account->bank_name)" id="bankName"
                                                name="bank_name" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-admin.label for="branchName" class="form-label">Branch
                                                Name</x-admin.label>
                                            <x-admin.input type="text" :value="old('branch_name',$account->branch_name)" id="branchName"
                                                name="branch_name" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-admin.label for="accountNumber" class="form-label">Account
                                                Number</x-admin.label>
                                            <x-admin.input type="text" :value="old('account_number',$account->account_number)" id="accountNumber"
                                                name="account_number" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label"> Image</x-admin.label>
                                            <x-admin.file-input type="file" :source="asset('storage/'.$account->image)" :value="old('image')" id="image"
                                                name="image" required></x-admin.file-input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label"> Date</x-admin.label>
                                            <x-admin.input type="date" :value="old('date',$account->date)" id="date"
                                                name="date" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active" @selected($account->status == 'active')>Active</option>
                                                <option value="inactive" @selected($account->status == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                                placeholder="write your note here">{{ old("note",$account->note) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit">Edit Account <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
