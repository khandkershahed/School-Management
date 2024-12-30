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
                    <td class="text-center">{{ optional($student->medium)->name }}</td>
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
