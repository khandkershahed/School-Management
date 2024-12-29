<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'total_student' => User::count(),
        ];

        return view('admin.dashboard', $data);
    }

    
}
