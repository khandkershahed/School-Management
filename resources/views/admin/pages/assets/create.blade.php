<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Assets</h4>
                                <a href="{{ route('admin.assets.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.assets.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Asset Name <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name"
                                                name="name" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="assetType" class="form-label">Asset Type <span class="text-danger">*</span></label>
                                            <x-admin.select-option id="assetType" name="assetType" :allowClear="true">
                                                @foreach ($asset_types as $asset_type)
                                                    <option value="{{ $asset_type->id }}">{{ $asset_type->name }}
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="assetCost" class="form-label">Asset Cost <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="number" :value="old('assetCost')" id="assetCost"
                                                name="assetCost" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="depreciation" class="form-label">Depreciation <span class="text-danger">*</span></label>
                                            <x-admin.select-option id="depreciation" name="depreciation"
                                                :allowClear="true">
                                                <option value="1" @selected(old('depreciation') == '1')>Yes</option>
                                                <option value="0" @selected(old('depreciation') == '0')>No</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div id="depreciationDetails" class="col-12" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 mb-3 col-6">
                                                <x-admin.label for="depreciationType" class="form-label">Depreciation
                                                    Type <span class="text-danger">*</span></x-admin.label>
                                                <x-admin.select-option id="depreciationType" name="depreciationType"
                                                    :allowClear="true">
                                                    <option value="Month"
                                                        {{ old('depreciationType') == 'Month' ? 'selected' : '' }}>
                                                        Monthly</option>
                                                    <option value="Year"
                                                        {{ old('depreciationType') == 'Year' ? 'selected' : '' }}>Yearly
                                                    </option>
                                                </x-admin.select-option>
                                            </div>
                                            <div class="col-lg-3 col-md-3 mb-3 col-6">
                                                <x-admin.label for="salvageValue" class="form-label">Salvage
                                                    Value <span class="text-danger">*</span></x-admin.label>
                                                <x-admin.input type="number" :value="old('salvageValue')" id="salvageValue"
                                                    name="salvageValue" required></x-admin.input>
                                            </div>
                                            <div class="col-lg-3 col-md-3 mb-3 col-6">
                                                <x-admin.label for="usefulLife" class="form-label">Useful
                                                    Life <span class="text-danger">*</span></x-admin.label>
                                                <input class="form-control form-control-solid" type="number"
                                                    step="0.01" value="{{ old('usefulLife') }}" id="usefulLife"
                                                    name="usefulLife" required
                                                    oninput="calculateDepreciationExpense()" />
                                                @error('usefulLife')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-3 col-md-3 mb-3 col-6">
                                                <x-admin.label for="depreciationExpense"
                                                    class="form-label">Depreciation</x-admin.label>
                                                <input class="form-control form-control-solid" type="text"
                                                    :value="old('depreciationExpense')" id="depreciationExpense"
                                                    name="depreciationExpense" readonly></input>
                                                @error('depreciationExpense')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label">Date <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="date" :value="old('date')" id="date"
                                                name="date" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="mb-3">
                                            <x-admin.label for="status" class="form-label">Status</x-admin.label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active"
                                                    {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive"
                                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label">Image</x-admin.label>
                                            <x-admin.file-input type="file" :value="old('image')" id="image"
                                                name="image" required></x-admin.file-input>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label">Note</x-admin.label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                                placeholder="Write your note here">{{ old('note') }}</textarea>
                                            @error('note')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Save Assets <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Show or hide depreciation details based on selection
                $('#depreciation').change(function() {
                    if ($(this).val() == '1') {
                        $('#depreciationDetails').show();
                    } else {
                        $('#depreciationDetails').hide();
                        $('#salvageValue').val('');
                        $('#usefulLife').val('');
                        $('#depreciationExpense').val('');
                    }
                });

                // Calculate depreciation expense on input change
                function calculateDepreciationExpense() {
                    var assetCost = parseFloat($('#assetCost').val());
                    var usefulLife = parseFloat($('#usefulLife').val());
                    var salvageValue = parseFloat($('#salvageValue').val());
                    var depreciationType = $('#depreciationType').val();
                    var depreciation = $('#depreciation').val(); // Get selected value directly

                    if (depreciation === '1' && !isNaN(assetCost) && !isNaN(usefulLife) && !isNaN(salvageValue)) {
                        var depreciationExpense = (assetCost - salvageValue) / usefulLife;
                        $('#depreciationExpense').val(Number(depreciationExpense.toFixed(2)) + ' Per ' +
                            depreciationType);
                    } else {
                        $('#depreciationExpense').val(''); // Clear if conditions are not met
                    }
                }

                // Bind the input event to relevant fields
                $('#assetCost, #salvageValue, #usefulLife').on('input', calculateDepreciationExpense);

                // Optionally trigger the change event on page load to set the initial state
                $('#depreciation').trigger('change');
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#depreciation').change(function() {
                    if ($(this).val() == '1') {
                        $('#depreciationDetails').show();
                    } else {
                        $('#depreciationDetails').hide();
                    }
                });

                // Optionally trigger the change event on page load
                $('#depreciation').trigger('change');
            });
        </script>
    @endpush
</x-admin-app-layout>
