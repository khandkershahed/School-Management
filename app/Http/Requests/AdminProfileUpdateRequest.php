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
            'name' => ['string', 'max:255'],
            'username' => ['string', 'max:255'],
            'designation' => ['string', 'max:200'],
            'phone' => ['string', 'max:200'],
            'photo' => ['image'],
            'country' => ['string', 'max:200'],
            'city' => ['string', 'max:200'],
            'zipcode' => ['string', 'max:200'],
            'address' => ['string', 'max:200'],
            'youtube' => ['string', 'max:200'],
            'facebook' => ['string', 'max:200'],
            'twitter' => ['string', 'max:200'],
            'linkedin' => ['string', 'max:200'],
            'website' => ['string', 'max:200'],
            'biometric_id' => ['string', 'max:200'],
            'email' => ['email', 'max:255', Rule::unique(Admin::class)->ignore($this->user()->id)],
        ];
    }
}
