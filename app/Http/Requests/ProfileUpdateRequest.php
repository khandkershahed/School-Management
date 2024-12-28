<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'title'                         => 'nullable|in:Mr,Mrs,Ms',
            'first_name'                    => 'required|string|max:255',
            'last_name'                     => 'required|string|max:255',
            'password'                      => ['required', 'string', 'min:8', 'confirmed'],
            // 'password'                      => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'                         => 'nullable|string|max:15',
            'address_one'                   => 'required|string|max:255',
            'address_two'                   => 'nullable|string|max:255',
            'zipcode'                       => 'required|string|max:10',
            'state'                         => 'required|string|max:100',
            'company_name'                  => 'nullable|string|max:255',
            'company_registration_number'   => 'nullable|string|max:255',
            'company_vat_number'            => 'nullable|string|max:255',
            'selling_platforms'             => 'nullable|string',
            'customer_type'                 => 'nullable|string',
            'referral_source'               => 'nullable|string|max:255',
            'buying_group_membership'       => 'nullable|string|max:255',
            'website_address'               => 'nullable|url',
            'buying_group_name'             => 'nullable|string|max:255',
            'current_suppliers'             => 'nullable|string',
            'annual_spend'                  => 'nullable|string',
            'newsletter_preference'         => 'nullable',
            'terms_condition'               => 'required',
        ];
    }
}
