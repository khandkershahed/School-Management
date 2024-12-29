<input class="form-control form-control-solid @error($name)is-invalid @enderror" id="{{ $id ?? '' }}"
    type="{{ $type ?? 'text' }}" name="{{ $name }}" step="0.01"
    placeholder="{{ $placeholder ?? 'Complete the field' }}" maxlength="250" value="{{ old($name, $value ?? '') }}"
    aria-label="{{ $placeholder ?? 'input' }} example" {{ $required ?? '' }}>

@error($name)
    <div class="error invalid-feedback">
        {{ $message }}
    </div>
@enderror
