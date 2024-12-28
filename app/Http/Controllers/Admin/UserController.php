<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Events\ActivityLogged;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Mail\UserVerifyMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;


class UserController extends Controller
{
    /**
     * The constructor function sets middleware permissions for specific user actions in a PHP class.
     */
    public function __construct()
    {
        $this->middleware('permission:view user|create user|show user|edit user|delete user')->only(['index', 'create', 'show', 'edit', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.users.index', ['users' => User::get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.users.create', ['roles' => Role::get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name'                  => $request->first_name,
            'last_name'                   => $request->last_name,
            'email'                       => $request->email,
            'phone'                       => $request->phone,
            'address_one'                 => $request->address_one,
            'address_two'                 => $request->address_two,
            'zipcode'                     => $request->zipcode,
            'state'                       => $request->state,
            'country'                     => $request->country,
            'company_name'                => $request->company_name,
            'company_registration_number' => $request->company_registration_number,
            'company_vat_number'          => $request->company_vat_number,
            'selling_platforms'           => $request->selling_platforms,
            'customer_type'               => $request->customer_type,
            'referral_source'             => $request->referral_source,
            'buying_group_membership'     => $request->buying_group_membership,
            'website_address'             => $request->website_address,
            'buying_group_name'           => $request->buying_group_name,
            'current_suppliers'           => $request->current_suppliers,
            'annual_spend'                => $request->annual_spend,
            'newsletter_preference'       => $request->newsletter_preference,
            'terms_condition'             => $request->terms_condition,
            'status'                      => 'active',
            'password'                    => Hash::make($request->password),
        ]);

        event(new Registered($user));
        event(new ActivityLogged('User created', $user));

        return redirect()->back()->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $deliveredOrders = $user->order()->delivered()->get();
        $cancelledOrders = $user->order()->cancelled()->get();
        $totalPurchaseAmount = $deliveredOrders->sum('total_amount');
        return view('admin.pages.users.show', [
            'user'                => $user,
            'deliveredOrders'     => $deliveredOrders,
            'totalPurchaseAmount' => $totalPurchaseAmount,
            'cancelledOrders'     => $cancelledOrders,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.pages.users.edit', [
            'user' => User::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:' . User::class . ',email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'first_name'                  => $request->first_name ? $request->first_name                                  : $user->first_name,
            'last_name'                   => $request->last_name ? $request->last_name                                    : $user->last_name,
            'email'                       => $request->email ? $request->email                                            : $user->email,
            'phone'                       => $request->phone ? $request->phone                                            : $user->phone,
            'address_one'                 => $request->address_one ? $request->address_one                                : $user->address_one,
            'address_two'                 => $request->address_two ? $request->address_two                                : $user->address_two,
            'zipcode'                     => $request->zipcode ? $request->zipcode                                        : $user->zipcode,
            'state'                       => $request->state ? $request->state                                            : $user->state,
            'country'                     => $request->country ? $request->country                                        : $user->country,
            'company_name'                => $request->company_name ? $request->company_name                              : $user->company_name,
            'company_registration_number' => $request->company_registration_number ? $request->company_registration_number : $user->company_registration_number,
            'company_vat_number'          => $request->company_vat_number ? $request->company_vat_number                  : $user->company_vat_number,
            'selling_platforms'           => $request->selling_platforms ? $request->selling_platforms                    : $user->selling_platforms,
            'customer_type'               => $request->customer_type ? $request->customer_type                            : $user->customer_type,
            'referral_source'             => $request->referral_source ? $request->referral_source                        : $user->referral_source,
            'buying_group_membership'     => $request->buying_group_membership ? $request->buying_group_membership        : $user->buying_group_membership,
            'website_address'             => $request->website_address ? $request->website_address                        : $user->website_address,
            'buying_group_name'           => $request->buying_group_name ? $request->buying_group_name                    : $user->buying_group_name,
            'current_suppliers'           => $request->current_suppliers ? $request->current_suppliers                    : $user->current_suppliers,
            'annual_spend'                => $request->annual_spend ? $request->annual_spend                              : $user->annual_spend,
            'newsletter_preference'       => $request->newsletter_preference ? $request->newsletter_preference            : $user->newsletter_preference,
            'terms_condition'             => $request->terms_condition ? $request->terms_condition                        : $user->terms_condition,
            'status'                      => $request->status ? $request->status                                          : $user->status,
            'password'                    => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        event(new ActivityLogged('User updated', $user));

        return redirect()->back()->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        event(new ActivityLogged('User deleted', $user));
    }
    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 'active' ? 'inactive' : 'active';
        $user->save();
        Mail::to($user->email)->send(new UserVerifyMail($user->name));
        return response()->json(['success' => true]);
    }
}
