<div class="position-relative">
    <input id="{{ $id ?? '' }}"
        class="form-control form-control-lg form-control-solid password_input @error($name) is-invalid @enderror"
        type="password" placeholder="{{ $placeholder ?? '' }}" name="{{ $name }}" autocomplete="off"
        value="{{ old($name, $value ?? '') }}" required />
    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 toggle-password"
        data-kt-password-meter-control="visibility">
        <i class="fa-solid fa-eye-slash fs-6"></i>
        <i class="fa-solid fa-eye fs-6 d-none"></i>
    </span>
</div>
@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
<div class="d-flex align-items-center" data-kt-password-meter-control="highlight">
    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
</div>


