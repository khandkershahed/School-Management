@props(['id', 'name', 'rows' => 2])

<textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}"
    class="form-control form-control-solid @error($name) is-invalid @enderror"
    {{ $attributes }} style="height: 100%">{{ old($name, $slot) }}</textarea>

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
