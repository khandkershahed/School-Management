@extends('pdf')

@section('content-area')
    <h3>@lang('Balance Adjustments')</h3>
    <div class="table-responsive">
        <table class="table-listing table table-bordered table-striped table-sm">
            <thead class="thead-light">
                <tr>
                    <th>@lang('#')</th>
                    <th>@lang('Bank Name')</th>
                    <th>@lang('Account Number')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Type')</th>
                    <th>@lang('Date')</th>
                    <th>@lang('Status')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($balances as $key => $balance)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $balance['cashbook_account']['bank_name'] }}</td>
                        <td>{{ $balance['cashbook_account']['account_number'] }}</td>
                        <td>{{ $balance['amount'] }}</td>
                        <td>
                            @if ($balance['type'] == 1)
                                <span class="badge bg-success">@lang('Add Balance') </span>
                            @else
                                <span class="badge bg-danger">@lang('Remove Balance')</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($balance['transaction_date'])->format('d-M-Y') }}</td>
                        <td>
                            @if ($balance['status'] == "active")
                                @lang('Active')
                            @else
                                @lang('Inactive')
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
