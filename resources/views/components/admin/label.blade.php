{{-- <label class="{{ $class ?? 'col-lg-4 col-form-label required fw-bold fs-6' }}"
    for="{{ $for ?? '' }}">{{ $slot }}
</label> --}}

<label for="{{ $for ?? '' }}" class="{{ $class ?? 'form-label' }}">{{ $slot }}</label>
{{-- <x-admin.label for="full_name" class="col-lg-4 col-form-label required fw-bold fs-6">Name</x-admin.label> --}}
