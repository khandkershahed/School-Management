@if ($isLink ?? false)
    <a href="{{ $href ?? 'JavaScript:void(0)' }}" class="btn-common-one text-white">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type ?? 'button' }}" class="btn-common-one text-white border-0"
        onclick="this.disabled = true; this.form.submit();">
        {{ $slot }}
    </button>
@endif



{{-- <x-combined-button class="success" isLink=true href="/success">
    {{ __('Success') }}
</x-combined-button>  --}}
