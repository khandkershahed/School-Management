<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['nullable', 'string', 'max:255'],
            'username'     => ['nullable', 'string', 'max:255'],
            'designation'  => ['nullable', 'string', 'max:200'],
            'phone'        => ['nullable', 'string', 'max:200'],
            'photo'        => ['nullable', 'image'],
            'country'      => ['nullable', 'string', 'max:200'],
            'city'         => ['nullable', 'string', 'max:200'],
            'zipcode'      => ['nullable', 'string', 'max:200'],
            'address'      => ['nullable', 'string', 'max:200'],
            'youtube'      => ['nullable', 'string', 'max:200'],
            'facebook'     => ['nullable', 'string', 'max:200'],
            'twitter'      => ['nullable', 'string', 'max:200'],
            'linkedin'     => ['nullable', 'string', 'max:200'],
            'website'      => ['nullable', 'string', 'max:200'],
            'biometric_id' => ['nullable', 'string', 'max:200'],
            'email'        => ['nullable', 'email',  'max:255', Rule::unique(Admin::class)->ignore($this->user()->id)],
        ];
    }
}
