@foreach ($transactions as $i => $data)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $data->reason }}</td>
        <td>{{ $data->transaction_date ? \Carbon\Carbon::parse($data->transaction_date)->format('d M, Y') : '' }}</td>
        <td>
            <span class="badge {{ $data->type == 1 ? 'bg-success' : 'bg-danger' }}">
                {{ $data->type == 1 ? __('Credit') : __('Debit') }}
            </span>
        </td>
        <td>{{ optional($data->cashbookAccount)->bank_name . '[' . optional($data->cashbookAccount)->account_number . ']' ?? '' }}
        </td>
        <td>{{ number_format($data->amount, 2) }}</td>
        <td>
            <span class="badge {{ $data->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                {{ $data->status == 'active' ? __('Active') : __('In Active') }}
            </span>
        </td>
        <td class="text-center">{{ $data->user->name ?? '' }}</td>
    </tr>
@endforeach

@if ($transactions->isEmpty())
    <tr>
        <td colspan="8">{{ __('No Data') }}</td>
    </tr>
@endif
