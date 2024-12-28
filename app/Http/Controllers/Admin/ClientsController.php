<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Notification;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'clients' => User::latest('id')->get(),
        ];

        return view("admin.pages.clients.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.clients.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $code = generateCode(User::class, 'AMSC');
            // upload thumbnail and set the name
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'clients/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }


            // create client
            $userSchema = User::create([
                'name'                      => $request->name,
                'client_id'                 => $code,
                'email'                     => $request->email,
                'phone'                     => $request->phone,
                'company_name'              => $request->company_name,
                'tax_registration_number'   => $request->tax_registration_number,
                // 'type'                      => $request->supplierType,
                'address'                   => $request->address,
                'status'                    => $request->status,
                'isSendEmail'               => $request->isSendEmail,
                'isSendSMS'                 => $request->isSendSMS,
                'image'                     => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
            ]);

            //send welcome notification
            try {
                if ($request->isSendEmail || $request->isSendSMS) {
                    Notification::send($userSchema, new WelcomeNotification($userSchema, [
                        'isSendEmail' => $request->isSendEmail,
                        'isSendSMS' => $request->isSendSMS,
                    ]));
                }
            } catch (Exception $e) {
                //handle email error here if necessary
                throw new Exception($e);
            }
            redirectWithSuccess('Client added successfully');
            return redirect()->route('admin.clients.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $data = [
                'client' => User::where('slug', $slug)->first(),
            ];

            return view("admin.pages.clients.show",$data);
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = [
                'client' => User::where('slug', $id)->first(),
            ];

            return view("admin.pages.clients.edit",$data);
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = User::where('id', $id)->first();
        $this->validate($request, [
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:20|min:3',
            'email'         => 'nullable|email|max:255|min:3|unique:users,email,' . $client->id,
            'company_name'  => 'nullable|string|max:100|min:2',
            'address'       => 'nullable|string|max:255',
        ]);
        try {
            // upload thumbnail and set the name
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'clients/' . $key;
                    $oldFile = $client->$key ?? null;

                    if ($oldFile) {
                        Storage::delete("public/" . $oldFile);
                    }
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }


            // create client
            $client->update([
                'name'                      => $request->name,
                'email'                     => $request->email,
                'phone'                     => $request->phone,
                'company_name'              => $request->company_name,
                'tax_registration_number'   => $request->tax_registration_number,
                // 'type'                      => $request->supplierType,
                'address'                   => $request->address,
                'status'                    => $request->status,
                'isSendEmail'               => $request->isSendEmail,
                'isSendSMS'                 => $request->isSendSMS,
                'image'                     => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
            ]);

            redirectWithSuccess('Client Updated successfully');
            return redirect()->route('admin.clients.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = User::where('id', $id)->first();
        $files = [
            'image' => $client->image,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $client->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $client->delete();
    }
}
