@extends('pdf')

@section('content-area')
    <h3>@lang('All expense sub categories')</h3>
    <div class="table-responsive">
        <table class="table-listing table table-bordered table-striped table-sm">
            <thead class="thead-light">
                <tr>
                    <th>@lang('#')</th>
                    <th>Category</th>
                    <th>@lang('Code')</th>
                    <th>@lang('Name')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Created Date')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $key => $category)
                {{-- @dd($category) --}}
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>
                            {{ $category['expense_category']['name'] }}<br />
                            [{{ $category['expense_category']['code'] }}]
                        </td>
                        <td>{{ $category['code'] }}</td>
                        <td>{{ $category['name'] }}</td>
                        <td>
                            @if ($category['status'])
                                @lang('Active')
                            @else
                                @lang('Inactive')
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($category['created_at'])->format('d-M-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
