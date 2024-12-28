@foreach ($transfers as $transfer)
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td class="text-center">{{ $transfer->reason }}</td>
        <td>{{ optional($transfer->debitTransaction->cashbookAccount)->bank_name . '[' . optional($transfer->debitTransaction->cashbookAccount)->account_number . ']' ?? '' }}
        </td>
        <td>{{ optional($transfer->creditTransaction->cashbookAccount)->bank_name . '[' . optional($transfer->creditTransaction->cashbookAccount)->account_number . ']' ?? '' }}
        </td>
        <td class="text-center">{{ $transfer->amount }}</td>
        <td class="text-center">
            {{ optional($transfer->date) ? \Carbon\Carbon::parse($transfer->date)->format('jS M, Y') : '' }}
        </td>
        <td>
            <span class="badge {{ $transfer->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                {{ $transfer->status == 'active' ? 'Active' : 'InActive' }}</span>
        </td>
        <td class="text-end">
            <a href="{{ route('admin.balance-transfer.edit', $transfer->slug) }}" class="btn btn-sm btn-primary toltip"
                data-tooltip="Edit">
                <i class="fa-solid fa-pen"></i>
            </a>
            {{-- <a href="javascript:void(0)"
                        class="btn btn-sm btn-warning text-white toltip"
                        data-tooltip="View">
                        <i class="fa-solid fa-expand"></i>
                    </a> --}}
            <a href="{{ route('admin.balance-transfer.destroy', $transfer->id) }}" class="btn btn-sm btn-danger toltip"
                data-tooltip="Delete">
                <i class="fa-solid fa-trash"></i>
            </a>
        </td>
    </tr>
@endforeach
@if ($transfers->isEmpty())
    <tr>
        <td colspan="8">{{ __('No Data') }}</td>
    </tr>
@endif
