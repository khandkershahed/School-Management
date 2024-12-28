<x-admin-app-layout :title="'Accounts List'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Assets</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    {{-- <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Export To Excel">
                                        <i class="fa-solid fa-file-csv"></i>
                                    </button> --}}
                                    <a href="{{ route('admin.assets.pdf') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Download PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Print Table">
                                        <i class="fa-solid fa-print"></i>
                                        <span class="tooltiptext">Print</span>
                                    </button>
                                    <a href="{{ route('admin.assets.create') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            {{-- <div class="d-flex justify-content-between align-items-center mb-3 bg-light p-3">
                                <h6>Filter Assets (From-To)</h6>
                                <div>
                                    <input class="form-control" name='range' id='cal' />
                                </div>
                            </div> --}}
                            <div class="table-responsive p-3 pt-1">
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">Sl</th>
                                            {{-- <th width="5%" class="text-center">Image</th> --}}
                                            <th width="20%" class="text-center">Asset Name</th>
                                            <th width="15%" class="text-center">Asset Type</th>
                                            <th width="15%" class="text-center">Asset Cost</th>
                                            <th width="15%" class="text-center">Current Value</th>
                                            <th width="10%" class="text-center">Created At</th>
                                            <th width="5%" class="text-center">Status</th>
                                            <th width="10%" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assets as $asset)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                {{-- <td class="text-center">
                                                    <div>
                                                        <img width="50px" src="{{ asset('images/no_image.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </td> --}}
                                                <td class="text-center">{{ $asset->name }}</td>
                                                <td class="text-center">{{ $asset->assetType->name }}</td>
                                                <td class="text-center">{{ $asset->asset_cost }}</td>
                                                <td class="text-center">{{ $asset->currentValue() }}</td>
                                                <td class="text-center">{{ optional($asset->date) ? \Carbon\Carbon::parse($asset->date)->format('jS M, Y') : '' }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $asset->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $asset->status == 'active' ? 'Active' : 'InActive' }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.assets.edit' , $asset->slug) }}" class="btn btn-sm btn-primary toltip"
                                                        data-tooltip="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    {{-- <a href="javascript:void(0)"
                                                        class="btn btn-sm btn-warning text-white toltip"
                                                        data-tooltip="View">
                                                        <i class="fa-solid fa-expand"></i>
                                                    </a> --}}
                                                    <a href="{{ route('admin.assets.destroy' , $asset->slug) }}" class="btn btn-sm btn-danger toltip"
                                                        data-tooltip="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // Multi Select Date Picker
            var dates = [];
            $(document).ready(function() {
                $("#cal").daterangepicker();
                $("#cal").on("apply.daterangepicker", function(e, picker) {
                    e.preventDefault();
                    const obj = {
                        key: dates.length + 1,
                        start: picker.startDate.format("MM/DD/YYYY"),
                        end: picker.endDate.format("MM/DD/YYYY"),
                    };
                    dates.push(obj);
                    showDates();
                });
                $(".remove").on("click", function() {
                    removeDate($(this).attr("key"));
                });
            });

            function showDates() {
                $("#ranges").html("");
                $.each(dates, function() {
                    const el =
                        "<li>" +
                        this.start +
                        "-" +
                        this.end +
                        "<button class='remove' onClick='removeDate(" +
                        this.key +
                        ")'>-</button></li>";
                    $("#ranges").append(el);
                });
            }

            function removeDate(i) {
                dates = dates.filter(function(o) {
                    return o.key !== i;
                });
                showDates();
            }
        </script>
    @endpush
</x-admin-app-layout>
