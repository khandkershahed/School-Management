@props(['id', 'name' , 'allowClear' => false])

<select id="{{ $id }}" name="{{ $name }}"
    class="form-control select2 @error($name) is-invalid @enderror"
    data-allow-clear="{{ $allowClear }}" {{ $required ?? '' }}
    {{ $attributes }}>
    {{ $slot }}
</select>
{{-- <select id="{{ $id }}" name="{{ $name }}"
    class="select-with-search form-select @error($name) is-invalid @enderror"
    data-allow-clear="{{ $allowClear }}"
    data-control="select2"
    {{ $attributes }}>
    {{ $slot }}
</select> --}}

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
