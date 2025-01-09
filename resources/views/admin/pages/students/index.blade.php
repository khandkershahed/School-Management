<x-admin-app-layout :title="'Student Lists'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Student Lists</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#excelImport" class="btn btn-outline-light toltip"
                                        data-tooltip="Import Excel">
                                        <i class="fa-solid fa-file-csv pe-2"></i> Import Excel
                                    </button>
                                    <a href="{{ route('admin.students.create') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            
                            <div class="table-responsive p-3 pt-1">
                                <!-- Table -->
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">Sl</th>
                                            <th width="15%" class="text-center">Student ID</th>
                                            <th width="15%" class="text-center">Name</th>
                                            <th width="15%" class="text-center">Medium</th>
                                            <th width="15%" class="text-center">Class</th>
                                            {{-- <th width="15%" class="text-center">Section </th> --}}
                                            <th width="15%" class="text-center">Roll </th>
                                            <th width="5%" class="text-center">Status</th>
                                            <th width="10%" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $student->student_id }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.students.show',$student->slug) }}">{{ $student->name }}</a>
                                                </td>
                                                <td class="text-center">{{ optional($student)->medium }}</td>
                                                <td class="text-center">{{ $student->class }}</td>
                                                <td class="text-center">{{ $student->roll }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $student->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $student->status == 'active' ? 'Active' : 'InActive' }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.students.edit',$student->slug) }}" class="btn btn-sm btn-primary toltip mb-2"
                                                        data-tooltip="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    {{-- <a href="{{ route('admin.students.show',$student->slug) }}"
                                                        class="btn btn-sm btn-warning text-white toltip mb-2"
                                                        data-tooltip="View">
                                                        <i class="fa-solid fa-expand"></i>
                                                    </a> --}}
                                                    <a href="{{ route('admin.students.destroy',$student->id) }}" class="btn btn-sm btn-danger toltip mb-2 delete"
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

    <div class="modal fade" id="excelImport" tabindex="-1" aria-labelledby="excelImportLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="excelImportLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.students.import') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <x-admin.label for="name" class="form-label">Select Excel File (.xlsx,.xls,.csv only): ( <a href="{{ asset('images/Demo Excel Student Import.xlsx') }}" download="" class="fw-bold">Download</a> demo format Excel)</x-admin.label>
                            <x-admin.file-input class="form-control form-control-solid" :value="old('file')"
                                id="file" name="file" required></x-admin.file-input>
                        </div>
                        <x-admin.button type="submit" class="btn btn-white float-end">Submit</x-admin.button>
                    </form>
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
